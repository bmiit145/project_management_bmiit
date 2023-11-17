<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Program;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Group;
use App\Models\Project;
use App\Models\Committee;
use App\Models\AcadamicYear;
use App\Models\Semester;
use App\Models\Allocation;
use App\Models\CourseYear;
use App\Models\presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all();

        return view('student.dashboard', compact('students'));
    }

    public function viewAllStudent()
    {

        $students = Student::all();
        $courseYears = CourseYear::all();

        return view('student.allStudent', compact(['students' => 'students', 'courseYears' => $courseYears]));
    }

    public function ViewAddStudentForm()
    {
        $programs = Program::all();

        return view('student.addForm', compact('programs'));
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
            "programId" => 'required',
        ], [
            'enro.required' => 'Enrollment Number is required',
            'enro.unique' => 'Enrollment Number is already taken',
            'fname.required' => 'First Name is required',
            'lname.required' => 'Last Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'contactno.required' => 'Contact Number is required',
            'programId.required' => 'Program is required',
        ]);

        $username = $validated['enro'];

        $student = new Student($validated);
        $student->username = $username;

        if ($student->save()) {
            if ($student->id) {
                User::create([
                    'username' => $username,
                    'password' => Hash::make('password'),
                    'role' => 0,
                ]);
            }
        } else {
            return response()->json([
                "error" => "Student Not created",
            ]);
        }

        return response()->json([
            "success" => "Student Added Successfully",
        ]);
    }

}
