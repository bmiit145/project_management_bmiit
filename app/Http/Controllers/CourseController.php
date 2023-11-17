<?php

namespace App\Http\Controllers;

use App\Models\academicyear;
use App\Models\CourseYear;
use Illuminate\Http\Request;
use App\Models\ProgramSemester;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    function setCourseYearSession(Request $request)
    {
        $request->session()->put('courseYear', $request->courseYearId);
        $request->session()->put('semester', $request->semesterId);
        $request->session()->put('program', $request->programId);


        return response()->json(["success" => "Session set successfully"]);

    }

    function ViewAllCourses()
    {
        $programsemesters = ProgramSemester::all();
        $courses = Course::all();
//        return view('admin.course', compact('programsemesters', 'courses'));
        return view('admin.course', compact(['programsemesters' => 'programsemesters', 'courses' => 'courses']));
    }

    function ViewAllCoursesYear()
    {

        $academicyears = academicyear::all();
        $courses = Course::all();
        $courseYears = CourseYear::all();
        return view('admin.courseYear', compact(['academicyears', 'courses', 'courseYears']));

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

        $count = CourseYear::where('course_id', $validated['courseid'])->where('year_id', $validated['academicyearid'])->count();

        if ($count == 0) {
            $courseYear = new CourseYear();
            $courseYear->course_id = $request->courseid;
            $courseYear->year_id = $request->academicyearid;
            $courseYear->save();

            return response()->json(["success" => "Course with Year added successfully"]);
        } else {
            return response()->json(["error" => "Already exits"]);
        }
    }

    function getCourseYears(Request $request)
    {
        if ($request->programId == "-1" || $request->semesterId == "-1") {

            if ($request->programId == "-1" && $request->semesterId == "-1") {
                if (Auth::user()->role == 0) {
                    $programId = Auth::user()->user->program->code;
                    $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($programId) {
                        $query->where('programCode', $programId);
                    })->get();
                } else {
                    $courseYears = CourseYear::all();
                }
            } else {
                if ($request->programId == "-1") {
                    $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($request) {
                        $query->where('semesterid', $request->semesterId);
                    })->get();
                } else {

                    if (Auth::user()->role == 0) {
                        $programId = Auth::user()->user->program->code;
                        $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($programId) {
                            $query->where('programCode', $programId);
                        })->get();
                    } else {
                        $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($request) {
                            $query->where('programCode', $request->programId);
                        })->get();
                    }
                }
            }

            $response = [];
            if ($courseYears->count() == 0) {
                return response()->json([$response, "error" => "No course found"]);
            }
            foreach ($courseYears as $courseYear) {
                $response[] = [
                    "id" => $courseYear->id,
                    "course" => $courseYear->course,
                    "year" => $courseYear->year,
                ];
            }
            return response()->json($response);
        } else {
            $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($request) {
                $query->where('programCode', $request->programId)->where('semesterid', $request->semesterId);
            })->get();
            $response = [];
            if ($courseYears->count() == 0) {
                return response()->json([$response, "error" => "No course found"]);
            }
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
}
