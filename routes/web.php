<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Các Controller của nhóm Admin
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TopicRegistrationController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\TopicAssignmentController;
use App\Http\Controllers\EvaluationScoreController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\MilestoneSubmissionController;
use App\Http\Controllers\EvaluationCriteriaController;

// Các Controller của nhóm Student
use App\Http\Controllers\Student\TopicController as StudentTopicController;

// TRANG CHỦ (TỰ ĐỘNG ĐIỀU HƯỚNG)

Route::get('/', function () {
    // Nếu đã đăng nhập, tự động đẩy về đúng trang theo Role
    if (\Illuminate\Support\Facades\Auth::check()) {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard'); 
        } elseif ($user->role === 'admin') {
            return redirect('/admin/students');
        } elseif ($user->role === 'lecturer') {
            return redirect('/evaluation-scores');
        }
    }
    // Nếu chưa đăng nhập, văng thẳng ra form Login
    return redirect()->route('login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// KHU VỰC RIÊNG TƯ (BẮT BUỘC ĐĂNG NHẬP & KIỂM TRA ROLE)

Route::middleware('auth')->group(function () {
    
    // Nút Đăng xuất (Ai đã vào đây thì đều có quyền bấm)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // PHÒNG 1: CHỈ DÀNH CHO ADMIN
    
    Route::middleware('role:admin')->group(function () {
        
        // Module Students (Của Cơ)
        Route::prefix('admin/students')->name('admin.students.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
            Route::put('/{student}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        });

        // Module Topic Registrations (Của Cơ)
        Route::prefix('topic-registrations')->name('admin.topic_registrations.')->group(function () {
            Route::get('/', [TopicRegistrationController::class, 'index'])->name('index');
            Route::put('/{registration}/status', [TopicRegistrationController::class, 'updateStatus'])->name('update_status');
            Route::delete('/{id}', [TopicRegistrationController::class, 'destroy'])->name('destroy');
        });

        // Các Module quản lý khác (Chỉ Admin được sửa/xóa/thêm)
        Route::resource('lecturers', LecturerController::class)->except(['show']);
        Route::resource('specializations', SpecializationController::class)->except(['show']);
        Route::resource('topic-assignments', TopicAssignmentController::class)->except(['show']);
        Route::resource('topics', TopicController::class);
        Route::resource('milestones', MilestoneController::class);
        Route::resource('milestone-submissions', MilestoneSubmissionController::class);
        Route::resource('evaluation-criterias', EvaluationCriteriaController::class);
    });

    // -------------------------------------------------
    // PHÒNG 2: CHỈ DÀNH CHO GIẢNG VIÊN
    // -------------------------------------------------
    Route::middleware('role:lecturer')->group(function () {
        // Giảng viên chỉ được xem và nhập điểm
        Route::get('/evaluation-scores', [EvaluationScoreController::class, 'index'])->name('evaluation-scores.index');
        Route::get('/evaluation-scores/create/{topicAssignment}', [EvaluationScoreController::class, 'create'])->name('evaluation-scores.create');
        Route::post('/evaluation-scores/{topicAssignment}', [EvaluationScoreController::class, 'store'])->name('evaluation-scores.store');
        // Bổ sung: Cho phép Giảng viên xem Tiến độ và Bài nộp (Của Việt)
        Route::resource('milestones', MilestoneController::class);
        Route::resource('milestone-submissions', MilestoneSubmissionController::class);
    });

    // -------------------------------------------------
    // PHÒNG 3: CHỈ DÀNH CHO SINH VIÊN
    // -------------------------------------------------
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        
        // Trang thông tin tổng quan (Dashboard Sinh viên) - Vừa thêm!
        Route::get('/dashboard', [StudentTopicController::class, 'dashboard'])->name('dashboard');
        // Route xử lý việc nộp bài cho một mốc cụ thể
    Route::post('/milestones/{milestone}/submit', [\App\Http\Controllers\Student\TopicController::class, 'submitMilestone'])->name('milestones.submit');
        // Đăng ký đề tài
        Route::get('/topics', [StudentTopicController::class, 'index'])->name('topics.index');
        Route::post('/topics/register', [StudentTopicController::class, 'register'])->name('topics.register');
    });

});