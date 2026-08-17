<?php

namespace App\Http\Controllers;

use App\Models\EvaluationScore;
use App\Models\TopicAssignment;
use Illuminate\Http\Request;

class EvaluationScoreController extends Controller
{
    /**
     * Danh sách phân công và điểm
     */
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // 1. Tìm thông tin giảng viên đang đăng nhập
        $lecturer = \App\Models\Lecturer::where('user_id', $user->id)->first();
        
        if (!$lecturer) {
            return back()->with('error', 'Hồ sơ giảng viên chưa được thiết lập.');
        }

        // 2. Lấy danh sách các đề tài mà giảng viên này được phân công (từ bảng topic_assignments của Đạt)
        $assignments = \App\Models\TopicAssignment::where('lecturer_id', $lecturer->id)->pluck('topic_id');

        // 3. Lấy danh sách các ĐƠN ĐĂNG KÝ đã được Admin "Đã duyệt" thuộc về các đề tài trên
        // Lấy kèm thông tin sinh viên, đề tài và điểm số (nếu có)
        $approvedRegistrations = \App\Models\TopicRegistration::with(['student', 'topic', 'statusLogs'])
            ->whereIn('topic_id', $assignments)
            ->where('status', 'Đã duyệt') // CHỈ LẤY NHỮNG ĐƠN ĐÃ DUYỆT
            ->get();
            
        // Để dễ dàng quản lý điểm cho từng sinh viên, cậu có thể truyền thêm mảng điểm
        $scores = \App\Models\EvaluationScore::whereIn('topic_assignment_id', function($query) use ($assignments, $lecturer) {
        $query->select('id')
                    ->from('topic_assignments')
                    ->whereIn('topic_id', $assignments)
                    ->where('lecturer_id', $lecturer->id);
        })->get()->keyBy('topic_assignment_id'); // Khúc này có thể cần sửa lại tùy theo cách Đạt lưu điểm

        return view('evaluation_scores.index', compact('approvedRegistrations', 'scores'));
    }

    /**
     * Form nhập điểm
     */
    public function create(
        TopicAssignment $topicAssignment
    ) {
        $topicAssignment->load([
            'lecturer',
            'topic',
            'evaluationScore'
        ]);

        return view(
            'evaluation_scores.create',
            compact('topicAssignment')
        );
    }

    /**
     * Lưu hoặc cập nhật điểm
     */
    public function store(
        Request $request,
        TopicAssignment $topicAssignment
    ) {
        $validated = $request->validate([
            'score' => [
                'required',
                'numeric',
                'min:0',
                'max:10',
            ],

            'comment' => [
                'nullable',
                'string',
            ],
        ]);
        $assignment = \App\Models\TopicAssignment::find($request->topic_assignment_id);

        if ($assignment) {
            // Kiểm tra xem đề tài này đã có đơn đăng ký nào được "Đã duyệt" chưa
            $isApproved = \App\Models\TopicRegistration::where('topic_id', $assignment->topic_id)
                                                        ->where('status', 'Đã duyệt')
                                                        ->exists();

            if (!$isApproved) {
                return back()->with('error', 'Lỗi Logic: Đề tài này chưa có đơn đăng ký nào được duyệt. Không thể nhập điểm!');
            }
        }
        EvaluationScore::updateOrCreate(
            [
                'topic_assignment_id' =>
                    $topicAssignment->id,
            ],
            $validated
        );

        return redirect()
            ->route('evaluation-scores.index')
            ->with(
                'success',
                'Lưu điểm đánh giá thành công.'
            );
    }
}
