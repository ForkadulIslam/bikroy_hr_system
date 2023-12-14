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
use App\Online_expense;
use App\Order;
use App\Order_detail;
use App\Other_finance_payment;
use App\Other_finance_receive;
use App\Product;
use App\User;
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
        //return Auth::user();
        return redirect('module/banner');
    }



}
