<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PresentationTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\EvaluationController;

Route::get('/', [ClassroomController::class, 'index'])->name('classrooms.index');
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

Route::get('/evaluate/{token}', [EvaluationController::class, 'create'])->name('evaluations.create');
Route::post('/evaluate/{token}', [EvaluationController::class, 'store'])->name('evaluations.store');
