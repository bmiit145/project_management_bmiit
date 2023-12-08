<?php

namespace App\Http\Controllers;

use App\Models\PanddingGroups;
use App\Models\RejectGroup;
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

    public function ViewAllPanddingGroups()
    {
        // get all pandding groups with all row By groupNumber is distinct
        $panddingGroups = PanddingGroups::all()->unique('groupNumber');
        $faculties = Faculty::all();

        return view('admin.viewAllPanddingGroups',
            [
                'panddingGroups' => $panddingGroups,
                'faculties' => $faculties,
            ]);
    }

    public function delete($id)
    {
        // delete pandding group by groupNumber
        $panddingGroup = PanddingGroups::where('groupNumber', $id);
        if ($panddingGroup) {
            $rejectedGroup = new RejectGroup();
            $rejectedGroup->groupNumber = $panddingGroup->first()->groupNumber;
            $rejectedGroup->studentenro = $panddingGroup->first()->studentenro;
            $rejectedGroup->courseYearId = $panddingGroup->first()->courseYearId;
            $rejectedGroup->title = $panddingGroup->first()->title;
            $rejectedGroup->definition = $panddingGroup->first()->definition;
            $rejectedGroup->created_by = $panddingGroup->first()->created_by;

            if ($rejectedGroup->save()) {
                $panddingGroup = PanddingGroups::where('groupNumber', $id);
                $panddingGroup->delete();
                return redirect()->back()->with('success', 'Group deleted successfully');
            }
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function ApproveGroup(Request $request)
    {
//        dd($request->all());

        $validated = $request->validate([
            'title' => 'required | string | max:255',
            'definition' => 'required | string',
            'GroupNum' => 'required | numeric | exists:pandding_groups,groupNumber',
        ], [
            'GroupNum.exists' => 'Group number not exists',
        ]);

        // get pandding group by groupNumber
        $panddingGroup = PanddingGroups::where('groupNumber', $request->GroupNum)->with('courseYear', 'student', 'courseYear.course', 'courseYear.year')->get();

        if ($panddingGroup) {
            $courseYearId = $panddingGroup->first()->courseYearId;
            $studentGroups = StudentGroup::where('courseYearId', $courseYearId)->get();

            $members = $panddingGroup->pluck('studentenro');

            foreach ($members as $member) {
                $studentGroup = $studentGroups->where('studentenro', $member)->first();
                if ($studentGroup) {
                    return response()->json(['error' => 'Any students already exists in another group']);
                }
            }

            if ($studentGroups->isEmpty()) {
                $GroupNumber = 1;
            } else {
                $GroupNumber = StudentGroup::where('courseYearId', $courseYearId)->orderBy('groupid', 'desc')->first()->group->number + 1;
            }

            $group = new Group();
            $group->number = $GroupNumber;
            $group->created_by = $panddingGroup->first()->created_by;
            if ($group->save()) {
                $newgroupId = $group->id;
                foreach ($members as $member) {
                    if ($member == null || $member < 1) {
                        continue;
                    }
                    $studentGroup = new StudentGroup();
                    $studentGroup->studentenro = $member;
                    $studentGroup->groupid = $newgroupId;
                    $studentGroup->courseYearId = $courseYearId;
                    $studentGroup->status = 1;
                    $studentGroup->save();
                }

                if ($request->guide != null && $request->guide > 0) {
                    $allocation = new Allocation();
                    $allocation->studentgroupno = $newgroupId;
                    $allocation->facultyid = $request->guide;
                    $allocation->save();
                }

                // add project title and definition
                $group->project()->create([
                    'title' => $request->title,
                    'definition' => $request->definition,
                ]);

                // delete pandding group by groupNumber
                $panddingGroup = PanddingGroups::where('groupNumber', $request->GroupNum);
                if ($panddingGroup) {
                    $panddingGroup->delete();
                }
            } else {
                return respone()->json(['error' => 'Something went wrong']);
            }

            return response()->json(['success' => 'Group created successfully']);
        } else {
            return response()->json(['error' => 'Group Not Found']);
        }
    }

    public function getPanndingGroup(Request $request)
    {
        $validated = $request->validate([
            'groupNum' => 'required | numeric',
        ]);

        // get pandding group by groupNumber
        $panddingGroup = PanddingGroups::where('groupNumber', $request->groupNum)->with('courseYear', 'student', 'courseYear.course', 'courseYear.year')->get();

        if ($panddingGroup) {
            $arr = [];
            $arr[] = [
                'groupNumber' => $panddingGroup->first()->groupNumber,
                'code' => $panddingGroup->first()->courseYear->course->code,
                'course' => $panddingGroup->first()->courseYear->course->name,
                'year' => $panddingGroup->first()->courseYear->year->name,
                'title' => $panddingGroup->first()->title,
                'definition' => $panddingGroup->first()->definition,
            ];
            foreach ($panddingGroup as $group) {
//                $arr['member'] = [
//                    'enro' => $group->studentenro,
//                    'name' => $group->student->fname . $group->student->lname,
//                ];

                $arr[0]['member'][] = [
                    'enro' => $group->studentenro,
                    'fname' => $group->student->fname,
                    'lname' => $group->student->lname,
                ];
            }
            return response()->json($arr);
        }
        return response()->json(['error' => 'Something went wrong']);
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
            $students = $students->whereNotIn('enro', StudentGroup::where('courseYearId', $courseYear)->pluck('studentenro'))->whereNotIn('enro', PanddingGroups::where('courseYearId', $courseYear)->pluck('studentenro'));
        }


        // get groups with number , students , courseYear , guide , project tile and definition
        $groups = StudentGroup::where('studentenro', $enro)->with('group', 'courseYear', 'group.allocation.faculty', 'group.project', 'group.studentGroups')->get();

        // get pandding groups where student is enrolled and same group number
        $panddingGroups = PanddingGroups::where('studentenro', $enro)->with('courseYear', 'student')->get();


        return view('student.viewStudentGroup', compact('courseYears', 'students', 'groups', 'panddingGroups'));
    }

    public function createStudentGroup(Request $request)
    {
        $validated = $request->validate([
            'members' => 'required | array | min:1',
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'title' => 'required | string | max:255',
            'definition' => 'required | string',
        ]);
        $members = $request->members;
        $members[] = auth()->user()->user->enro;

        // member unique but as per course year id as student must not repeat for each course id
        $PanddingStudentGroups = PanddingGroups::where('courseYearId', $request->courseYearId)->get();
        $studentGroups = StudentGroup::where('courseYearId', $request->courseYearId)->get();
        foreach ($request->members as $member) {
            if ($member == null || $member < 1) {
                continue;
            }

            $panddingStudentGroup = $PanddingStudentGroups->where('studentenro', $member)->first();
            $studentGroup = $studentGroups->where('studentenro', $member)->first();

            if ($panddingStudentGroup || $studentGroup) {
                return response()->json(['error' => 'Any students already exists in another group']);
            }
        }

        // group number generate
        if ($PanddingStudentGroups->isEmpty()) {
            $GroupNumber = 1;
        } else {
            $GroupNumber = PanddingGroups::where('courseYearId', $request->courseYearId)->orderBy('groupNumber', 'desc')->first()->groupNumber + 1;
        }


        // save pandding group by each student
        foreach ($members as $member) {
            if ($member == null || $member < 1) {
                continue;
            }
            $panddingGroup = new PanddingGroups();
            $panddingGroup->groupNumber = $GroupNumber;
            $panddingGroup->studentenro = $member;
            $panddingGroup->courseYearId = $request->courseYearId;
            $panddingGroup->title = $request->title;
            $panddingGroup->definition = $request->definition;
            $panddingGroup->created_by = auth()->user()->username;
            $panddingGroup->save();
        }

        return response()->json(['success' => 'Group created successfully and waiting for approval']);
    }

    //   faculty

    public function ViewFacultyGroup(Request $request)
    {
        $facultyId = Auth::user()->user->id;
        // get all groups where faculty is guide with all row By groupId is distinct
        $groups = Allocation::where('facultyid', $facultyId)->with('group', 'group.project', 'group.studentGroups', 'group.studentGroups.courseYear')->get();
        return view('faculty.viewFacultyGroup', compact('groups'));
    }

    public function getGroup(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required | numeric | exists:groups,id',
        ]);

        $group = Group::where('id', $request->group_id)->with('project', 'studentGroups', 'studentGroups.courseYear', 'studentGroups.courseYear.course', 'studentGroups.courseYear.year', 'studentGroups.student')->first();

        // add length of group members in studentGroups
        $group->members = $group->studentGroups->count();
        return response()->json(['group' => $group]);
    }

    public function updateGroup(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required | numeric | exists:groups,id',
            'title' => 'required | string | max:255',
            'definition' => 'nullable | string',
        ], [
            'group_id.exists' => 'Group not found',
            'title.required' => 'Project Title is required',
            'title.string' => 'Project Title must be string',
            'title.max' => 'Project Title must be less than 255 characters',
            'definition.string' => 'Project Definition must be string',
        ]);

        $group = Group::find($request->group_id);
        if (!$group->project) {
            $group->project()->create([
                'title' => $request->title,
                'definition' => $request->definition,
            ]);
            return response()->json(['success' => 'Group updated successfully']);
        }
        $group->project->title = $request->title;
//        if ($request->definition != null && $request->definition != '' && $request->definition != 'undefined') {
        $group->project->definition = $request->definition;
//        }
        if ($group->project->save()) {
            return response()->json(['success' => 'Group updated successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }
}


