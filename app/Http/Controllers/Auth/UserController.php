<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view(){
        return view('auth.login');
    } 

    public function verify(Request $request ){
        dd(111);
    }
}

