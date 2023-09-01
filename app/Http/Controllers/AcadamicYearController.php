<?php

namespace App\Http\Controllers;

use App\Models\academicyear;
use Illuminate\Http\Request;

class AcadamicYearController extends Controller
{
    function viewAllYears()  {
        $years = academicyear::all();
        return view('admin.acadamicYears' , compact(['years' => "years"]));
    }


    function create(Request $request){
        
        $validated = $request->validate([
            "name" => "required|unique:academicyears",
        ], [
            'name.required' => 'The name field is required',
            'name.unique' => 'The Acadamic Year should be unique',
        ]);

        $program  = new academicyear();
        $program->name = $validated['name'];
        $program->save();

        return response()->json(["success"=> "Program added successfully"]);
    }
}
