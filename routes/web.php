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


// admin route
Route::group(['middleware' => 'admin'], function () {

    // faculty
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('show.admin.dashboard');
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

    //allocation
    Route::get('/ViewAllAllocations', [allocationController::class, 'ViewAllAllocations'])->name('ManageAllocations');
    Route::get('/getGroups', [allocationController::class, 'getGroups'])->name('getGroups');
    Route::get('/getGuide', [allocationController::class, 'getGuide'])->name('getGuide');
    Route::post('/AddAllocation', [allocationController::class, 'createAllocation'])->name('allocation.add');
});

// faculty route
Route::group(['middleware' => 'faculty'], function () {
    Route::get('faculty/dashboard', [FacultyController::class, 'index'])->name('show.faculty.dashboard');
});
