<?php

namespace App\Http\Controllers;

use App\Branch_transaction;
use App\Category;
use App\Customer;
use App\Distribution;
use App\Expense;
use App\Instalment;
use App\Invoice;
use App\Invoice_detail;
use App\Models\User;
use App\Online_expense;
use App\Order;
use App\Order_detail;
use App\Other_finance_payment;
use App\Other_finance_receive;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class Admin extends Controller{
    public function __construct(){
        $this->middleware('RedirectIfNotAuthenticate');
    }
    public function index(){
        $leave_details =  auth()->user()->employee->getRemainingLeaveForCurrentYear();
        //return \App\Models\TeamLeader::where('user_id',auth()->user()->id)->first();
        return view('admin.dashboard', compact('leave_details'));
    }
    public function change_password(){
        return view('admin.modules.change_password.password_update_form');
    }

    public function save_change_password(Request $request){
        //return $request->new_password;
        $user_id =  Auth::user()->id;
        User::find($user_id)->fill([
            'password' => Hash::make($request->new_password)
        ])->save();
        return redirect()->to('module/change_password')->with('message', 'Password updated');
    }



}
