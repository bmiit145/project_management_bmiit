<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\CourseYear;
use App\Models\StudentGroup;
use App\Models\Faculty;
use App\Models\Allocation;

class allocationController extends Controller
{
    public function ViewAllAllocations()
    {
        $courseYears = CourseYear::all();
        $faculties = Faculty::all();
        $allocations = Allocation::all();
        return view('admin.viewAllAllocations', compact('courseYears', 'faculties', 'allocations'));
    }

    public function getGroups(Request $request)
    {
        $studentgroups = StudentGroup::where('courseYearId', $request->courseYearId)->get();

        $studentgroups = $studentgroups->groupBy('groupid');

//        dd($studentgroups);
        $groups = [];
        foreach ($studentgroups as $studentgroup) {
            $group = $studentgroup[0]->group;

            $project = Project::where('groupid', $studentgroup[0]->groupid)->first();
            if ($project != null) {
                $title = $project->title;
            } else {
                $title = null;
            }
            $group->title = $title;
            $groups[] = $group;
        }

        return response()->json($groups);
    }

    public function getGuide(request $request)
    {
        $allocation = Allocation::where('studentgroupno', $request->groupId)->get();
        if ($allocation->isEmpty()) {
            return response()->json();
        }
        $facultyId = $allocation->first()->facultyid;
        $project = Project::where('groupid', $request->groupId)->first();
        if ($project != null) {
            $title = $project->title;
        } else {
            $title = NULL;
        }
        return response()->json(['facultyId' => $facultyId, 'title' => $title]);
    }

    public function createAllocation(Request $request)
    {
        $validated = $request->validate([
            'groupId' => 'required | numeric | exists:groups,id',
            'facultyId' => 'required | numeric | exists:faculties,id',
            'courseYearId' => 'required | numeric | exists:course_years,id',
        ]);

        $allocation = Allocation::where('studentgroupno', $request->groupId)->get();
        if (!$allocation->isEmpty()) {
            $allocation = Allocation::where('studentgroupno', $request->groupId)->first();
            $allocation->facultyid = $request->facultyId;
            $allocation->save();
            return response()->json(['success' => 'Allocation updated successfully']);
        }

        $allocation = new Allocation();
        $allocation->studentgroupno = $request->groupId;
        $allocation->facultyid = $request->facultyId;
        $allocation->save();
        return response()->json(['success' => 'Allocation created successfully']);

    }
}
