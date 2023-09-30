<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramSemester;
use App\Models\Course;

class CourseController extends Controller
{
    function ViewAllCourses()
    {
        $programsemesters = ProgramSemester::all();
        $courses = Course::all();
//        return view('admin.course', compact('programsemesters', 'courses'));
        return view('admin.course', compact(['programsemesters'=>'programsemesters', 'courses' => 'courses']));
    }

    function ViewAllCoursesYear()
    {
        return view('admin.courseYear');
    }

    function createCourse(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required | unique:courses,code',
            'programsemesterid' => 'required',
        ], [
            'code.required' => 'The code field is required',
            'code.unique' => 'The code field must be unique',
            'name.required' => 'The name field is required',
            'programsemesterid.required' => 'Select Program Semester',
        ]);

        $course = new Course();
        $course->code = $request->code;
        $course->name = $request->name;
        $course->programsemesterid = $request->programsemesterid;
        $course->save();
//        return redirect()->back()->with('success', 'Course Added Successfully');
        return response()->json(["success" => "Course added successfully"]);
    }

}
