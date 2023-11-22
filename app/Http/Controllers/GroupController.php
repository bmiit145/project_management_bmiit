<?php

namespace App\Http\Controllers;

use App\Models\PanddingGroups;
use Illuminate\Http\Request;
use App\Models\CourseYear;
use App\Models\Student;
use App\Models\Group;
use App\Models\StudentGroup;
use App\Models\Faculty;
use App\Models\Allocation;
use Illuminate\Support\Facades\Auth;

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

        if ($studentGroups->isEmpty()) {
            $GroupNumber = 1;
        } else {
            $GroupNumber = StudentGroup::where('courseYearId', $request->courseYearId)->orderBy('groupid', 'desc')->first()->group->number + 1;
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

    public function getStudents(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
        ]);

        $courseYear = CourseYear::find($request->courseYearId);
        $students = $courseYear->course->programsemester->program->students;

        //         get student who is not in any group and pandding group for selected courseYear
        $students = $students->whereNotIn('enro', StudentGroup::where('courseYearId', $courseYear->first()->id)->pluck('studentenro'))->whereNotIn('enro', PanddingGroups::where('courseYearId', $courseYear->first()->id)->pluck('studentenro'));


        // if role is student
        if (Auth::user()->user() && Auth::user()->user->role == 0) {
            $students = $students->where('enro', '!=', Auth::user()->user->enro);
        }

        if ($students->isEmpty() || $students == null || $students == [] || $students == '' || $students->count() < 1) {
            return response()->json(['error' => 'No students found']);
        }
        return response()->json(['students' => $students]);
    }


//    student


    public function ViewStudentGroup()
    {
        $programId = Auth::user()->user->program->code;
        $enro = Auth::user()->user->enro;


        // get a courseYear where student is not enrolled in that group and program is same or not in pandding group
        $courseYears = CourseYear::whereHas('course.programsemester', function ($query) use ($programId) {
            $query->where('programCode', $programId);
        })->whereDoesntHave('studentGroups', function ($query) use ($enro) {
            $query->where('studentenro', $enro);
        })->whereDoesntHave('panddingGroups', function ($query) use ($enro) {
            $query->where('studentenro', $enro);
        })->get();


        //get student who is not in any group or pandding group for selected courseYear
        $students = Auth::user()->user->program->students->whereNotIn('enro', Auth::user()->user->enro);

        // get from session storage
        $courseYear = session('courseYear');
        if ($courseYear && $courseYear != null && $courseYear > 0) {
            $students = $students->whereNotIn('enro', StudentGroup::where('courseYearId', $courseYears->first()->id)->pluck('studentenro'))->whereNotIn('enro', PanddingGroups::where('courseYearId', $courseYears->first()->id)->pluck('studentenro'));
        }


        // get groups with number , students , courseYear , guide , project tile and definition
        $groups = StudentGroup::where('studentenro', $enro)->with('group', 'courseYear', 'group.allocation.faculty', 'group.project', 'group.studentGroups')->get();

        // get pandding groups where student is enrolled and same group number
        $panddingGroups = PanddingGroups::where('studentenro', $enro)->with('courseYear', 'student')->get();


        return view('student.viewStudentGroup', compact('courseYears', 'students', 'groups', 'panddingGroups'));
    }

    public function createStudentGroup(Request $request){
        $validated = $request->validate([
            'members' => 'required | array | min:1',
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'title' => 'required | string | max:255',
            'definition' => 'required | string',
        ]);
    }
}


