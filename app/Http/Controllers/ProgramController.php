<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Validation\Validator;

class ProgramController extends Controller
{
    //

    function viewAllPrograms()
    {

        $programs = Program::get();

        return view('admin.AllPrograms', compact(['programs' => 'programs']));
    }


    function create(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'code' => "required|unique:programs",
            "name" => "required",
        ], [
            'code.required' => 'The code field is required',
            'code.unique' => 'The code field must be unique',
            'name.required' => 'The name field is required',
        ]);

        $program  = new Program();
        $program->code = $validated['code'];
        $program->name = $validated['name'];
        $program->save();

        return response()->json(["success"=> "Program added successfully"]);
    }
}