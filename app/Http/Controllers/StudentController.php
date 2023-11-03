<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseYear;

class StudentController extends Controller
{
    public function viewAllStudent()
    {

        $students = Student::all();

        return view('student.allStudent', compact(['students' => 'students']));
    }

    public function ViewAddStudentForm()
    {
        $courseYears = CourseYear::all();

        return view('student.addForm' , compact('courseYears'));
    }

    public function changeStudentStatus(request $request)
    {
        $validated = $request->validate([
            "username" => "required",
        ]);

        $student = Student::where('username', $request->username)->first();
        $student->status = !$student->status;
        $student->save();
        return response()->json([
            "success" => "Status Changed Successfully",
        ]);
    }


    public function create(request $request)
    {

        $validated = $request->validate([
            "enro" => "required | unique:students",
            "fname" => "required|min:2",
            "lname" => "required",
            "email" => 'required|email|unique:students',
            "contactno" => 'required|min:0|string|max:10',
            "courseYearId" => 'required',
        ]);

        $username = $validated['enro'];

        $student = new Student($validated);
        $student->username = $username;
        $student->save();


        if ($student->id) {
            User::create([
                'username'=> $username,
                'password' => Hash::make('password'),
                'role'=>0,
            ]);
        }

        return response()->json([
            "success" => "Student Added Successfully",
        ]);
    }

}