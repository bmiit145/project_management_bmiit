<?php

namespace App\Http\Controllers;

use App\Models\EvaluationMark;
use App\Models\Panel;
use App\Models\Project;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use App\Models\CourseYear;
use App\Models\Schedule;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\PresentationPanel;
use App\Models\PanelProject;
use App\Models\EvaluationCriteria;
use App\Models\Mark;
use function PHPUnit\Framework\isEmpty;
use PDF;
use App\Mail\PresentationScheduleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Jobs\presentationScheduleJob;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class presentationController extends Controller
{
    public function sendMail(Request $request)
    {

        // example of sending mail to multiple users
        $numbers = ['wfsi@sghfuiods.com', '21bmiit145@gmail.com', 'sp8414sp@gmail.com', 'sutariyabhavik99@gmail.com', 'priyanksutariya0@gmail.com'];

//        foreach ($numbers as $number) {
        presentationScheduleJob::dispatch($numbers);
//        }
        return response()->json(['success' => 'Mail Sent Successfully']);
    }

    public function getPanels(Request $request)
    {
        $courseYearId = $request->courseYearId;
        $presentationPanels = PresentationPanel::where('courseYearId', $courseYearId)->get();

        $panels = [];
        foreach ($presentationPanels as $presentationPanel) {
            if (!$presentationPanel->panel) {
                continue;
            }

            $panels[] = $presentationPanel->panel;
        }
        return response()->json($panels);
    }


    public function getEvaluationCriteria(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
        ]);
        $evaluationCriteriaMarks = EvaluationMark::where('courseYearId', $request->courseYearId)->get();
        $evaluationCriteria = [];
        if ($evaluationCriteriaMarks->isEmpty()) {
            return response()->json($evaluationCriteria);
        }
        foreach ($evaluationCriteriaMarks as $evaluationCriteriaMark) {
            $evaluationCriteria[] = ["id" => $evaluationCriteriaMark->id, "name" => $evaluationCriteriaMark->evaluationCriteria->name];
        }
        return response()->json($evaluationCriteria);
    }

    public function getOutOf(Request $request)
    {
        $evaluationMarkId = $request->evaluationMarkId;
        $evaluationMark = EvaluationMark::where('id', $evaluationMarkId)->first();
        if ($evaluationMark) {
            return response()->json($evaluationMark->outof);
        } else {
            return response()->json(null);
        }
    }

    public function getOutOfByCriteriaId(Request $request)
    {
        $criteriaId = $request->criteriaId;
        $evaluationMark = EvaluationMark::where('criteriaId', $criteriaId)->first();

        if (!$evaluationMark) {
            return response()->json();
        }
        return response()->json($evaluationMark->outof);
    }

    public function getGroupMark(Request $request)
    {
        $validated = $request->validate([
            'groupId' => 'required | numeric | exists:groups,id',
            'evaluationMarkId' => 'required | numeric | exists:evaluation_marks,id',
        ]);

        $groupId = $request->groupId;
        $evaluationMarkId = $request->evaluationMarkId;

        $evaluationMark = EvaluationMark::where('id', $evaluationMarkId)->first();
        $marks = Mark::where('groupId', $groupId)->where('evaluationMarkId', $evaluationMark->id)->first();

        $project = Project::where('groupId', $groupId)->first();

        if ($marks) {
            $response['marks'] = $marks->marks;
        } else {
            $response['marks'] = null;
        }

        if ($project) {
            $response['project_title'] = $project->title;
        } else {
            $response['project_title'] = null;
        }

        return response()->json($response);
    }

    public function ViewAllPresentations()
    {
        return view('presentation.viewAllPresentations');
    }

    public function SchedulePresentation()
    {
        $courseYears = CourseYear::all();
        $schedules = Schedule::all();
        return view('presentation.schedulePresentation', compact('courseYears', 'schedules'));
    }

    public function createSchedule(Request $request)
    {
        $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'datetime' => 'required | date | after:today',
            'assessmentType' => 'required',
            // max 25M per file and max 5 files
            'attachments.*' => 'mimes:pdf,doc,docx,zip,jpeg,jpg,png,rar,txt | max:25000',
            'attachments' => 'array | max:5',
        ], [
            'courseYearId.required' => 'Please select a course year',
            'courseYearId.numeric' => 'Please select a valid course year',
            'courseYearId.exists' => 'Please select a valid course year',
            'datetime.required' => 'Please select a date and time',
            'datetime.date' => 'Please select a valid date and time',
            'datetime.after' => 'Please select date and time After Now',
            'assessmentType.required' => 'Please select an assessment type',
            'attachments.*.mimes' => 'Please select a valid file type as pdf,doc,docx,zip,jpeg,jpg,png,rar',
            'attachments.*.max' => 'Please select a file less than 25MB',
            'attachments.array' => 'Please select a valid file',
            'attachments.max' => 'Please select a maximum of 5 files',
        ]);

        $schedule = new Schedule();
        $schedule->courseYearId = $request->courseYearId;
        $schedule->datetime = $request->datetime;
        $schedule->assessmentType = $request->assessmentType;

        if ($schedule->save()) {
            //TODO: send email to all students
//            $emails = ['wfsi@sghfuiods.com', '21bmiit145@gmail.com', 'sp8414sp@gmail.com', 'sutariyabhavik99@gmail.com', 'priyanksutariya0@gmail.com'];

            // attachments array to store all file names for  attaching with mail
            $attachments = [];
            $attachmentPaths = [];

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $filename = rand(1111, 9999) . '_' . $attachment->getClientOriginalName();
                    $attachment->storeAs('attachments', $filename);
//                    $attachment->move(public_path('attachments'), $filename);

                    // Calculate expiration timestamp (e.g., 30 days from now)
//                    $expiration = Carbon::now()->addDays(30)->timestamp;

// Store file metadata (expiration timestamp) in the storage
//                    Storage::put("metadata/{$filename}.txt", $expiration);

                    $attachments[] = $filename;
                    $attachmentPaths[] = storage_path('app/attachments/' . $filename);
                }
            }
            $attachments = array_filter($attachments);
            $attachmentPaths = array_filter($attachmentPaths);

            // Fetching student emails
            $emails = Student::whereHas('studentGroups', function ($query) use ($request) {
                $query->where('courseYearId', $request->courseYearId);
            })->get()
                ->map(function ($student) {
                    return $student->email;
                })->toArray();

            if (!empty($emails)) {
                presentationScheduleJob::dispatch($emails, $request->emailBody, $request->datetime, $request->assessmentType, $attachmentPaths);
            }

            return response()->json([
                'success' => "Scheduled Successfully"
            ]);
        }

        return response()->json([
            'error' => "Something went wrong !"
        ]);
    }

    public function PresentationPanel()
    {
        $panels = Panel::all();
        $PresentationPanels = PresentationPanel::all();
        $faculties = Faculty::all();
        $courseYears = CourseYear::all();
        return view('presentation.presentationPanel', compact('panels', 'faculties', 'courseYears', 'PresentationPanels'));
    }

    public function createPresentationPanel(Request $request)
    {
        $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'members' => 'required | array | min:1',
        ], [
            'courseYearId.required' => 'Please select a course year',
            'courseYearId.numeric' => 'Please select a valid course year',
            'courseYearId.exists' => 'Please select a valid course year',
            'members.required' => 'Please select a faculty',
            'members.array' => 'Please select a valid faculty',
            'members.min' => 'Please select at Least One faculty',
        ]);

        $presentationPanels = PresentationPanel::where('courseYearId', $request->courseYearId)->get();
        // member unique but as per course year id as student must not repeat for each course id
        foreach ($request->members as $member) {
            if ($member == null || $member < 1) {
                continue;
            }
            $presentationPanel = $presentationPanels->where('facultyId', $member)->first();
            if ($presentationPanel) {
                return response()->json(['error' => 'Any faculty already exists in another panel']);
            }
        }

        if ($presentationPanels->isEmpty()) {
            $PanelNumber = 1;
        } else {
            $PanelNumber = PresentationPanel::where('courseYearId', $request->courseYearId)->orderBy('panelId', 'desc')->first()->panel->number + 1;
        }

        $panel = new Panel();
        $panel->number = $PanelNumber;
        if ($panel->save()) {
            $newPanelId = $panel->id;
            foreach ($request->members as $member) {
                if ($member == null || $member < 1) {
                    continue;
                }
                $presentationPanel = new PresentationPanel();
                $presentationPanel->panelId = $newPanelId;
                $presentationPanel->facultyId = $member;
                $presentationPanel->courseYearId = $request->courseYearId;
                $presentationPanel->save();
            }
            return response()->json([
                'success' => "Panel Created Successfully"
            ]);
        } else {
            return response()->json([
                'error' => "Something went wrong !"
            ]);
        }
    }

    public function AllocatePresentation(Request $request)
    {

        $panels = Panel::all();
        $PresentationPanels = PresentationPanel::all();
        $panelProjects = PanelProject::all();
        $faculties = Faculty::all();
        $courseYears = CourseYear::all();
        return view('presentation.viewAllPresentations', compact('panels', 'faculties', 'courseYears', 'PresentationPanels', 'panelProjects'));
    }

    public function createAllocatePresentation(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'group' => 'required | array | min:1',
            'panel' => 'required | numeric | exists:panels,id',
        ]);

        if (count($request->group) == 1 && $request->group[0] == '-1') {
            return response()->json(['error' => 'Please select atleast one group']);
        }
        $groups = $request->group;
        $update_groups = [];
        $create_groups = [];
        $error_groups = [];

        foreach ($groups as $group) {
            $panelProject = PanelProject::where('groupId', $group)->first();
            if ($panelProject) {
//                return response()->json(['error' => 'Group already allocated']);
                $panelProject->panelId = $request->panel;
                if ($panelProject->save()) {
                    $update_groups[] = $group;
                } else {
                    $error_groups[] = $group;
                }
                continue;
            }
            $panelProject = new PanelProject();
            $panelProject->panelId = $request->panel;
            $panelProject->groupId = $group;
            if ($panelProject->save()) {
                $create_groups[] = $group;
            } else {
                $error_groups[] = $group;
            }

        }
        return response()->json(['success' => 'Groups allocated successfully', 'update_groups' => $update_groups, 'create_groups' => $create_groups, 'error_groups' => $error_groups]);
    }


    public function viewAllEvaluationCriteria()
    {
        $evaluationCriteria = EvaluationCriteria::all();
        return view('presentation.viewAllEvaluationCriteria', compact('evaluationCriteria'));
    }

    public function createEvaluationCriteria(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required | string | max:255 | unique:evaluationcriteria,name',
        ],
            [
                'name.required' => 'Please enter a Evaluation Criteria',
                'name.string' => 'Please enter a valid Evaluation Criteria',
                'name.max' => 'Please enter a valid Evaluation Criteria',
                'name.unique' => 'Evaluation Criteria already exists',
            ]);

        $evaluationCriteria = new EvaluationCriteria();
        $evaluationCriteria->name = $request->name;
        if ($evaluationCriteria->save()) {
            return response()->json(['success' => 'Evaluation Criteria Created Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function ViewAllEvaluations()
    {

        $courseYears = CourseYear::all();
        $evaluationCriterias = EvaluationCriteria::all();
        $evaluationCriteriaMarks = EvaluationMark::all();
        return view('presentation.viewAllEvaluationMarks', compact('courseYears', 'evaluationCriterias', 'evaluationCriteriaMarks'));

    }

    public function createEvaluationCriteriaMarks(Request $request)
    {
//        dd($request->all());

        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'evaluationCriteria' => 'required',
            'outof' => 'required | numeric | min : 1',
        ]);
        //evaluationCriteria is numeric or not
        if (is_numeric($request->evaluationCriteria)) {
            if ($request->etext) {
                return response()->json(['error' => "Invalid Evaluation Criteria  \n Number Not Allowed "]);
            }
            $ecriteriaId = $request->evaluationCriteria;
        } else {
            $ec = EvaluationCriteria::where('name', $request->evaluationCriteria)->first();
            if ($ec === null || empty($ec->count()) || $ec->count() === "") {
                $ec = new EvaluationCriteria();
                $ec->name = $request->evaluationCriteria;
                if ($ec->save()) {
                    $ecriteriaId = $ec->id;
                } else {
                    return response()->json(['error' => 'New Evaluation Criteria Not Created']);
                }
            } else {

                return response()->json(['error' => 'Evaluation Criteria already exists']);
            }
        }

        $evaluationCriteriaMark = EvaluationMark::where('courseYearId', $request->courseYearId)->where('criteriaId', $ecriteriaId)->first();

        if ($evaluationCriteriaMark) {
            $studentMarks = Mark::where('evaluationMarkId', $evaluationCriteriaMark->id)->get();
//            dd($studentMarks);
            foreach ($studentMarks as $studentMark) {
                if ($studentMark->marks > $request->outof) {
                    return response()->json(['error' => 'Out of marks must be greater than or equal to student marks']);
                }
            }
            $evaluationCriteriaMark->outof = $request->outof;
            if ($evaluationCriteriaMark->save()) {
                return response()->json(['success' => 'Evaluation Criteria Marks Updated Successfully']);
            } else {
                return response()->json(['error' => 'Something went wrong']);
            }
        } else {
            $newEvaluationCriteriaMark = new EvaluationMark();
            $newEvaluationCriteriaMark->courseYearId = $request->courseYearId;
            $newEvaluationCriteriaMark->criteriaId = $ecriteriaId;
            $newEvaluationCriteriaMark->outof = $request->outof;
            if ($newEvaluationCriteriaMark->save()) {
                return response()->json(['success' => 'Evaluation Criteria Marks Created Successfully']);
            } else {
                return response()->json(['error' => 'Something went wrong']);
            }
        }
    }

    public function EvaluationStudentMarks()
    {
        $courseYears = CourseYear::all();
        $evaluationCriterias = EvaluationCriteria::all();
        $evaluationCriteriaMarks = EvaluationMark::all();
        $groups = Student::all();
        $marks = Mark::all();
        return view('presentation.EvaluationStudentMarks', compact('courseYears', 'evaluationCriterias', 'evaluationCriteriaMarks', 'groups', 'marks'));
    }

    public function createEvaluationStudentMarks(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'groupId' => 'required | numeric | exists:groups,id',
            'evaluationId' => 'required | numeric | exists:evaluation_marks,id',
            'marks' => 'required | numeric | min : 0',
        ]);
        // marks should be less than or equal to out of marks
        $evaluationMark = EvaluationMark::where('id', $request->evaluationId)->first();
        if ($request->marks > $evaluationMark->outof) {
            return response()->json(['error' => 'Marks must be less than or equal to out of marks']);
        }

        $marks = Mark::where('groupId', $request->groupId)->where('evaluationMarkId', $request->evaluationId)->first();
        if ($marks) {
            $marks->marks = $request->marks;
            if ($marks->save()) {
                return response()->json(['success' => 'Evaluation Marks Updated Successfully']);
            } else {
                return response()->json(['error' => 'Something went wrong']);
            }
        } else {
            $newMarks = new Mark();
            $newMarks->groupId = $request->groupId;
            $newMarks->evaluationMarkId = $request->evaluationId;
            $newMarks->marks = $request->marks;
            if ($newMarks->save()) {
                return response()->json(['success' => 'Evaluation Marks Created Successfully']);
            } else {
                return response()->json(['error' => 'Something went wrong']);
            }
        }
    }

    public function DownloadEvaluationSheet()
    {
        $courseYears = CourseYear::all();
        $evaluationCriterias = EvaluationCriteria::all();
        $evaluationCriteriaMarks = EvaluationMark::all();
        $groups = Student::all();
        $marks = Mark::all();
        return view('presentation.DownloadEvaluationSheet', compact('courseYears', 'evaluationCriterias', 'evaluationCriteriaMarks', 'groups', 'marks'));
    }

    public function DownloadEvaluationSheetPdf(Request $request)
    {
//        dd($request->all());

        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
            'withStudent' => 'required',
            'evaluation' => 'required | array | min:1',
        ]);


        $courseYearId = $request->courseYearId;
        $withStudent = $request->withStudent;
        $evaluations = $request->evaluation;

        if ($withStudent == "TRUE") {
            $withStudent = true;
        } else {
            $withStudent = false;
        }

//        $panel = PanelProject::join('panels', 'panel_projects.panelId', '=', 'panels.id')
//            ->join('groups', 'panel_projects.groupId', '=', 'groups.id')
////          ->join('projects', 'panel_projects.groupId', '=', 'projects.groupId')
//            ->join('student_groups' , 'groups.id' , '=' , 'student_groups.groupId')
//            ->join('course_years' , 'student_groups.courseYearId' , '=' , 'course_years.id')
//            ->join('courses' , 'course_years.course_id' , '=' , 'courses.id')
//            ->join('academicyears' , 'course_years.year_id' , '=' , 'academicyears.id')
//            ->join('students' , 'student_groups.studentenro' , '=' , 'students.enro')
//            ->join('programs' , 'students.programId' , '=' , 'programs.id')
//            ->where('courseYearId', $courseYearId)
//            ->get();

        $panel = PanelProject::with(['panel', 'group.studentGroups.courseYear.year', 'group.studentGroups.courseYear.course', 'group.studentGroups.student.program', 'group.studentGroups.student', 'group.project', 'group.studentGroups.courseYear.evaluationMark.evaluationCriteria'])
            ->whereHas('group.studentGroups', function ($query) use ($courseYearId) {
                $query->where('courseYearId', $courseYearId);
            })->get();

        $data = $panel->groupBy('panelId')->toArray();

        $course = CourseYear::where('id', $courseYearId)->first()->course;
        $code = $course->code;
        $cname = $course->name;

        if (empty($data)) {
            // return with error and status code as 404
            return response()->json(['error' => 'No Sheet found'], 404);
        }

//        return response()->json($data);
//        dd($panel->toArray());

        $pdf = PDF::loadView('presentation.DownloadEvaluationSheetpdf', compact('data', 'withStudent', 'code', 'cname', 'evaluations'));

        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultPaperSize' => 'A4',
            'defaultFont' => 'Arial',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'dpi' => 1500,
            'fontHeightRatio' => 1.5,
        ]);

        $pdf->setPaper('legal', 'landscape');
//        $pdf->setPaper('A3', 'landscape');
//        $pdf->setPaper('auto');

        $pdfContent = $pdf->output();

        //set name of download

        $filename = $code . '_' . $cname . '_EvaluationSheet';

        // Set response headers for PDF download
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
            'filename' => "$filename",
        ];

        return response($pdfContent, 200, $headers);
    }

}
