<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\TopicAssignmentController;
use App\Http\Controllers\EvaluationScoreController;
use App\Http\Controllers\Admin\StudentController;


Route::get('/', function () {
    return view('welcome');
});


// =========================
// STUDENTS - MODULE CỦA CƠ
// =========================

Route::get('/admin/students', [StudentController::class, 'index'])
    ->name('admin.students.index');

Route::get('/admin/students/create', [StudentController::class, 'create'])
    ->name('admin.students.create');

Route::post('/admin/students', [StudentController::class, 'store'])
    ->name('admin.students.store');


// =========================
// LECTURERS - MODULE CỦA BẠN
// =========================

Route::resource('lecturers', LecturerController::class)
    ->except(['show']);


// =========================
// SPECIALIZATIONS - MODULE CỦA BẠN
// =========================

Route::resource('specializations', SpecializationController::class)
    ->except(['show']);


// =========================
// TOPIC ASSIGNMENTS - MODULE CỦA BẠN
// =========================

Route::resource('topic-assignments', TopicAssignmentController::class)
    ->except(['show']);


// =========================
// EVALUATION SCORES - MODULE CỦA BẠN
// =========================

Route::get(
    '/evaluation-scores',
    [EvaluationScoreController::class, 'index']
)->name('evaluation-scores.index');

Route::get(
    '/evaluation-scores/create/{topicAssignment}',
    [EvaluationScoreController::class, 'create']
)->name('evaluation-scores.create');

Route::post(
    '/evaluation-scores/{topicAssignment}',
    [EvaluationScoreController::class, 'store']
)->name('evaluation-scores.store');


// =========================
// TOPICS - MODULE CỦA VIỆT
// =========================

Route::get('/topics', [TopicController::class, 'index'])
    ->name('topics.index');

Route::get('/topics/create', [TopicController::class, 'create'])
    ->name('topics.create');

Route::post('/topics', [TopicController::class, 'store'])
    ->name('topics.store');
