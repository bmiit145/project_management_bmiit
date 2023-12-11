<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AcadamicYearController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\allocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\presentationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});


Route::get('/', [UserController::class, 'showLoginForm']);
Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('auth.login');
Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
Route::get('/forgotpassword', [UserController::class, 'showForgotForm'])->name('auth.ShowforgotPassword');
Route::post('/forgotpassword', [UserController::class, 'forgotPassword'])->name('auth.forgotPassword');
Route::get('/resetpassword', [UserController::class, 'resetPassword']);
Route::post('/changepassword', [UserController::class, 'ChangePassword'])->name('change.password');
Route::get('/changePassword' , [UserController::class , 'changePasswordPage'])->name('changePasswordPage');
Route::post('/changePasswordNew' , [UserController::class , 'NewChangePassword'])->name('change.password.new');

// extra
Route::get('/getCourseYears', [CourseController::class, 'getCourseYears'])->name('getCourseYears');
Route::get('/getSemesters', [SemesterController::class, 'getSemesters'])->name('getSemesters');
Route::get('/getPrograms', [ProgramController::class, 'getPrograms'])->name('getPrograms');
Route::get('/getStudents', [GroupController::class, 'getStudents'])->name('getStudents');

//setCourseYearSession
Route::post('/setCourseYearSession', [CourseController::class, 'setCourseYearSession'])->name('setCourseYearSession');

// admin route

Route::group(['middleware' => 'admin'], function () {

    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('show.admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // faculty
    Route::get('/ViewAddFaculty', [FacultyController::class, 'ViewAddFacultyForm'])->name('faculty.addForm');
    Route::post('/AddFaculty', [FacultyController::class, 'create'])->name('faculty.add');
    Route::get('/viewFacultyList', [FacultyController::class, 'viewAllFaculty'])->name('allFaculty.view');
    Route::post('/changeFacultyStatus', [FacultyController::class, 'changeFacultyStatus'])->name('changeFacultyStatus');

    // student
    ROute::get('/ViewAddStudent', [StudentController::class, 'ViewAddStudentForm'])->name('student.addForm');
    Route::post('/AddStudent', [StudentController::class, 'create'])->name('student.add');
    Route::get('/ViewAllStudent', [StudentController::class, 'viewAllStudent'])->name('ManageStudent');
    Route::post('/changeStudentStatus', [StudentController::class, 'changeStudentStatus'])->name('changeStudentStatus');


    // programs
    Route::get('/ViewPrograms', [ProgramController::class, 'viewAllPrograms'])->name('ManageProgram');
    Route::post('/AddProgram', [ProgramController::class, 'create'])->name('program.add');
    Route::get('/getProgram', [ProgramController::class, 'getProgram'])->name('program.getProgram');
    Route::post('/program.update', [ProgramController::class, 'updateProgram'])->name('program.update');

    // Acadamic Year
    Route::get('/ViewAcadamicYear', [AcadamicYearController::class, 'viewAllYears'])->name('ManageYears');
    Route::post('/AddAcadamicYear', [AcadamicYearController::class, 'create'])->name('acadamicYear.add');

    // semester
    Route::get('/ManageSemester', [SemesterController::class, 'ViewAllSemester'])->name('ManageSemester');
    Route::get('/ManageAllProgramSemester', [SemesterController::class, 'ViewAllProgramSemester'])->name('ManageProgramSemester');
    Route::post('/AddSemester', [SemesterController::class, 'createSemester'])->name('semester.add');
    Route::post('/AddProgramSemester', [SemesterController::class, 'createProgramSemester'])->name('Programsemester.add');

    // courses
    Route::get('/ViewAllCourses', [CourseController::class, 'ViewAllCourses'])->name('ManageCourses');
    Route::get('/ViewAllCoursesYear', [CourseController::class, 'ViewAllCoursesYear'])->name('ManageCourseYears');
    Route::post('/AddCourse', [CourseController::class, 'createCourse'])->name('course.add');
    Route::post('/AddCourseYear', [CourseController::class, 'createCourseYear'])->name('courseYear.add');


    // committee

    Route::get('/ViewAllCommittees', [CommitteeController::class, 'ViewAllCommittees'])->name('ManageCommittees');
    Route::post('/AddCommittee', [CommitteeController::class, 'createCommittee'])->name('committee.add');

    // Group
    Route::get('/ViewAllGroups', [GroupController::class, 'ViewAllGroups'])->name('ManageGroups');
    Route::post('/AddGroup', [GroupController::class, 'createGroup'])->name('studentGroup.add');
    Route::get('/ViewAllPanddingGroups', [GroupController::class, 'ViewAllPanddingGroups'])->name('ReviewGroups');
    Route::get('/getPanndingGroup', [GroupController::class, 'getPanndingGroup'])->name('PanddingGroup.getDetails');
    Route::delete('/pandding-group/{id}', [GroupController::class, 'delete'])->name('PanddingGroup.delete');
    Route::post('/pandding-group', [GroupController::class, 'ApproveGroup'])->name('PanddingGroup.approve');

    //allocation
    Route::get('/ViewAllAllocations', [allocationController::class, 'ViewAllAllocations'])->name('ManageAllocations');
    Route::get('/getGroups', [allocationController::class, 'getGroups'])->name('getGroups');
    Route::get('/getGuide', [allocationController::class, 'getGuide'])->name('getGuide');
    Route::post('/AddAllocation', [allocationController::class, 'createAllocation'])->name('allocation.add');

    // project
    Route::get('/Projects', [ProjectController::class, 'ViewAllProjects'])->name('ManageProjects');
    Route::get('/getProject', [ProjectController::class, 'getProject'])->name('getProject');
    Route::post('/AddProject', [ProjectController::class, 'createProject'])->name('Project.add');
    Route::get('/ProjectReport', [ProjectController::class, 'ProjectReportPage'])->name('ProjectReportPage');
    Route::post('/ProjectReport', [ProjectController::class, 'ProjectReport'])->name('DownloadProjectSheetPdf');

    // Presentation
    Route::get('/SchedulePresentation', [presentationController::class, 'SchedulePresentation'])->name('ManageSchedule');
    Route::post('/AddSchedule', [presentationController::class, 'createSchedule'])->name('Schedule.add');

    Route::get('/PresentationPanel', [presentationController::class, 'PresentationPanel'])->name('ManagePresentationPanel');
    Route::post('/AddPresentationPanel', [presentationController::class, 'createPresentationPanel'])->name('panel.add');

    Route::get('/AllocatePresentation', [presentationController::class, 'AllocatePresentation'])->name('ManageAllocatePresentation');
    Route::get('/getPanels', [presentationController::class, 'getPanels'])->name('getPanels');
    Route::post('/AddAllocatePresentation', [presentationController::class, 'createAllocatePresentation'])->name('panel.allocate');

    Route::get('/AllPresentations', [presentationController::class, 'ViewAllPresentations'])->name('ManagePresentations');

    // Evalueation

    Route::get('/EvaluationCriteria', [presentationController::class, 'viewAllEvaluationCriteria'])->name('ManageEvaluations');
    Route::post('/AddEvaluation', [presentationController::class, 'createEvaluationCriteria'])->name('EvaluationCriteria.add');
    Route::get('/ViewAllEvaluations', [presentationController::class, 'ViewAllEvaluations'])->name('ManageAllEvaluations');
    Route::post('/AddEvaluationCriteriaMarks', [presentationController::class, 'createEvaluationCriteriaMarks'])->name('evaluationCriteriaMark.add');

    Route::get('/EvaluationStudentMarks', [presentationController::class, 'EvaluationStudentMarks'])->name('ManageEvaluationStudentMarks');
    Route::get('getEvaluationCriteria', [presentationController::class, 'getEvaluationCriteria'])->name('getEvaluationCriteria');
    Route::get('/getOutOf', [presentationController::class, 'getOutOf'])->name('getOutOf');
    Route::get('getOutOfByCriteriaId', [presentationController::class, 'getOutOfByCriteriaId'])->name('getOutOfByCriteriaId');
    Route::get('/getGroupMark', [presentationController::class, 'getGroupMark'])->name('getGroupMark');
    Route::post('/AddEvaluationStudentMarks', [presentationController::class, 'createEvaluationStudentMarks'])->name('evaluaionGroupMark.add');


    // Evaluation Sheet
    Route::get('/DownloadEvaluationSheet', [presentationController::class, 'DownloadEvaluationSheet'])->name('DownloadEvaluationSheet');
    Route::post('/DownloadEvaluationSheet', [presentationController::class, 'DownloadEvaluationSheetPdf'])->name('DownloadEvaluationSheetPdf');


    // Send a mail

//    Route::get('/sendMail' , [presentationController::class, 'sendMail'])->name('sendMail');
});

// faculty route
Route::group(['middleware' => 'faculty'], function () {
    Route::get('faculty/dashboard', [FacultyController::class, 'index'])->name('show.faculty.dashboard');

    // group
    Route::get('/ViewFacultyGroup/{id?}', [GroupController::class, 'ViewFacultyGroup'])->name('ManageFacultyGroup');
    Route::get('/getGroup', [GroupController::class, 'getGroup'])->name('faculty.group.show');
    Route::post('/updateGroup', [GroupController::class, 'updateGroup'])->name('faculty.group.update');
});

// student route
Route::group(['middleware' => 'student'], function () {
    Route::get('student/dashboard', [StudentController::class, 'index'])->name('show.student.dashboard');

//    group
    Route::get('/ViewStudentGroup', [GroupController::class, 'ViewStudentGroup'])->name('ManageStudentGroup');
    Route::post('/AddStudentGroup', [GroupController::class, 'createStudentGroup'])->name('PanddingGroup.add');


});
