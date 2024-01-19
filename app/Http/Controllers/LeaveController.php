<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\HolidayCalendar;
use App\Models\LeaveApplication;
use App\Models\TeamLeader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\size;

class LeaveController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index(){
        $results = LeaveApplication::orderBy('id','desc')->where('user_id',auth()->user()->id)->paginate(20);
        return view('admin.modules.leave.index',compact('results'));
    }
    public function create(){
        $leave_details =  auth()->user()->employee->getRemainingLeaveForCurrentYear();
        //return $leave_details;
        return view('admin.modules.leave.create',compact('leave_details'));
    }
    public function store(Request $request){
        $inputs = $request->only(['leave_type','from_date','to_date','reason']);

        $holidays = HolidayCalendar::whereBetween('holiday_date', [$inputs['from_date'], $inputs['to_date']])
            ->pluck('holiday_date')
            ->toArray();
        //return $holidays;
        $from = Carbon::parse($inputs['from_date']);
        $to = Carbon::parse($inputs['to_date']);
        $duration = 0;
        while ($from <= $to) {
            if ($from->dayOfWeek !== Carbon::FRIDAY && $from->dayOfWeek !== Carbon::SATURDAY && !in_array($from->toDateString(), $holidays)) {
                $duration++;
            }
            $from->addDay();
        }
        $inputs['duration'] = $duration;
        if((($inputs['duration'] == 1) && $inputs['from_date'] == $inputs['to_date']) && isset($request->is_half_day) && $request->leave_type != 'Earned Leave'){
            $inputs['is_half_day'] = 1;
            $inputs['half_day_type'] = $request->half_day_type;
            $inputs['duration'] = .5;
        }
        $inputs['user_id'] = auth()->user()->id;
        if(auth()->user()->employee->designation == "CEO"){
            $inputs['status'] = 'Approved';
        }
        //return $inputs;
        LeaveApplication::create($inputs);
        return redirect()->to('module/leave')->with('message','Application submitted');
    }

    public function edit($id){
        $leave = LeaveApplication::find($id);
        //return $leave;
        $leave_details =  auth()->user()->employee->getRemainingLeaveForCurrentYear();
        //return $leave_details;
        return view('admin.modules.leave.edit',compact('leave_details','leave'));
    }

    public function update(Request $request, $id){
        $inputs = $request->only(['leave_type','from_date','to_date','reason']);

        $holidays = HolidayCalendar::whereBetween('holiday_date', [$inputs['from_date'], $inputs['to_date']])
            ->pluck('holiday_date')
            ->toArray();
        //return $holidays;
        $from = Carbon::parse($inputs['from_date']);
        $to = Carbon::parse($inputs['to_date']);
        $duration = 0;
        while ($from <= $to) {
            if ($from->dayOfWeek !== Carbon::FRIDAY && $from->dayOfWeek !== Carbon::SATURDAY && !in_array($from->toDateString(), $holidays)) {
                $duration++;
            }
            $from->addDay();
        }
        $inputs['duration'] = $duration;
        if((($inputs['duration'] == 1) && $inputs['from_date'] == $inputs['to_date']) && isset($request->is_half_day) && $request->leave_type != 'Earned Leave'){
            $inputs['is_half_day'] = 1;
            $inputs['half_day_type'] = $request->half_day_type;
            $inputs['duration'] = .5;
        }
        $inputs['user_id'] = auth()->user()->id;
        if(auth()->user()->employee->designation == "CEO"){
            $inputs['status'] = 'Approved';
        }
        //return $inputs;
        LeaveApplication::find($id)->fill($inputs)->save();
        return redirect()->to('module/leave')->with('message','Application updated');
    }

    public function destroy($id){
        LeaveApplication::find($id)->delete();
        return redirect()->to('module/leave')->with('message','Application deleted');
    }

    public function mange_team_leave(){
        $team_leader = TeamLeader::where('user_id',auth()->user()->id)->first();
        $department =  TeamLeader::where('user_id',auth()->user()->id)->pluck('department');
        $user_ids = Employee::whereIn('department',$department)->where('user_id','!=',auth()->user()->id)->pluck('user_id');
        $results = LeaveApplication::orderBy('id','desc')->whereIn('user_id',$user_ids)->paginate(20);
        return view('admin.modules.leave.team_leave',compact('results'));
    }
    public function team_leave_balance(){
        $team_leader = TeamLeader::where('user_id',auth()->user()->id)->first();
        if($team_leader){
            $department =  $team_leader->department;
            $results = Employee::where('department',$department)->where('user_id','!=',auth()->user()->id)->get();
            //return $employees->first()->getRemainingLeaveForCurrentYear();
            return view('admin.modules.leave.team_leave_balance',compact('results'));
        }
    }
    public function show_team_leave_balance($employee_id){
        $employee = Employee::find($employee_id);
        //return $employee;
        $leave_details =  $employee->getRemainingLeaveForCurrentYear();
        return view('admin/modules/leave/show_team_leave_balance',compact('employee','leave_details'));
    }
    public function update_leave_status($leave_id, $leave_status){
        LeaveApplication::find($leave_id)->fill(['status'=>$leave_status])->save();
        return response()->json([
            'success'=>true,
        ]);
    }
    public function manage_tl_leave(){
        $team_leader_ids = TeamLeader::where('user_id','!=',auth()->user()->id)->pluck('user_id');
        $results = LeaveApplication::orderBy('id','desc')->whereIn('user_id',$team_leader_ids)->paginate(20);
        return view('admin.modules.leave.tl_leave',compact('results'));
    }
    public function tl_leave_balance(){
        $team_leader_ids = TeamLeader::where('user_id','!=',auth()->user()->id)->pluck('user_id');
        $results = Employee::whereIn('user_id',$team_leader_ids)->get();
        //return $employees->first()->getRemainingLeaveForCurrentYear();
        return view('admin.modules.leave.tl_leave_balance',compact('results'));
    }
    public function leave_report(){
        if(auth()->user()->role_id != 1) return abort(404);
        $department = request()->department ? request()->department : 'Business Development';
        //return $department;
        $results = Employee::where('department',$department)->get();
        return view('admin.modules.leave.department_wise_employee_list',compact('results','department'));

    }

}
