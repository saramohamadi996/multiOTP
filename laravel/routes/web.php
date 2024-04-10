<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify', [AuthController::class, 'verifyForm'])->name('verify.form');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
