<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\Admin\StudentController;


Route::get('/', function () {
    return view('welcome');
});


// STUDENTS
Route::get('/admin/students', [StudentController::class, 'index'])
    ->name('admin.students.index');

Route::get('/admin/students/create', [StudentController::class, 'create'])
    ->name('admin.students.create');

Route::post('/admin/students', [StudentController::class, 'store'])
    ->name('admin.students.store');


// LECTURERS
Route::get('/lecturers', [LecturerController::class, 'index'])
    ->name('lecturers.index');

Route::get('/lecturers/create', [LecturerController::class, 'create'])
    ->name('lecturers.create');

Route::post('/lecturers', [LecturerController::class, 'store'])
    ->name('lecturers.store');


// TOPICS
Route::get('/topics', [TopicController::class, 'index']);

Route::get('/topics/create', [TopicController::class, 'create']);

Route::post('/topics', [TopicController::class, 'store']);