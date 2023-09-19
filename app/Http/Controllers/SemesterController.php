<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramSemester;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    function ViewAllSemester(){

        $semester = Semester::all();

        return view('admin.semester' , compact(['semester'=>'semester']));
    }

    
    function ViewAllProgramSemester(){

        $programSemesters = ProgramSemester::with('program')->with('semester')->get();

        $semesters = Semester::all();
        $programs = Program::all();

        return view('admin.Programsemester',  compact(['programSemesters'=>'programSemesters' , 'semesters'=>'semesters' , 'programs'=>'programs']));
    }

    function createSemester(Request $request){
        $validated = $request->validate([
            'name'=>'required|unique:semesters',
        ]);

        $semester = new semester;
        $semester->name = $validated['name'];
        $semester->save();

        return response()->json(["success"=> "Semester added successfully"]);
    }

    function createProgramSemester(Request $request){
        $validated = $request->validate([
            'program'=>'required',
            'semester'=>'required',
        ]);

        $count = ProgramSemester::where('programCode' , $validated['program'])->where('semesterid' , $validated['semester'])->count();

        if ($count == 0) {
            $Programsemester = new ProgramSemester();
            $Programsemester->programCode = $validated['program'];
            $Programsemester->semesterid = $validated['semester'];
            $Programsemester->save(); 

        return response()->json(["success"=> "ProgramSemester added successfully"]);
        }else{
        return response()->json(["error"=> "Already exits"]);
        }
    }

    

}
