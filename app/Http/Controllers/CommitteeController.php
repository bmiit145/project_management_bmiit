<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\Committee;
use App\Models\CourseYear;
use App\Models\CommitteeMember;

class CommitteeController extends Controller
{
    //view

    public function viewAllCommittees(request $request)
    {
        $committees = Committee::all();
        $committeeMembers = CommitteeMember::all()->sortBy('committee_id');
        $courseYears = CourseYear::all();
        $faculties = Faculty::where('status', 1)->get();
        return view('admin.viewAllCommittee', compact('committees', 'courseYears', 'committeeMembers', 'faculties'));
    }

    public function createCommittee(request $request)
    {
//        dd($request->all());

        $request->validate([
            'name' => 'required',
            'head' => 'required | numeric | exists:faculties,id',
            'courseYearId' => 'required | numeric | exists:course_years,id| unique:committees',
        ], [
            'name.required' => 'Please Enter Committee Name',
            'courseYearId.required' => 'Please Select Course Year',
            'courseYearId.numeric' => 'Please Select Course Year',
            'courseYearId.exists' => 'Please Select Course Year',
            'courseYearId.unique' => 'Committee Already Exists',
        ]);

        $committee = new Committee();
        $committee->name = $request->name;
        $committee->courseYearId = $request->courseYearId;
        $committee->save();

        // if no error occuer while creating committee then create committee members
        if($committee->id){
            $committeeId = $committee->id;

            // add head of committee
            $committeeMember = new CommitteeMember();
            $committeeMember->faculty_id = $request->head;
            $committeeMember->type = 0;
            $committeeMember->committee_id = $committeeId;
            $committeeMember->save();

            // add member of committee
            foreach ($request->members as $member) {
                if ($member == '-1'){
                    continue;
                }
                $committeeMember = new CommitteeMember();
                $committeeMember->faculty_id = $member;
                $committeeMember->type = 1;
                $committeeMember->committee_id = $committeeId;
                $committeeMember->save();
            }
        }else{
            return response()->json(['error' => 'Error While Creating Committee']);
        }
        return response()->json(['success' => 'Committee Created Successfully']);
    }
}
