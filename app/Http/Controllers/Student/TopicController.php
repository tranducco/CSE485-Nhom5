<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\TopicRegistration;
use App\Models\StatusLog;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Nhớ import Auth để lấy người dùng hiện tại

class TopicController extends Controller
{
    // 1. Hiển thị danh sách đề tài
    public function index()
{
    $topics = Topic::where('status', 'Đang mở')->orWhere('status', 'Open')->get(); 

    // KIỂM TRA XEM SINH VIÊN ĐÃ CÓ ĐƠN ĐANG ACTIVE CHƯA
    $user = \Illuminate\Support\Facades\Auth::user();
    $student = \App\Models\Student::where('user_id', $user->id)->first();

    $hasActiveRegistration = false;
    if ($student) {
        $hasActiveRegistration = \App\Models\TopicRegistration::where('student_id', $student->id)
                                        ->whereIn('status', ['Chờ duyệt', 'Đã duyệt'])
                                        ->exists();
    }

    return view('student.topics.index', compact('topics', 'hasActiveRegistration'));
}

    // 2. Xử lý khi sinh viên bấm Đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id'
        ]);

        // Đã sửa: Lấy đúng sinh viên đang đăng nhập, không lấy bừa sinh viên đầu tiên nữa
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return back()->with('error', 'Lỗi: Không tìm thấy thông tin sinh viên liên kết với tài khoản này!');
        }

        // Kiểm tra xem sinh viên đã có đơn nào đang chờ duyệt hoặc đã duyệt chưa
        $hasActiveRegistration = TopicRegistration::where('student_id', $student->id)
                                        ->whereIn('status', ['Chờ duyệt', 'Đã duyệt'])
                                        ->exists();

        if ($hasActiveRegistration) {
            return back()->with('error', 'Lỗi: Bạn đã có đề tài đang chờ duyệt hoặc đã được duyệt! Không thể đăng ký thêm.');
        }

        // LỖ HỔNG 2 ĐÃ FIX: Kiểm tra xem đề tài đã Full chưa
        $topic = Topic::findOrFail($request->topic_id);
        $approvedCount = TopicRegistration::where('topic_id', $topic->id)
                                        ->where('status', 'Đã duyệt')
                                        ->count();
                                        
        // Lấy giới hạn sinh viên, nếu null thì mặc định là 2
        $maxStudents = $topic->max_students ?? 2;

        if ($approvedCount >= $maxStudents) {
            return back()->with('error', 'Rất tiếc! Đề tài này đã đủ số lượng sinh viên đăng ký. Vui lòng chọn đề tài khác.');
        }

        // Tạo đơn
        DB::transaction(function () use ($student, $request) {
            $registration = TopicRegistration::create([
                'student_id' => $student->id,
                'topic_id' => $request->topic_id,
                'status' => 'Chờ duyệt'
            ]);

            StatusLog::create([
                'topic_registration_id' => $registration->id,
                'old_status' => null,
                'new_status' => 'Chờ duyệt',
                'note' => 'Sinh viên tự đăng ký trên hệ thống'
            ]);
        });

        return back()->with('success', 'Đăng ký thành công! Đơn của bạn đang được chờ duyệt.');
    }
    
    
    public function dashboard()
    {
        // 1. Lấy thông tin user và student đang đăng nhập
        $user = auth()->user();
        $student = $user->student;

        // Khởi tạo các biến mặc định để tránh lỗi Undefined
        $registration = null;
        $finalScore = null;
        $milestones = collect();

        if ($student) {
            // 2. Tìm đơn đăng ký mới nhất của sinh viên này
            $registration = \App\Models\TopicRegistration::with('topic')
                                                         ->where('student_id', $student->id)
                                                         ->latest()
                                                         ->first();

            if ($registration && $registration->status == 'Đã duyệt') {
                // 3. Nếu đã duyệt, lấy thông tin điểm (nếu có)
                $assignment = \App\Models\TopicAssignment::where('topic_id', $registration->topic_id)->first();
                if ($assignment) {
                    $finalScore = \App\Models\EvaluationScore::where('topic_assignment_id', $assignment->id)->first();
                }

                // 4. Lấy tất cả các mốc (milestones) thuộc đề tài đó
                $milestones = \App\Models\Milestone::where('topic_id', $registration->topic_id)->get();
            }
        }

        // 5. Truyền TOÀN BỘ biến sang view
        return view('student.dashboard', compact('user', 'student', 'registration', 'finalScore', 'milestones'));
    }
    // Xử lý nộp link bài làm cho từng mốc
    public function submitMilestone(Request $request, $milestoneId)
    {
        $request->validate([
            'file_path' => 'required|url', // Bắt buộc phải là link hợp lệ
        ]);

        $student = auth()->user()->student;

        if (!$student) {
            return back()->with('error', 'Không tìm thấy hồ sơ sinh viên.');
        }

        // Lưu vào bảng milestone_submissions
        \App\Models\MilestoneSubmission::updateOrCreate(
            [
                'milestone_id' => $milestoneId,
                'student_id' => $student->id,
            ],
            [
                'file_path' => $request->file_path,
                'comment' => 'Nộp bài qua form',
                'submitted_at' => now(),
                'status' => 'Submitted' // Đánh dấu đã nộp
            ]
        );

        return back()->with('success', 'Nộp tài liệu thành công!');
    }
}