<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AcadamicYearController;

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

});

// faculty route
Route::group(['middleware' => 'faculty'], function () {
    Route::get('faculty/dashboard', [FacultyController::class, 'index'])->name('show.faculty.dashboard');
});
