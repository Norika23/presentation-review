<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\PresentationTypeController;
use App\Http\Controllers\StudentResultController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/classrooms', [ClassroomController::class, 'index'])->name('classrooms.index');
    Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('classrooms.create');
    Route::post('/classrooms', [ClassroomController::class, 'store'])->name('classrooms.store');
    Route::get('/classrooms/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
    Route::get('/classrooms/{classroom}/presentation-types/create', [PresentationTypeController::class, 'create'])->name('presentation-types.create');
    Route::post('/classrooms/{classroom}/presentation-types', [PresentationTypeController::class, 'store'])->name('presentation-types.store');
    Route::get('/classrooms/{classroom}/presentation-types/{presentationType}', [PresentationTypeController::class, 'show'])->name('presentation-types.show');

    Route::get('/classrooms/{classroom}/presentation-types/{presentationType}/presentations/create', [PresentationController::class, 'create'])->name('presentations.create');
    Route::post('/classrooms/{classroom}/presentation-types/{presentationType}/presentations', [PresentationController::class, 'store'])->name('presentations.store');

    Route::get('/presentations/{presentation}', [PresentationController::class, 'show'])->name('presentations.show');
    Route::get('/presentations/{presentation}/results', [PresentationController::class, 'results'])->name('presentations.results');
});

Route::get('/evaluate/{token}', [EvaluationController::class, 'create'])->name('evaluations.create');
Route::post('/evaluate/{token}/login', [EvaluationController::class, 'login'])->name('evaluations.login');
Route::post('/evaluate/{token}/logout', [EvaluationController::class, 'logout'])->name('evaluations.logout');
Route::post('/evaluate/{token}', [EvaluationController::class, 'store'])->name('evaluations.store');
Route::get('/student-results/{resultToken}', [StudentResultController::class, 'show'])->name('students.results');
