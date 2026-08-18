<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\TopicRegistration;
use App\Models\StatusLog;
use App\Models\Student;
use App\Models\TopicAssignment;
use App\Models\EvaluationScore;
use App\Models\Milestone;
use App\Models\MilestoneSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * 1. Hiển thị danh sách đề tài cho sinh viên
     */
    public function index()
    {
        // Lấy các đề tài đang mở
        $topics = Topic::where('status', 'Đang mở')
            ->orWhere('status', 'Open')
            ->get();

        // Lấy sinh viên đang đăng nhập
        $user = Auth::user();

        $student = Student::where(
            'user_id',
            $user->id
        )->first();

        // Kiểm tra sinh viên đã có đơn đang hoạt động hay chưa
        $hasActiveRegistration = false;

        if ($student) {
            $hasActiveRegistration = TopicRegistration::where(
                'student_id',
                $student->id
            )
                ->whereIn(
                    'status',
                    ['Chờ duyệt', 'Đã duyệt']
                )
                ->exists();
        }

        return view(
            'student.topics.index',
            compact(
                'topics',
                'hasActiveRegistration'
            )
        );
    }

    /**
     * 2. Xử lý khi sinh viên đăng ký đề tài
     */
    public function register(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
        ]);

        // Lấy tài khoản đang đăng nhập
        $user = Auth::user();

        // Lấy đúng sinh viên liên kết với tài khoản
        $student = Student::where(
            'user_id',
            $user->id
        )->first();

        if (!$student) {
            return back()->with(
                'error',
                'Lỗi: Không tìm thấy thông tin sinh viên liên kết với tài khoản này!'
            );
        }

        /*
         * Kiểm tra sinh viên đã có đề tài đang chờ duyệt
         * hoặc đã được duyệt hay chưa.
         */
        $hasActiveRegistration = TopicRegistration::where(
            'student_id',
            $student->id
        )
            ->whereIn(
                'status',
                ['Chờ duyệt', 'Đã duyệt']
            )
            ->exists();

        if ($hasActiveRegistration) {
            return back()->with(
                'error',
                'Lỗi: Bạn đã có đề tài đang chờ duyệt hoặc đã được duyệt! Không thể đăng ký thêm.'
            );
        }

        // Lấy đề tài muốn đăng ký
        $topic = Topic::findOrFail(
            $request->topic_id
        );

        /*
         * Kiểm tra số lượng sinh viên đã được duyệt.
         */
        $approvedCount = TopicRegistration::where(
            'topic_id',
            $topic->id
        )
            ->where(
                'status',
                'Đã duyệt'
            )
            ->count();

        // Nếu max_students null thì mặc định là 2
        $maxStudents = $topic->max_students ?? 2;

        if ($approvedCount >= $maxStudents) {
            return back()->with(
                'error',
                'Rất tiếc! Đề tài này đã đủ số lượng sinh viên đăng ký. Vui lòng chọn đề tài khác.'
            );
        }

        /*
         * Tạo đơn đăng ký và ghi log trong transaction.
         */
        DB::transaction(function () use (
            $student,
            $request
        ) {
            $registration = TopicRegistration::create([
                'student_id' => $student->id,
                'topic_id' => $request->topic_id,
                'status' => 'Chờ duyệt',
            ]);

            StatusLog::create([
                'topic_registration_id' => $registration->id,
                'old_status' => null,
                'new_status' => 'Chờ duyệt',
                'note' => 'Sinh viên tự đăng ký trên hệ thống',
            ]);
        });

        return back()->with(
            'success',
            'Đăng ký thành công! Đơn của bạn đang được chờ duyệt.'
        );
    }

    /**
     * 3. Dashboard sinh viên
     *
     * Hiển thị:
     * - Thông tin sinh viên
     * - Đề tài đã đăng ký
     * - Điểm tổng
     * - Điểm từng tiêu chí
     * - Các mốc tiến độ
     */
    public function dashboard()
    {
        // Lấy user đang đăng nhập
        $user = Auth::user();

        // Lấy sinh viên liên kết
        $student = $user->student;

        /*
         * Khởi tạo các biến mặc định
         * để tránh lỗi Undefined variable trong Blade.
         */
        $registration = null;

        // Điểm tổng quy đổi về thang 10
        $finalScore = null;

        // Danh sách điểm theo từng tiêu chí
        $evaluationScores = collect();

        // Tổng điểm thực tế
        $totalScore = 0;

        // Tổng điểm tối đa
        $maxScore = 0;

        // Danh sách mốc tiến độ
        $milestones = collect();

        if ($student) {

            /*
             * Lấy đơn đăng ký mới nhất của sinh viên.
             */
            $registration = TopicRegistration::with('topic')
                ->where(
                    'student_id',
                    $student->id
                )
                ->latest()
                ->first();

            /*
             * Chỉ lấy điểm và milestone nếu
             * đơn đăng ký đã được duyệt.
             */
            if (
                $registration &&
                $registration->status === 'Đã duyệt'
            ) {

                /*
                 * Tìm phân công giảng viên của đề tài.
                 */
                $assignment = TopicAssignment::where(
                    'topic_id',
                    $registration->topic_id
                )->first();

                if ($assignment) {

                    /*
                     * LẤY TẤT CẢ ĐIỂM CỦA CÁC TIÊU CHÍ.
                     *
                     * Đây là phần sửa quan trọng.
                     *
                     * Trước đây dùng:
                     *
                     * EvaluationScore::where(...)->first()
                     *
                     * nên chỉ lấy Correctness.
                     *
                     * Bây giờ dùng get() để lấy:
                     *
                     * Correctness
                     * Quality
                     * Security
                     */
                    $evaluationScores = EvaluationScore::with(
                        'evaluationCriteria'
                    )
                        ->where(
                            'topic_assignment_id',
                            $assignment->id
                        )
                        ->get();

                    /*
                     * Tính tổng điểm thực tế.
                     *
                     * Ví dụ:
                     *
                     * Correctness = 45
                     * Quality     = 20
                     * Security    = 25
                     *
                     * totalScore = 90
                     */
                    $totalScore = $evaluationScores->sum(
                        'score'
                    );

                    /*
                     * Tính tổng điểm tối đa.
                     *
                     * Ví dụ:
                     *
                     * Correctness = 50
                     * Quality     = 25
                     * Security    = 25
                     *
                     * maxScore = 100
                     */
                    $maxScore = $evaluationScores->sum(
                        function ($evaluationScore) {
                            if (
                                $evaluationScore->evaluationCriteria
                            ) {
                                return $evaluationScore
                                    ->evaluationCriteria
                                    ->max_score;
                            }

                            return 0;
                        }
                    );

                    /*
                     * Quy đổi tổng điểm về thang 10.
                     *
                     * 90 / 100 * 10 = 9.00
                     */
                    if ($maxScore > 0) {
                        $finalScore = round(
                            ($totalScore / $maxScore) * 10,
                            2
                        );
                    }
                }

                /*
                 * Lấy tất cả milestone của đề tài.
                 */
                $milestones = Milestone::where(
                    'topic_id',
                    $registration->topic_id
                )->get();
            }
        }

        /*
         * Truyền toàn bộ dữ liệu sang dashboard.
         */
        return view(
            'student.dashboard',
            compact(
                'user',
                'student',
                'registration',
                'finalScore',
                'evaluationScores',
                'totalScore',
                'maxScore',
                'milestones'
            )
        );
    }

    /**
     * 4. Sinh viên nộp link bài làm cho từng milestone
     */
    public function submitMilestone(
        Request $request,
        $milestoneId
    ) {
        /*
         * Kiểm tra link.
         */
        $request->validate([
            'file_path' => 'required|url',
        ]);

        /*
         * Lấy sinh viên đang đăng nhập.
         */
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with(
                'error',
                'Không tìm thấy hồ sơ sinh viên.'
            );
        }

        /*
         * Lưu bài nộp.
         *
         * Nếu sinh viên đã nộp milestone này rồi
         * thì update thay vì tạo bản ghi mới.
         */
        MilestoneSubmission::updateOrCreate(
            [
                'milestone_id' => $milestoneId,
                'student_id' => $student->id,
            ],
            [
                'file_path' => $request->file_path,
                'comment' => 'Nộp bài qua form',
                'submitted_at' => now(),
                'status' => 'Submitted',
            ]
        );

        return back()->with(
            'success',
            'Nộp tài liệu thành công!'
        );
    }
}