<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Topic;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $milestones = Milestone::with('topic')
            ->orderBy('due_date')
            ->paginate(10);

        return view('milestones.index', compact('milestones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::orderBy('title')->get();

        return view('milestones.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                'in:Pending,In Progress,Completed,Overdue',
            ],
        ], [
            'topic_id.required' => 'Vui lòng chọn đề tài.',
            'topic_id.exists' => 'Đề tài không tồn tại.',

            'title.required' => 'Vui lòng nhập tên mốc.',
            'title.max' => 'Tên mốc không được vượt quá 255 ký tự.',

            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',

            'due_date.required' => 'Vui lòng chọn hạn hoàn thành.',
            'due_date.date' => 'Hạn hoàn thành không hợp lệ.',
            'due_date.after_or_equal' =>
                'Hạn hoàn thành phải sau hoặc bằng ngày bắt đầu.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        Milestone::create($validated);

        return redirect()
            ->route('milestones.index')
            ->with('success', 'Thêm mốc thực hiện thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Milestone $milestone)
    {
        $milestone->load('topic');

        return view('milestones.show', compact('milestone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Milestone $milestone)
    {
        $topics = Topic::orderBy('title')->get();

        return view('milestones.edit', compact('milestone', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        $validated = $request->validate([
            'topic_id' => [
                'required',
                'integer',
                'exists:topics,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'required',
                'in:Pending,In Progress,Completed,Overdue',
            ],
        ], [
            'topic_id.required' => 'Vui lòng chọn đề tài.',
            'topic_id.exists' => 'Đề tài không tồn tại.',

            'title.required' => 'Vui lòng nhập tên mốc.',
            'title.max' => 'Tên mốc không được vượt quá 255 ký tự.',

            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',

            'due_date.required' => 'Vui lòng chọn hạn hoàn thành.',
            'due_date.date' => 'Hạn hoàn thành không hợp lệ.',
            'due_date.after_or_equal' =>
                'Hạn hoàn thành phải sau hoặc bằng ngày bắt đầu.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $milestone->update($validated);

        return redirect()
            ->route('milestones.index')
            ->with('success', 'Cập nhật mốc thực hiện thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect()
            ->route('milestones.index')
            ->with('success', 'Xóa mốc thực hiện thành công.');
    }
}