<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Danh sách đề tài
     */
    public function index()
    {
        $topics = Topic::withCount('topicRegistrations')
            ->orderBy('code')
            ->paginate(10);

        return view('topics.index', compact('topics'));
    }

    /**
     * Form thêm đề tài
     */
    public function create()
    {
        return view('topics.create');
    }

    /**
     * Lưu đề tài mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:topics,code',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'max_students' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
            'status' => [
                'required',
                'in:Open,Closed',
            ],
        ], [
            'code.required' => 'Vui lòng nhập mã đề tài.',
            'code.unique' => 'Mã đề tài đã tồn tại.',
            'code.max' => 'Mã đề tài không được vượt quá 20 ký tự.',

            'title.required' => 'Vui lòng nhập tên đề tài.',
            'title.max' => 'Tên đề tài không được vượt quá 255 ký tự.',

            'description.max' => 'Mô tả không được vượt quá 5000 ký tự.',

            'max_students.required' => 'Vui lòng nhập số sinh viên tối đa.',
            'max_students.integer' => 'Số sinh viên phải là số nguyên.',
            'max_students.min' => 'Số sinh viên tối đa phải lớn hơn 0.',
            'max_students.max' => 'Số sinh viên tối đa không được vượt quá 100.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        Topic::create($validated);

        return redirect()
            ->route('topics.index')
            ->with('success', 'Thêm đề tài thành công.');
    }

    /**
     * Xem chi tiết đề tài
     */
    public function show(Topic $topic)
    {
        $topic->loadCount([
            'topicRegistrations',
            'topicAssignments',
        ]);

        return view('topics.show', compact('topic'));
    }

    /**
     * Form sửa đề tài
     */
    public function edit(Topic $topic)
    {
        return view('topics.edit', compact('topic'));
    }

    /**
     * Cập nhật đề tài
     */
    public function update(Request $request, Topic $topic)
    {$validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'unique:topics,code,' . $topic->id,
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'max_students' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
            'status' => [
                'required',
                'in:Open,Closed',
            ],
        ]);

        /*
         * Không cho giảm số SV tối đa thấp hơn
         * số SV hiện đang đăng ký.
         */
        $registeredCount = $topic->topicRegistrations()->count();

        if ((int) $validated['max_students'] < $registeredCount) {
            return back()
                ->withErrors([
                    'max_students' =>
                        "Không thể giảm xuống {$validated['max_students']} vì hiện có {$registeredCount} sinh viên đăng ký.",
                ])
                ->withInput();
        }

        $topic->update($validated);

        return redirect()
            ->route('topics.index')
            ->with('success', 'Cập nhật đề tài thành công.');
    }

    /**
     * Xóa đề tài
     */
    public function destroy(Topic $topic)
    {
        if ($topic->topicRegistrations()->exists()) {
            return redirect()
                ->route('topics.index')
                ->with(
                    'error',
                    'Không thể xóa đề tài vì đã có sinh viên đăng ký.'
                );
        }

        if ($topic->topicAssignments()->exists()) {
            return redirect()
                ->route('topics.index')
                ->with(
                    'error',
                    'Không thể xóa đề tài vì đã có phân công giảng viên.'
                );
        }

        $topic->delete();

        return redirect()
            ->route('topics.index')
            ->with('success', 'Xóa đề tài thành công.');
    }
}