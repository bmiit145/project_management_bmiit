<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Password_reset;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

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
        if (auth()->user()) {
            if (auth()->user()->role == 0) {
                // return Auth::guard('student');
//                dd("Student Login");
                return redirect('student/dashboard');
            } elseif (auth()->user()->role == 1) {
                // return Auth::guard('faculty');
                return redirect('admin/dashboard');
            } elseif (auth()->user()->role == 2) {
                // return Auth::guard('faculty');
                return redirect('faculty/dashboard');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
//         $user = User::where('username' , $request->username)->first();

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

//        $credentials = $request->only('username', 'password');
        $remember = $request->filled('remember');


        if (Auth::attempt($credentials, $remember)) {
//            $user = Auth::login($user);
            // $user= Auth::guard('faculty');
            // Auth::login($user);
            if (auth()->user()->role == 0) {
                // return Auth::guard('student');
//                dd("Student Login");
                return redirect('student/dashboard');
            } elseif (auth()->user()->role == 1) {
                // return Auth::guard('faculty');
                return redirect('admin/dashboard');
            } elseif (auth()->user()->role == 2) {
                // return Auth::guard('faculty');
                return redirect('faculty/dashboard');
            }
            // $this->showDashboard();
        } else {
            // dd("Not Login");
            Auth::logout();
            return back()->with("error", "credentials are not correct");
        }
    }

    public function logout()
    {
        Auth::logout();
        Cookie::queue('rememberme', '', -1);
        echo '<script>window.sessionStorage.clear();</script>';

        return redirect('login');
    }

    public function showDashboard()
    {
        // dd(auth()->user()->role);
        if (auth()->user()->role == 0) {
            // return Auth::guard('student');
            dd("Student Login");
        } elseif (auth()->user()->role == 1) {
            // return Auth::guard('faculty');
            return redirect('admin/dashboard');
        } elseif (auth()->user()->role == 2) {
            // return Auth::guard('faculty');
            return redirect('faculty/dashboard');
        }
    }

    public function showForgotForm(Request $request)
    {
        return view('auth.forgotPassword');
    }

    public function forgotPassword(Request $request)
    {

        $validate = $request->validate([
            'email' => 'required | email',
        ]);

        $email = $request->email;

        $faculty = Faculty::where('email', $email)->first();
        $student = Student::where('email', $email)->first();

        $user = 0;
        if ($faculty) {
            $user = $faculty->user;
        } elseif ($student) {
            $user = $student->user;
        }

        if ($user) {
            $userEmail = $request->email;
            $random_str = Str::random(10);
            $token = encrypt($random_str);

            $reset_link = env('APP_URL') . "/resetpassword?email=" . $userEmail . "&token=" . $token;
            // dd($reset_link);

            $Data = [
                'reset_link' => $reset_link,
            ];

            Mail::to($userEmail)->send(new ForgotPasswordEmail($Data));

            $Password_reset = Password_reset::where('email', $userEmail);
            if ($Password_reset) {
                $Password_reset->delete();
            }

            Password_reset::create(
                [
                    'email' => $userEmail,
                    'token' => $token
                ]
            );
            return back()->with("success", "Mail sent successfully");


        } else {
            return back()->with("error", "User  Does not exits");
        }
    }

    public function resetPassword(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required | email',
            'token' => 'required'
        ]);

        $email = $request->email;
        $token = $request->token;

        $user = Password_reset::where('email', $email)->where('token', $token)->first();
        if ($user) {
            return view('auth.reset_password', compact(['mail_verified' => true, 'email' => 'email']));
        } else {
            return redirect('/login')->with("error", "Invalid URL");
        }
        dd($email, $token);
    }

    public function ChangePassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required | email',
            'password' => 'required',
        ]);

        $email = $request->email;

        $faculty = Faculty::where('email', $email)->first();
        $student = Student::where('email', $email)->first();

        $username = 0;
        if ($faculty) {
            $username = $faculty->username;
        } elseif ($student) {
            $username = $student->username;
        }

        if (!$username) {
            return back()->with("error", "User  Does not exits");
        }
        // $username = $user->username;

        $user = User::where('username', $username)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect('/login')->with("success", "Password Change Successfullty");
    }

    public function changePasswordPage()
    {
        if (!auth()->user()) {
            return back()->with(["error" => "User Not Login"]);
        }

        $username = auth()->user()->username;
        return view('auth.changePassword', compact(['username']));
    }

    public function NewChangePassword(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'old_password' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return back()->with(['error' => "User Not Found!"]);
        }
        if ($request->old_password ==  $request->password){
            return back()->with(['error' => "Password Should Not match with Old !"]);
        }
        if (Hash::check($request->old_password , $user->password)){
            $user->password = Hash::make($request->password) ;
            $user->save();
            Auth::logout();
            return redirect('login')->with(['success' => 'Password Changed']);
        }else{
            return back()->with(['error' => 'Invaild Password']);
        }
    }
}
