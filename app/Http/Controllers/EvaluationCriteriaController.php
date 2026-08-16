<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use App\Models\Topic;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    /**
     * Hiển thị danh sách tiêu chí đánh giá.
     */
    public function index()
    {
        $criteria = EvaluationCriteria::with('topic')
            ->latest()
            ->paginate(10);

        return view(
            'evaluation_criterias.index',
            compact('criteria')
        );
    }

    /**
     * Hiển thị form thêm tiêu chí.
     */
    public function create()
    {
        $topics = Topic::orderBy('title')->get();

        return view(
            'evaluation_criterias.create',
            compact('topics')
        );
    }

    /**
     * Lưu tiêu chí mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:0|max:100',
        ]);

        EvaluationCriteria::create($validated);

        return redirect()
            ->route('evaluation-criterias.index')
            ->with('success', 'Thêm tiêu chí đánh giá thành công.');
    }

    /**
     * Hiển thị chi tiết tiêu chí.
     */
    public function show(EvaluationCriteria $evaluationCriteria)
    {
        $evaluationCriteria->load('topic');

        return view(
            'evaluation_criterias.show',
            compact('evaluationCriteria')
        );
    }

    /**
     * Hiển thị form sửa tiêu chí.
     */
    public function edit(EvaluationCriteria $evaluationCriteria)
    {
        $topics = Topic::orderBy('title')->get();

        return view(
            'evaluation_criterias.edit',
            compact(
                'evaluationCriteria',
                'topics'
            )
        );
    }

    /**
     * Cập nhật tiêu chí.
     */
    public function update(
        Request $request,
        EvaluationCriteria $evaluationCriteria
    ) {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score' => 'required|numeric|min:0|max:100',
        ]);

        $evaluationCriteria->update($validated);

        return redirect()
            ->route('evaluation-criterias.index')
            ->with('success', 'Cập nhật tiêu chí đánh giá thành công.');
    }

    /**
     * Xóa tiêu chí.
     */
    public function destroy(EvaluationCriteria $evaluationCriteria)
    {
        $evaluationCriteria->delete();

        return redirect()
            ->route('evaluation-criterias.index')
            ->with('success', 'Xóa tiêu chí đánh giá thành công.');
    }
}