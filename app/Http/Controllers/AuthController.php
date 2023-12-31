<?php

namespace App\Http\Controllers;

use App\Models\InterestedUser;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class AuthController extends Controller{

    public function __construct(){
        $this->middleware('RedirectIfAuthenticate',['except'=>'logout']);
    }

    public function index(){
        return view('admin.login');
    }
    public function registration(Request $request)
    {
        //return $request->all();
        //return 'Test';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $r){

        if(Auth::attempt(['email'=>$r->email,'password'=>$r->password])){
            return redirect('admin');
        }else{
            return redirect()->back()->with('redirect_login_message',$r->email);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }



}
