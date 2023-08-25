<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

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
Route::get('/forgotpassword', [UserController::class, 'showForgotForm'])->name('auth.ShowforgotPassword');
Route::post('/forgotpassword', [UserController::class, 'forgotPassword'])->name('auth.forgotPassword');
Route::get('/resetpassword', [UserController::class, 'resetPassword']);
Route::post('/changepassword', [UserController::class, 'ChangePassword'])->name('change.password');