<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Faculty;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{


    public function viewAllFaculty(){

       $faculties =  Faculty::all();

        return view('faculty.allFaculty', compact(['faculties'=>'faculties']));

    }

    public function changeFacultyStatus(Request $request){

        $validated = $request->validate([
            "username" => "required",
        ]);

        $faculty = Faculty::where('username',$request->username)->first();
        $faculty->status = !$faculty->status;
        $faculty->save();
        return response()->json([
            "success"=>"Status Changed Successfully",
        ]);
    }
    public function index(){
        if (session()->get('courseYear')) {
            $courseYearId = session()->get('courseYear');
        } else {
            $courseYearId = -1;
        }

        if ($courseYearId == -1) {
            $studentGroups = Allocation::where('facultyid', auth()->user()->userInfo()->first()->id)->get();
        }else{
            $studentGroups = Allocation::where('facultyid', auth()->user()->userInfo()->first()->id)
                ->with('studentGroups')
                ->whereHas('studentGroups', function ($query) use ($courseYearId) {
                    $query->where('courseyearid', $courseYearId);
                })
                ->get();
        }

        return view('faculty.dashboard' , compact('studentGroups'));
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
