<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseYear;
use App\Models\Student;
use App\Models\Group;
use App\Models\StudentGroup;
use App\Models\Faculty;
use App\Models\Allocation;

class GroupController extends Controller
{
    public function ViewAllGroups()
    {
        $courseYears = CourseYear::all();
        $faculties = Faculty::all();
        $students = Student::all();
        $studentGroups = StudentGroup::all();

        return view('admin.viewAllGroups', ['courseYears' => $courseYears, 'students' => $students, 'studentGroups' => $studentGroups, 'faculties' => $faculties]);
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'members' => 'required | array | min:1',
            'courseYearId' => 'required | numeric | exists:course_years,id',
//            'guide' => 'numeric | exists:faculties,id'
        ]);



        $studentGroups = StudentGroup::where('courseYearId', $request->courseYearId)->get();
        // member unique but as per course year id as student must not repeat for each course id
        foreach ($request->members as $member) {
            if ($member == null || $member < 1) {
                continue;
            }
            $studentGroup = $studentGroups->where('studentenro', $member)->first();
            if ($studentGroup) {
                return response()->json(['error' => 'Any students already exists in another group']);
            }
        }


        // find the next group number
        if ($studentGroups) {
            $GroupNumber = 1;
        } else {
            $GroupNumber = $studentGroups->orderBy('groupid', 'desc')->first()->group->number + 1;
        }

        $group = new Group();
        $group->number = $GroupNumber;
        $group->created_by = auth()->user()->username;
        if ($group->save()) {
            $newgroupId = $group->id;
            foreach ($request->members as $member) {

                if ($member == null || $member < 1) {
                    continue;
                }
                $studentGroup = new StudentGroup();
                $studentGroup->studentenro = $member;
                $studentGroup->groupid = $newgroupId;
                $studentGroup->courseYearId = $request->courseYearId;
                $studentGroup->status = 1;
                $studentGroup->save();
            }

            if ($request->guide != null && $request->guide > 0) {
                $allocation = new Allocation();
                $allocation->studentgroupno = $newgroupId;
                $allocation->facultyid = $request->guide;
                $allocation->save();
            }

        } else {
            return respone()->json(['error' => 'Something went wrong']);
        }

        return response()->json(['success' => 'Group created successfully']);
    }
}
