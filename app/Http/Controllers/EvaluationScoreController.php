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
        $assignments = TopicAssignment::with([
            'lecturer',
            'topic',
            'evaluationScore'
        ])
        ->orderByDesc('assigned_date')
        ->get();

        return view(
            'evaluation_scores.index',
            compact('assignments')
        );
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
