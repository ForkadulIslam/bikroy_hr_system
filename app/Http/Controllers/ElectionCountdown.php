<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElectionCountdown extends Controller
{
    public function index(){
        return view('countdown_timer.election.index');
    }
}
