<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramSemester;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
    function getSemesters(Request $request)
    {

        if (Auth::user()->role == 0) {
            $programId = Auth::user()->user->program->code;
            $programSemesters = ProgramSemester::where('programCode', $programId)->get();
            $semesters = Semester::whereIn('id', $programSemesters->pluck('semesterid'))->get();
            return response()->json($semesters);
        }

        if ($request->programId != null && $request->programId != "-1" && $request->programId != "") {
            $programId = $request->programId;
            $programSemesters = ProgramSemester::where('programCode', $programId)->get();
            $semesters = Semester::whereIn('id', $programSemesters->pluck('semesterid'))->get();
            return response()->json($semesters);
        }

        $semesters = Semester::all();

        return response()->json($semesters);
    }

    function ViewAllSemester()
    {

        $semester = Semester::all();

        return view('admin.semester', compact(['semester' => 'semester']));
    }


    function ViewAllProgramSemester()
    {

        $programSemesters = ProgramSemester::with('program')->with('semester')->get();

        $semesters = Semester::all();
        $programs = Program::all();

        return view('admin.Programsemester', compact(['programSemesters' => 'programSemesters', 'semesters' => 'semesters', 'programs' => 'programs']));
    }

    function createSemester(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:semesters',
        ]);

        $semester = new semester;
        $semester->name = $validated['name'];
        $semester->save();

        return response()->json(["success" => "Semester added successfully"]);
    }

    function createProgramSemester(Request $request)
    {
        $validated = $request->validate([
            'program' => 'required',
            'semester' => 'required',
        ]);

        $count = ProgramSemester::where('programCode', $validated['program'])->where('semesterid', $validated['semester'])->count();

        if ($count == 0) {
            $Programsemester = new ProgramSemester();
            $Programsemester->programCode = $validated['program'];
            $Programsemester->semesterid = $validated['semester'];
            $Programsemester->save();

            return response()->json(["success" => "ProgramSemester added successfully"]);
        } else {
            return response()->json(["error" => "Already exits"]);
        }
    }


}
