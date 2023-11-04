<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Project;
use App\Models\Student;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use App\Models\CourseYear;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        if (session()->get('courseYear')) {
            $courseYearId = session()->get('courseYear');
        } else {
            $courseYearId = -1;
        }

        if ($courseYearId == -1) {
            $totalStudent = Student::all()->count();
            $InactiveStudent = Student::where('status', 0)->count();
            $ActiveStudent = Student::where('status', 1)->count();
            $activeFaculties = Faculty::where('status', 1)->count();
            $InactiveFaculties = Faculty::where('status', 0)->count();
            $totalFaculties = Faculty::all()->count();
            $totalGroups = Group::all()->count();
            $projectAllocated = Project::all()->count();
            $projectNotAllocated = Group::all()->count() - Project::all()->count();
            $GroupWithoutGuide = Group::all()->count() - Allocation::all()->count();
            $GroupWithGuide = Allocation::all()->count();
            $GroupWithoutProject = Group::all()->count() - Project::all()->count();
            $GroupWithProject = Project::all()->count();

//        $groupsInAllocation = Allocation::distinct()->pluck('studentgroupno')->toArray();
//        $groupsInProject = Project::distinct()->pluck('groupId')->toArray();
//        $commonGroups = array_intersect($groupsInAllocation, $groupsInProject);
//        $GroupWithGuideWithoutProject = count($commonGroups);

            $GroupWithGuideWithoutProject = Allocation::select('studentgroupno')
                ->join('projects', 'allocations.studentgroupno', '!=', 'projects.groupId')
                ->distinct('allocations.studentgroupno')
                ->count('allocations.studentgroupno');

            $GroupWithGuideWithProject = Allocation::select('studentgroupno')
                ->join('projects', 'allocations.studentgroupno', '=', 'projects.groupId')
                ->distinct('allocations.studentgroupno')
                ->count('allocations.studentgroupno');


        } else {

            $totalStudent = Student::all()->count();
            $InactiveStudent = Student::where('courseYearId', $courseYearId)->where('status', 0)->count();
            $ActiveStudent = Student::where('courseYearId', $courseYearId)->where('status', 1)->count();
            $activeFaculties = Faculty::where('status', 1)->count();
            $InactiveFaculties = Faculty::where('status', 0)->count();
            $totalFaculties = Faculty::all()->count();
            $totalGroups = StudentGroup::where('courseYearId', $courseYearId)->distinct('groupid')->count();
            $project = Project::whereIn('id', function ($query) use ($courseYearId) {
                $query->select('projects.id')
                    ->from('projects')
                    ->join('student_groups', 'projects.groupid', '=', 'student_groups.groupid')
                    ->distinct('student_groups.groupid')
                    ->where('student_groups.courseyearid', $courseYearId);
            })->get();

            $projectAllocated = $project->count();

            $projectNotAllocated = $totalGroups - $projectAllocated;
            $GroupWithoutProject = $totalGroups - $projectAllocated;

            $GroupWithGuide = Allocation::select('allocations.studentgroupno')
                ->join('student_groups', 'allocations.studentgroupno', '=', 'student_groups.groupid')
                ->distinct('student_groups.groupid')
                ->where('student_groups.courseyearid', $courseYearId)
                ->count();

            $GroupWithoutGuide = $totalGroups - $GroupWithGuide;

            $GroupWithProject = $projectAllocated;

            $GroupWithGuideWithProject = Allocation::select('allocations.studentgroupno')
                ->join('student_groups', 'allocations.studentgroupno', '=', 'student_groups.groupid')
                ->join('projects', 'allocations.studentgroupno', '!=', 'projects.groupid')
                ->distinct('student_groups.groupid')
                ->where('student_groups.courseyearid', $courseYearId)
                ->count();

            $GroupWithGuideWithoutProject = Allocation::select('allocations.studentgroupno')
                ->join('student_groups', 'allocations.studentgroupno', '=', 'student_groups.groupid')
                ->join('projects', 'allocations.studentgroupno', '=', 'projects.groupid')
                ->distinct('student_groups.groupid')
                ->where('student_groups.courseyearid', $courseYearId)
                ->count();
        }
        return view('admin.dashboard', compact('totalStudent', 'InactiveStudent', 'ActiveStudent', 'activeFaculties', 'InactiveFaculties', 'totalFaculties', 'totalGroups', 'projectAllocated', 'projectNotAllocated', 'GroupWithoutGuide', 'GroupWithGuide', 'GroupWithoutProject', 'GroupWithProject', 'GroupWithGuideWithoutProject', 'GroupWithGuideWithProject'));
    }
}
