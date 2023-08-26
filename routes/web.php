<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FacultyController;

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

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('show.admin.dashboard');
});
Route::get('/', [UserController::class, 'showLoginForm']);
Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('auth.login');
Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');
Route::get('/forgotpassword', [UserController::class, 'showForgotForm'])->name('auth.ShowforgotPassword');
Route::post('/forgotpassword', [UserController::class, 'forgotPassword'])->name('auth.forgotPassword');
Route::get('/resetpassword', [UserController::class, 'resetPassword']);
Route::post('/changepassword', [UserController::class, 'ChangePassword'])->name('change.password');


// faculty dashboard
Route::get('/ViewAddFaculty', [FacultyController::class, 'ViewAddFacultyForm'])->name('faculty.addForm');
Route::post('/AddFaculty', [FacultyController::class , 'create'])->name('faculty.add');