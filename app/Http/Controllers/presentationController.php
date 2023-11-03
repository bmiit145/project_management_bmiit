<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;
use App\Models\CourseYear;
use App\Models\Schedule;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\PresentationPanel;
use App\Models\PanelProject;

class presentationController extends Controller
{
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
        ], [
            'courseYearId.required' => 'Please select a course year',
            'courseYearId.numeric' => 'Please select a valid course year',
            'courseYearId.exists' => 'Please select a valid course year',
            'datetime.required' => 'Please select a date and time',
            'datetime.date' => 'Please select a valid date and time',
            'datetime.after' => 'Please select date and time After Now',
            'assessmentType.required' => 'Please select an assessment type',
        ]);

        $schedule = new Schedule();
        $schedule->courseYearId = $request->courseYearId;
        $schedule->datetime = $request->datetime;
        $schedule->assessmentType = $request->assessmentType;

        if ($schedule->save()) {
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
        return view('presentation.viewAllPresentations', compact('panels', 'faculties', 'courseYears', 'PresentationPanels' , 'panelProjects'));
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
                }else{
                    $error_groups[] = $group;
                }
                continue;
            }
            $panelProject = new PanelProject();
            $panelProject->panelId = $request->panel;
            $panelProject->groupId = $group;
            if ($panelProject->save()) {
                $create_groups[] = $group;
            }else{
                $error_groups[] = $group;
            }

        }
        return response()->json(['success' => 'Groups allocated successfully' , 'update_groups' => $update_groups , 'create_groups' => $create_groups , 'error_groups' => $error_groups ]);
    }
}
