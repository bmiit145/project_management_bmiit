<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\PanelProject;
use App\Models\Project;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use App\Models\CourseYear;
use PDF;

class ProjectController extends Controller
{
    public function ViewAllProjects()
    {
        $courseYears = CourseYear::all();
        $allocations = Allocation::all();
        $studentGroups = StudentGroup::all();
        return view('admin.viewAllProjects', compact('courseYears', 'allocations', 'studentGroups'));
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

    public function ProjectReportPage(Request $request)
    {
        $courseYears = CourseYear::all();
        return view('admin.projectReport', compact('courseYears'));
    }

    public function ProjectReport(Request $request)
    {
        $validated = $request->validate([
            'courseYearId' => 'required | numeric | exists:course_years,id',
        ],
            [
                'courseYearId.required' => 'Please Select Course Year',
                'courseYearId.exists' => 'Please Select Valid Course Year',
            ]);

        $courseYearId = $request->courseYearId;

        $data = StudentGroup::with(['student', 'group.project', 'group.allocation' , 'group.allocation.faculty'])
            ->where('courseYearId', $courseYearId)
            ->get()
            ->sortBy('student.enro')
            ->groupBy('groupid')
            ->sortKeys()
            ->toArray();

        $course = CourseYear::where('id', $courseYearId)->first()->course;
        $code = $course->code;
        $cname = $course->name;
        $year = CourseYear::where('id', $courseYearId)->first()->year->name;
        $program = CourseYear::where('id', $courseYearId)->first()->course->programsemester->program->name;
        $semester = CourseYear::where('id', $courseYearId)->first()->course->programsemester->semester->name;
        if (empty($data)) {
            // return with error and status code as 404
            return response()->json(['error' => 'No Sheet found'], 404);
        }

//        return response()->json($data);
//        dd($panel->toArray());

        $pdf = PDF::loadView('admin.downloadProjectSheetpdf', compact('data', 'code', 'cname' , 'year' , 'program' , 'semester'));

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

        $filename = $code . '_' . $cname . '_' . $year . '_project_list';
        // remove spaces and convert to lowercase
        $filename = str_replace(' ', '_', strtolower($filename));

        // Set response headers for PDF download
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
            'filename' => "$filename",
        ];

        return response($pdfContent, 200, $headers);
    }
}
