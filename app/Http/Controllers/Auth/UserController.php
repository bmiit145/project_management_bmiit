<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    // app/Http/Controllers/Auth/LoginController.php
    protected function guard()
    {
        if (auth()->user()->role == 0) {
            return Auth::guard('student');
        } elseif (auth()->user()->role == 1) {
            return Auth::guard('faculty');
        }

        return Auth::guard('web');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // $user = User::where('username' , $request->username)->first();

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // $user = Auth::login();
            // $user= Auth::guard('faculty');
            // Auth::login($user);

            if (auth()->user()->role == 0) {
                // return Auth::guard('student');

                dd("Student Login");
            } elseif (auth()->user()->role == 1) {
                // return Auth::guard('faculty');
                return view('faculty.dashboard');
            }

        } else {
            // dd("Not Login");
            return back()->with("error" , "credentials are not correct");
        }


    }
}