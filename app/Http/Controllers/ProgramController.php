<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{

    function getProgram(Request $request)
    {
        $program = Program::where('id', $request->id)->first();
        return response()->json($program);
    }

    function updateProgram(Request $request)
    {
        $validated = $request->validate([
            'id' => "required | exists:programs",
            'code' => "required",
            "name" => "required",
        ]);

        // update Program
        $program = Program::find($request->id);
        if ($program){
            $program->code = $request-> code;
            $program->name = $request->name;
            if($program->save()){
                return response()->json(["success" => "Program Updated"]);
            }else{
                return response()->json(["error" => "Something Went Wrong"]);
            }
        }else{
            return response()->json(["error" => "Id Not found"]);
        }
    }

    function getPrograms(Request $request)
    {
        $programs = Program::all();

        if (Auth::user()->role == 0) {
            $programId = Auth::user()->user->program->id;
            $programs = Program::where('id', $programId)->get();
        }
//        dd($programs);

        return response()->json($programs);
    }

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

        $program = new Program();
        $program->code = $validated['code'];
        $program->name = $validated['name'];
        $program->save();

        return response()->json(["success" => "Program added successfully"]);
    }
}
