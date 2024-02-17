<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\HolidayCalendar;
use App\Models\LeaveApplication;
use App\Models\TeamLeader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $leave_types = leave_type_array();
        //return $leave_types;
        $employee_gender = Employee::where('user_id',auth()->user()->id)->first()->gender;
        if($employee_gender == 'Male'){
            unset($leave_types['Maternity Leave for 1st Child']);
            unset($leave_types['Maternity Leave for 2nd Child']);
        }else{
            unset($leave_types['Maternity Leave for 1st Child']);
            unset($leave_types['Maternity Leave for 2nd Child']);
        }
        //return $leave_types;
        //return $leave_details;
        return view('admin.modules.leave.create',compact('leave_details','leave_types'));
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
        $department = auth()->user()->employee->department;

        $team_leader = TeamLeader::where('department', $department)->first();
        $team_leader_id = $team_leader ? $team_leader->user_id : null;
        $email_to = null;
        if($team_leader_id == auth()->user()->id){
            $email_to = 'eshita@bikroy.com';
        }else{
            $email_to = User::find($team_leader_id)->email;
        }

        if(auth()->user()->employee->designation == "CEO"){
            $email_to = 'eshita@bikroy.com';
            $inputs['status'] = 'Approved';
        }
        //return $email_to;
        $leave_balance = Employee::where('user_id', auth()->user()->id)->first()->getRemainingLeaveForCurrentYear();
        $message = 'Application successfully submitted!!!';

        if($request->leave_type == 'Casual Leave'){
            if( $inputs['duration'] <= $leave_balance['casual_leave']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Casual Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Sick Leave'){
            if( $inputs['duration'] <= $leave_balance['sick_leave']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Sick Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Earned Leave'){
            if( $inputs['duration'] <= $leave_balance['earned_leave']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Earned Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Paternal Leave for 1st Child'){
            if( $inputs['duration'] <= $leave_balance['paternal_leave_for_first_child']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Paternal Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Paternity Leave for 2nd Child'){
            if( $inputs['duration'] <= $leave_balance['paternal_leave_for_second_child']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Paternity Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Maternity Leave for 1st Child'){
            if( $inputs['duration'] <= $leave_balance['maternity_leave_for_first_child']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Maternity Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Maternity Leave for 2nd Child'){
            if( $inputs['duration'] <= $leave_balance['maternity_leave_for_second_child']['balance']){
                LeaveApplication::create($inputs);
                $this->email_notification_of_leave_application('Maternity Leave',$email_to, $inputs['from_date'], $inputs['to_date']);
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }

        return redirect()->to('module/leave')->with('message',$message);
    }

    public function edit($id){
        $leave = LeaveApplication::find($id);
        //return $leave;
        $leave_details =  auth()->user()->employee->getRemainingLeaveForCurrentYear();
        //return $leave_details;
        $leave_types = leave_type_array();
        //return $leave_types;
        $employee_gender = Employee::where('user_id',auth()->user()->id)->first()->gender;
        if($employee_gender == 'Male'){
            unset($leave_types['Maternity Leave for 1st Child']);
            unset($leave_types['Maternity Leave for 2nd Child']);
        }else{
            unset($leave_types['Maternity Leave for 1st Child']);
            unset($leave_types['Maternity Leave for 2nd Child']);
        }
        return view('admin.modules.leave.edit',compact('leave_details','leave','leave_types'));
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
        }else{
            $inputs['is_half_day'] = 0;
            $inputs['half_day_type'] = null;
        }
        $inputs['user_id'] = auth()->user()->id;
        if(auth()->user()->employee->designation == "CEO"){
            $inputs['status'] = 'Approved';
        }
        //return $inputs;
        $leave_balance = Employee::where('user_id', auth()->user()->id)->first()->getRemainingLeaveForCurrentYear();
        $message = 'Application successfully submitted!!!';
        if($request->leave_type == 'Casual Leave'){
            if( $inputs['duration'] <= $leave_balance['casual_leave']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Sick Leave'){
            if( $inputs['duration'] <= $leave_balance['sick_leave']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Earned Leave'){
            if( $inputs['duration'] <= $leave_balance['earned_leave']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Paternal Leave for 1st Child'){
            if( $inputs['duration'] <= $leave_balance['paternal_leave_for_first_child']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Paternity Leave for 2nd Child'){
            if( $inputs['duration'] <= $leave_balance['paternal_leave_for_second_child']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Maternity Leave for 1st Child'){
            if( $inputs['duration'] <= $leave_balance['maternity_leave_for_first_child']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application submitted');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        if($request->leave_type == 'Maternity Leave for 2nd Child'){
            if( $inputs['duration'] <= $leave_balance['maternity_leave_for_second_child']['balance']){
                LeaveApplication::find($id)->fill($inputs)->save();
                return redirect()->to('module/leave')->with('message','Application updated');
            }else{
                $message = 'The application duration exceeds your leave balance';
            }
        }
        return redirect()->to('module/leave')->with('message', $message);
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

    public function email_notification_of_leave_application($application_type, $to, $from_date, $to_date){
        if(!$to) return false;
        $subject = 'Leave Application - '.auth()->user()->name;
        $htmlPart = '<p>Hi,</p>';
        $htmlPart.= '<p> <b>'.auth()->user()->name.'</b> submitted a leave application. Please approve or reject from this link below</p>';
        $htmlPart.= 'Go to HR system to <a href="hr.bikroytech.com/public">Check</a>';
        return sendMail($to,$subject,$htmlPart);
    }

}
