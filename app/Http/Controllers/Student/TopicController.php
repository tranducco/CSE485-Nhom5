<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\TopicRegistration;
use App\Models\StatusLog;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    // 1. Hiển thị danh sách đề tài
    public function index()
    {
        // LỖ HỔNG 1 ĐÃ FIX: Chỉ lấy những đề tài đang 'Open'
        $topics = Topic::where('status', 'Open')->get(); 
        
        return view('student.topics.index', compact('topics'));
    }

    // 2. Xử lý khi sinh viên bấm Đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id'
        ]);

        $student = Student::first(); // Giả lập sinh viên đang đăng nhập

        if (!$student) {
            return back()->with('error', 'Lỗi: Không tìm thấy thông tin sinh viên!');
        }

        // Kiểm tra xem sinh viên đã có đơn nào đang chờ duyệt hoặc đã duyệt chưa
        $hasActiveRegistration = TopicRegistration::where('student_id', $student->id)
                                      ->whereIn('status', ['Chờ duyệt', 'Đã duyệt'])
                                      ->exists();

        if ($hasActiveRegistration) {
            return back()->with('error', 'Lỗi: Bạn đã có đề tài đang chờ duyệt hoặc đã được duyệt! Không thể đăng ký thêm.');
        }

        // LỖ HỔNG 2 ĐÃ FIX (Phần Sinh viên): Kiểm tra xem đề tài đã Full chưa
        $topic = Topic::findOrFail($request->topic_id);
        $approvedCount = TopicRegistration::where('topic_id', $topic->id)
                                          ->where('status', 'Đã duyệt')
                                          ->count();

        if ($approvedCount >= $topic->max_students) {
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
}