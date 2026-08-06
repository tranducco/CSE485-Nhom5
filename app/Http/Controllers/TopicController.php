<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Hiển thị danh sách đề tài
     */
    public function index()
    {
        $topics = Topic::orderBy('code')->paginate(10);

        return view('topics.index', compact('topics'));
    }

    /**
     * Hiển thị form thêm đề tài
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
        $request->validate([
            'code' => 'required|unique:topics,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:Open,Closed',
        ]);

        Topic::create([
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'max_students' => $request->max_students,
            'status' => $request->status,
        ]);

        return redirect('/topics')
            ->with('success', 'Thêm đề tài thành công!');
    }
}