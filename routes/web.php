<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\TopicAssignmentController;
use App\Http\Controllers\EvaluationScoreController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TopicRegistrationController;
use App\Http\Controllers\Student\TopicController as StudentTopicController;


// =====================================================
// TRANG CHỦ
// =====================================================

Route::get('/', function () {
    return view('welcome');
});


// =====================================================
// STUDENTS - MODULE CỦA CƠ
// =====================================================

Route::prefix('admin/students')->name('admin.students.')->group(function () {

    // Danh sách sinh viên
    Route::get('/', [StudentController::class, 'index'])
        ->name('index');

    // Form thêm sinh viên
    Route::get('/create', [StudentController::class, 'create'])
        ->name('create');

    // Lưu sinh viên mới
    Route::post('/', [StudentController::class, 'store'])
        ->name('store');

    // Form sửa sinh viên
    Route::get('/{student}/edit', [StudentController::class, 'edit'])
        ->name('edit');

    // Cập nhật sinh viên
    Route::put('/{student}', [StudentController::class, 'update'])
        ->name('update');

    // Xóa sinh viên
    Route::delete('/{student}', [StudentController::class, 'destroy'])
        ->name('destroy');
});


// =====================================================
// TOPIC REGISTRATIONS
// =====================================================

// Danh sách đơn đăng ký
Route::get('/topic-registrations', [TopicRegistrationController::class, 'index'])
    ->name('admin.topic_registrations.index');

// Cập nhật trạng thái đơn đăng ký
Route::put('/topic-registrations/{registration}/status', [TopicRegistrationController::class, 'updateStatus'])
    ->name('admin.topic_registrations.update_status');

// Xóa đơn đăng ký
Route::delete('/topic-registrations/{id}', [TopicRegistrationController::class, 'destroy'])
    ->name('admin.topic_registrations.destroy');


// =====================================================
// KHU VỰC SINH VIÊN - CLIENT SITE
// =====================================================

Route::prefix('student')->name('student.')->group(function () {

    // Xem danh sách đề tài
    Route::get('/topics', [StudentTopicController::class, 'index'])
        ->name('topics.index');

    // Gửi form đăng ký đề tài
    Route::post('/topics/register', [StudentTopicController::class, 'register'])
        ->name('topics.register');
});


// =====================================================
// LECTURERS - MODULE CỦA BẠN
// =====================================================

Route::resource('lecturers', LecturerController::class)
    ->except(['show']);


// =====================================================
// SPECIALIZATIONS - MODULE CỦA BẠN
// =====================================================

Route::resource('specializations', SpecializationController::class)
    ->except(['show']);


// =====================================================
// TOPIC ASSIGNMENTS - MODULE CỦA BẠN
// =====================================================

Route::resource('topic-assignments', TopicAssignmentController::class)
    ->except(['show']);


// =====================================================
// EVALUATION SCORES - MODULE CỦA BẠN
// =====================================================

// Danh sách điểm đánh giá
Route::get('/evaluation-scores', [EvaluationScoreController::class, 'index'])
    ->name('evaluation-scores.index');

// Form nhập điểm
Route::get('/evaluation-scores/create/{topicAssignment}', [EvaluationScoreController::class, 'create'])
    ->name('evaluation-scores.create');

// Lưu điểm đánh giá
Route::post('/evaluation-scores/{topicAssignment}', [EvaluationScoreController::class, 'store'])
    ->name('evaluation-scores.store');


// =====================================================
// TOPICS - MODULE CỦA VIỆT
// =====================================================

// Danh sách đề tài
Route::get('/topics', [TopicController::class, 'index'])
    ->name('topics.index');

// Form thêm đề tài
Route::get('/topics/create', [TopicController::class, 'create'])
    ->name('topics.create');

// Lưu đề tài
Route::post('/topics', [TopicController::class, 'store'])
    ->name('topics.store');