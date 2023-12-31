<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $my_leave_balance =  auth()->user()->employee->getRemainingLeaveForCurrentYear();
        //return $my_leave_balance;
        return view('admin.modules.leave.create',compact('my_leave_balance'));
    }
    public function store(Request $request){
        //return $request->all();

        $inputs = $request->only(['leave_type','from_date','to_date','reason']);
        if(isset($request->is_half_day)){
            $inputs['is_half_day'] = .5;
            $inputs['half_day_type'] = $request->half_day_type;
        }
        $inputs['user_id'] = auth()->user()->id;
        $from = Carbon::parse($inputs['from']);
        return $from;
        $inputs['duration'] = Carbon::parse();
        LeaveApplication::create($inputs);
        return redirect()->to('module/leave')->with('message','Application submitted');
    }

    public function get_leave_count(){

    }

}
