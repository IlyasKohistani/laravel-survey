<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/register', 'signup')->name('register');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});


// Authenticated Routes

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
