<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use App\Models\EvaluationScore;
use App\Models\Lecturer;
use App\Models\TopicAssignment;
use App\Models\TopicRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationScoreController extends Controller
{
    /**
     * Danh sách sinh viên/đề tài mà giảng viên phụ trách.
     */
    public function index()
    {
        $user = Auth::user();

        $lecturer = Lecturer::where('user_id', $user->id)->first();

        if (!$lecturer) {
            return back()->with(
                'error',
                'Hồ sơ giảng viên chưa được thiết lập.'
            );
        }

        $assignments = TopicAssignment::with([
            'topic',
            'evaluationScores.evaluationCriteria',
        ])
            ->where('lecturer_id', $lecturer->id)
            ->get();

        $approvedRegistrations = TopicRegistration::with([
            'student.user',
            'topic',
        ])
            ->whereIn(
                'topic_id',
                $assignments->pluck('topic_id')
            )
            ->where('status', 'Đã duyệt')
            ->get();

        foreach ($assignments as $assignment) {

            $assignment->registration = $approvedRegistrations
                ->firstWhere('topic_id', $assignment->topic_id);

            /*
             * Tổng điểm sinh viên đã được nhập.
             */
            $assignment->total_score = $assignment
                ->evaluationScores
                ->sum('score');

            /*
             * Tổng điểm tối đa của toàn bộ tiêu chí.
             */
            $assignment->max_score = EvaluationCriteria::where(
                'topic_id',
                $assignment->topic_id
            )->sum('max_score');

            /*
             * Tính phần trăm.
             */
            $assignment->percentage = $assignment->max_score > 0
                ? round(
                    ($assignment->total_score / $assignment->max_score) * 100,
                    2
                )
                : 0;
        }

        return view(
            'evaluation_scores.index',
            compact(
                'assignments',
                'approvedRegistrations'
            )
        );
    }

    /**
     * Kiểm tra giảng viên hiện tại có được phép thao tác
     * với assignment này hay không.
     */
    private function authorizeAssignment(TopicAssignment $topicAssignment): void
    {
        $lecturer = Lecturer::where(
            'user_id',
            Auth::id()
        )->first();

        if (
            !$lecturer ||
            $topicAssignment->lecturer_id !== $lecturer->id
        ) {
            abort(403, 'Bạn không có quyền chấm điểm đề tài này.');
        }
    }

    /**
     * Form chấm điểm theo từng tiêu chí.
     */
    public function create(TopicAssignment $topicAssignment)
    {
        $this->authorizeAssignment($topicAssignment);

        $topicAssignment->load([
            'lecturer',
            'topic',
            'evaluationScores.evaluationCriteria',
        ]);

        /*
         * Lấy các tiêu chí của đề tài.
         */
        $criteria = EvaluationCriteria::where(
            'topic_id',
            $topicAssignment->topic_id
        )
            ->orderBy('id')
            ->get();

        /*
         * Lấy sinh viên đã được duyệt đăng ký đề tài.
         */
        $registration = TopicRegistration::with([
            'student.user',
            'topic',
        ])
            ->where(
                'topic_id',
                $topicAssignment->topic_id
            )
            ->where('status', 'Đã duyệt')
            ->first();

        /*
         * Nếu chưa có sinh viên được duyệt
         * thì không cho nhập điểm.
         */
        if (!$registration) {
            return redirect()
                ->route('evaluation-scores.index')
                ->with(
                    'error',
                    'Đề tài này chưa có sinh viên đăng ký được duyệt.'
                );
        }

        /*
         * Chuyển điểm hiện tại thành:
         *
         * criteria_id => EvaluationScore
         */
        $existingScores = $topicAssignment
            ->evaluationScores
            ->keyBy('evaluation_criteria_id');

        return view(
            'evaluation_scores.create',
            compact(
                'topicAssignment',
                'criteria',
                'registration',
                'existingScores'
            )
        );
    }

    /**
     * Lưu điểm theo từng tiêu chí.
     */
    public function store(
        Request $request,
        TopicAssignment $topicAssignment
    ) {
        $this->authorizeAssignment($topicAssignment);

        /*
         * Kiểm tra đề tài đã có sinh viên đăng ký được duyệt chưa.
         */
        $registration = TopicRegistration::where(
            'topic_id',
            $topicAssignment->topic_id
        )
            ->where('status', 'Đã duyệt')
            ->first();

        if (!$registration) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Đề tài này chưa có sinh viên đăng ký được duyệt. Không thể nhập điểm.'
                );
        }

        /*
         * Lấy toàn bộ tiêu chí của đề tài.
         */
        $criteria = EvaluationCriteria::where(
            'topic_id',
            $topicAssignment->topic_id
        )
            ->orderBy('id')
            ->get();

        if ($criteria->isEmpty()) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Đề tài này chưa được thiết lập tiêu chí đánh giá.'
                );
        }

        /*
         * Validate dữ liệu.
         */
        $request->validate([
            'scores' => [
                'required',
                'array',
            ],

            'scores.*' => [
                'required',
                'numeric',
                'min:0',
            ],

            'comments' => [
                'nullable',
                'array',
            ],

            'comments.*' => [
                'nullable',
                'string',
            ],
        ]);

        $scores = $request->input('scores', []);
        $comments = $request->input('comments', []);

        /*
         * Kiểm tra từng điểm không vượt quá max_score.
         */
        foreach ($criteria as $criterion) {

            if (!array_key_exists($criterion->id, $scores)) {
                continue;
            }

            $score = (float) $scores[$criterion->id];
            $maxScore = (float) $criterion->max_score;

            if ($score > $maxScore) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        "Điểm của tiêu chí \"{$criterion->name}\" không được vượt quá {$maxScore}."
                    );
            }
        }

        /*
         * Lưu từng tiêu chí.
         *
         * Nếu đã có điểm -> update.
         * Nếu chưa có -> create.
         */
        foreach ($criteria as $criterion) {

            if (!array_key_exists($criterion->id, $scores)) {
                continue;
            }

            EvaluationScore::updateOrCreate(
                [
                    'topic_assignment_id' => $topicAssignment->id,
                    'evaluation_criteria_id' => $criterion->id,
                ],
                [
                    'score' => $scores[$criterion->id],
                    'comment' => $comments[$criterion->id] ?? null,
                ]
            );
        }

        return redirect()
            ->route('evaluation-scores.index')
            ->with(
                'success',
                'Lưu điểm theo từng tiêu chí thành công.'
            );
    }
}