<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\TeamLeader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }

    public function index(){
        $results = Employee::with('user')->orderBy('attendance_id','desc')->paginate(20);
        //return $results;
        return view('admin.modules.employee.index',compact('results'));
    }

    public function create(){
        return view('admin.modules.employee.create');
    }

    public function store(Request $request){
        //return $request->all();
        $validatedUserData = $request->validate([
            'email' => 'required|email|unique:users',
        ]);
        // Create a new user
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2
        ]);

        $validatedEmployeeData = $request->validate([
            'attendance_id' => 'required|unique:employees',
            'fathers_name' => 'required',
            'phone_no' => 'required',
            'date_of_birth' => 'required|date',
            'religion' => 'required',
            'gender' => 'required',
            'category' => 'required',
            'date_of_joining' => 'required|date',
            'end_of_contract_date' => 'nullable|date',
            'marital_status' => 'required',
            'payment_mode' => 'required',
            'tin_no' => 'nullable',
            'vendor_code' => 'nullable',
            'designation' => 'required',
            'department' => 'required'
            // Add other validation rules for employee data
        ]);

        // Associate the employee with the user
        $employee = $user->employee()->create($validatedEmployeeData);

        // You can add a success message or redirect to another page
        return redirect()->route('employee.index')->with('success', 'Employee created successfully');
    }

    public function edit($id){
        $employee = Employee::find($id);
        return view('admin.modules.employee.edit',compact('employee'));
    }

    public function update(Request $request, $id){
        //return $request->all();
        Employee::find($id)->fill($request->all())->save();
        return redirect()->route('employee.index')->with('message','Employee updated');
    }

    public function checkEmailAvailability(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);
        return response()->json(['available' => true]);
    }

    public function manage_team_leader(){
        $results = TeamLeader::orderBy('id','desc')->get();
        //return $results-->user;
        return view('admin.modules.team_leader.index',compact('results'));
    }
    public function create_team_leader(){
        return view('admin.modules.team_leader.create');
    }
    public function team_leader_name_suggestion(Request $request){
        $employee_ids = Employee::where('department',$request->department)->pluck('user_id');
        $users = User::whereIn('id',$employee_ids)->where('name','LIKE','%'.$request->q.'%')->select('id','name')->get();
        $users->each(function($item){
            $item->value = $item->id;
            $item->text = $item->name.' <span class="font-12 .font-italic"> - '.$item->employee->attendance_id.'</span>';
        });
        return $users->toArray();
    }
    public function save_team_leader(Request $request){
        $teamLeader = TeamLeader::where('department', $request->department)->first();
        if($teamLeader){
            $teamLeader->fill(['user_id'=>$request->user_id])->save();
        }else{
            TeamLeader::create([
                'user_id' => $request->user_id,
                'department' =>$request->department,
            ]);
        }
        return redirect()->to('module/manage_team_leader')->with('message','Team leader added');
    }

    public function delete_team_leader($id){
        TeamLeader::find($id)->delete();
        return redirect()->to('module/manage_team_leader')->with('message','Team leader deleted');
    }


}
