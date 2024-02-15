<?php

namespace App\Http\Controllers;

use App\Imports\AttendanceImport;
use App\Models\Employee;
use App\Models\HolidayCalendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index(){

        if(auth()->user()->role_id != 1) return abort(404);
        $department = request()->department ? request()->department : 'Business Development';
        $month = request()->month ? request()->month : Carbon::now()->monthName;
        $monthNumber = date_parse($month)['month'];
        if(Carbon::now()->month == $monthNumber){
            $from = Carbon::now()->startOfMonth()->toDateString();
            $to = Carbon::now()->toDateString();
        }else{
            $from = Carbon::now()->month($monthNumber)->startOfMonth()->toDateString();
            $to = Carbon::now()->month($monthNumber)->endOfMonth()->toDateString();
        }
        $holidays = HolidayCalendar::whereBetween('holiday_date', [$from, $to])
            ->pluck('holiday_date')
            ->toArray();
        //return $holidays;
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);
        $duration = 0;
        $office_days = [];
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        while ($from <= $to) {
            if ($from->dayOfWeek !== Carbon::FRIDAY && $from->dayOfWeek !== Carbon::SATURDAY && !in_array($from->toDateString(), $holidays)) {
                $office_days[] = $from->toDateString();
                $duration++;
            }
            $from->addDay();
        }
        $results = Employee::with(['attendance' => function ($query) use ($office_days) {
            $query->select('attendance_id', 'attendance_date', 'attendance_time')
                ->whereIn('attendance_date', $office_days)
                ->orderBy('attendance_date', 'asc') // Ensure the entries are ordered by date
                ->orderBy('attendance_time', 'asc');
        }])->select('user_id','attendance_id','designation','department','date_of_joining')->where('department', $department)->get();


        $results->each(function($item) use($currentYear, $office_days){
            $list_of_approved_leave_days = [];
            $approved_leave = $item->all_approved_leave()->whereYear('from_date',$currentYear)->get();
            foreach($approved_leave as $leave){
                $leave_from = Carbon::parse($leave->from_date);
                $leave_to = Carbon::parse($leave->to_date);
                while ($leave_from <= $leave_to) {
                    $list_of_approved_leave_days[] = $leave_from->toDateString();
                    $leave_from->addDay();
                }
            }
            //Log::info($list_of_approved_leave_days);
            unset($item->all_approved_leave);
            $attendance_log_in_out = [];
            collect($item->attendance)->groupBy('attendance_date')->map(function($group) use (&$attendance_log_in_out, $list_of_approved_leave_days){
                $late_min = 0;
                if (Carbon::parse($group->first()->attendance_time)->greaterThan(Carbon::parse('10:00:00'))) {
                    if(!in_array($group->first()->attendance_date, $list_of_approved_leave_days)){
                        $late_min = Carbon::parse($group->first()->attendance_time)->diffInMinutes(Carbon::parse('10:00:00'));
                    }
                }
                $attendance_log_in_out[$group->first()->attendance_date]['late_min'] = $late_min;
            });
            $item->attendance_log_in_out = $attendance_log_in_out;
            $attend_days = array_keys(collect($item->attendance)->groupBy('attendance_date')->toArray());
            $absent_days = [];
            foreach($office_days as $day){
                if(!in_array($day, $list_of_approved_leave_days) & !in_array($day, $attend_days)){
                    $absent_days[] = $day;
                }
            }
            $item->absent_days = $absent_days;
            unset($item->attendance);
        });
        //return $results;
        return view('admin.modules.attendance.department_wise_employee_list',compact('results','department','month'));
    }
    public function create(){
        return view('admin.modules.attendance.import');
    }
    public function store(Request $request){
        request()->validate([
            'attendance_data' => 'required|mimes:csv|max:2048'
        ]);
        Excel::import(new AttendanceImport, $request->file('attendance_data'));
        return redirect()->route('attendance.index')->with('message', 'Data processing is done');
    }
    public function attendance_log_by_user($user_id){
        //return Carbon::now()->monthName;
        $month = request()->month ? request()->month : Carbon::now()->monthName;
        $monthNumber = date_parse($month)['month'];
        if(Carbon::now()->month == $monthNumber){
            $from = Carbon::now()->startOfMonth()->toDateString();
            $to = Carbon::now()->toDateString();
        }else{
            $from = Carbon::now()->month($monthNumber)->startOfMonth()->toDateString();
            $to = Carbon::now()->month($monthNumber)->endOfMonth()->toDateString();
        }
        $user =  User::with(['employee.attendance'=>function($query)use($from, $to){
            $query->whereBetween('attendance_date',[$from, $to]);
        }])->find($user_id);
        //return $user;
        $month = request()->month ? request()->month : Carbon::now()->monthName;

        return view('admin.modules.attendance.user_attendance_log',compact('user','month'));
    }
}


