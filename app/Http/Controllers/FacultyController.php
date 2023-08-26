<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{

    public function viewAllFaculty(){

       $faculties =  Faculty::all();

        return view('faculty.allFaculty', compact(['faculties'=>'faculties']));
    }
    public function index(){
        return view('faculty.dashboard');
    }

    public function ViewAddFacultyForm()
    {
        return view('faculty.addForm');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            "fname" => "required|min:2",
            "lname" => "required",
            "designation" => "required",
            "email" => 'required|email|unique:faculties',
            "contactno" => 'required|min:0|string|max:10',
            "doj" => 'required|date',
        ]);

        $username = $validated['email'];

        $faculty = new Faculty($validated);
        $faculty->username = $username;
        $faculty->save();
        
        User::create([
            'username'=> $username,
            'password' => Hash::make('password'),
            'role'=>2
        ]);

        return response()->json([
            "success"=>"Inserted Successfully",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}