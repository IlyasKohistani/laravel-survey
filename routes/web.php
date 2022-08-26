<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

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


// Guest Routes
Route::middleware(['guest'])->name('auth.')->controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/register', 'register')->name('register');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});


// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('dashboard', [SurveyController::class, 'dashboard'])->name('surveys.dashboard');
    Route::get('latest-surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('take-survey', [SurveyController::class, 'create'])->name('surveys.take');
    Route::post('take-survey', [SurveyController::class, 'store'])->name('surveys.store');
});
