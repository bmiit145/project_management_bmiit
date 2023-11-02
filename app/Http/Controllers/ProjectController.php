<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Project;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use App\Models\CourseYear;

class ProjectController extends Controller
{
    public function ViewAllProjects()
    {
        $courseYears = CourseYear::all();
        $allocations = Allocation::all();
        $studentGroups = StudentGroup::all();
        return view('admin.viewAllProjects', compact('courseYears', 'allocations' , 'studentGroups'));
    }

    public function getProject(Request $request)
    {
        $project = Project::where('groupid', $request->groupId)->first();
        if ($project != null) {
            $title = $project->title;
            $definition = $project->definition;
        } else {
            return response()->json();
        }
        return response()->json(['title' => $title, 'definition' => $definition]);
    }

    public function createProject(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'groupId' => 'required | numeric | exists:groups,id',
            'title' => 'required | string | max:255',
            'definition' => ' max:255',
        ],
            [
                'courseYearId.required' => 'Please Select Course Year',
                'courseYearId.exists' => 'Please Select Valid Course Year',
                'groupId.required' => 'Please Select Group',
                'groupId.exists' => 'Please Select Valid Group',
                'title.required' => 'Please Enter Project Title',
                'title.max' => 'Project Title Should Not Exceed 255 Characters',
                'definition.max' => 'Project Definition Should Not Exceed 255 Characters',
            ]);

        $project = Project::where('groupid', $request->groupId)->first();
        if ($project != null) {
            $project->title = $request->title;
            $project->definition = $request->definition;
            $project->save();
            return response()->json(['success' => 'Project Updated Successfully']);
        } else {
            $project = new Project();
            $project->groupid = $request->groupId;
            $project->title = $request->title;
            $project->definition = $request->definition;
            $project->save();
        return response()->json(['success' => 'Project Created Successfully']);
        }
    }
}
