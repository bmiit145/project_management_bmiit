<?php

namespace App\Http\Controllers;

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

        $programSemester = ProgramSemester::all();

        return view('admin.Programsemester',  compact(['programSemester'=>'programSemester']));
    }


}
