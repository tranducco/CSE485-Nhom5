<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Topic;
use App\Models\TopicAssignment;
use Illuminate\Http\Request;

class TopicAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TopicAssignment::with([
            'lecturer.specialization',
            'topic',
            'evaluationScore'
        ])
        ->orderByDesc('assigned_date')
        ->get();

        return view(
            'topic_assignments.index',
            compact('assignments')
        );
    }

    public function create()
    {
        $lecturers = Lecturer::with('specialization')
            ->orderBy('name')
            ->get();

        // LẤY BẢNG TOPICS CỦA MODULE BẠN VIỆT
        $topics = Topic::orderBy('code')->get();

        return view(
            'topic_assignments.create',
            compact('lecturers', 'topics')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',

            // Liên kết sang topics của người khác
            'topic_id' => 'required|exists:topics,id',

            'assigned_date' => 'required|date',
        ]);

        // Không cho cùng một GV được phân công cùng một đề tài 2 lần
        $exists = TopicAssignment::where(
            'lecturer_id',
            $validated['lecturer_id']
        )
        ->where(
            'topic_id',
            $validated['topic_id']
        )
        ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'topic_id' =>
                        'Giảng viên này đã được phân công đề tài này.'
                ]);
        }

        TopicAssignment::create($validated);

        return redirect()
            ->route('topic-assignments.index')
            ->with(
                'success',
                'Phân công hướng dẫn thành công.'
            );
    }

    public function edit(TopicAssignment $topicAssignment)
    {
        $lecturers = Lecturer::with('specialization')
            ->orderBy('name')
            ->get();

        $topics = Topic::orderBy('code')->get();

        return view(
            'topic_assignments.edit',
            compact(
                'topicAssignment',
                'lecturers',
                'topics'
            )
        );
    }

    public function update(
        Request $request,
        TopicAssignment $topicAssignment
    ) {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'topic_id' => 'required|exists:topics,id',
            'assigned_date' => 'required|date',
        ]);

        $exists = TopicAssignment::where(
            'lecturer_id',
            $validated['lecturer_id']
        )
        ->where(
            'topic_id',
            $validated['topic_id']
        )
        ->where(
            'id',
            '!=',
            $topicAssignment->id
        )
        ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'topic_id' =>
                        'Giảng viên này đã được phân công đề tài này.'
                ]);
        }

        $topicAssignment->update($validated);

        return redirect()
            ->route('topic-assignments.index')
            ->with(
                'success',
                'Cập nhật phân công thành công.'
            );
    }

    public function destroy(
        TopicAssignment $topicAssignment
    ) {
        $topicAssignment->delete();

        return redirect()
            ->route('topic-assignments.index')
            ->with(
                'success',
                'Xóa phân công thành công.'
            );
    }
}
