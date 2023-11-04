<?php

namespace App\Http\Controllers;

use App\Models\academicyear;
use App\Models\CourseYear;
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

        $academicyears = academicyear::all();
        $courses = Course::all();
        $courseYears = CourseYear::all();
        return view('admin.courseYear', compact(['academicyears','courses' , 'courseYears']));

//        return view('admin.courseYear');
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

    function createCourseYear(Request $request)
    {
        $validated = $request->validate([
            'courseid' => 'required |numeric| min:0',
            'academicyearid' => 'required |numeric| min:0',
        ], [
            'courseid.required' => 'Select Course',
            'courseid.min' => 'Select Course',
            'academicyearid.required' => 'Select Year',
            'academicyearid.min' => 'Select Year',
        ]);

        // for unique course and year

        $count = CourseYear::where('course_id' , $validated['courseid'])->where('year_id' , $validated['academicyearid'])->count();

        if ($count == 0) {
            $courseYear = new CourseYear();
            $courseYear->course_id = $request->courseid;
            $courseYear->year_id = $request->academicyearid;
            $courseYear->save();

            return response()->json(["success" => "Course with Year added successfully"]);
        }else{
            return response()->json(["error" => "Already exits"]);
        }
    }

    function getCourseYears(Request $request)
    {
        $courseYears = CourseYear::all();
        $response = [];
        foreach ($courseYears as $courseYear) {
            $response[] = [
                "id" => $courseYear->id,
                "course" => $courseYear->course,
                "year" => $courseYear->year,
            ];
        }
        return response()->json($response);
    }
}
