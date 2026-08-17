<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Milestone;
use App\Models\MilestoneSubmission;
use Illuminate\Support\Facades\Auth;

class StudentMilestoneController extends Controller
{
    public function submit(Request $request, Milestone $milestone)
    {
        $request->validate([
            'file_path' => 'required|url', // Validate phải là URL hợp lệ (nếu nộp link)
        ]);

        $student = Auth::user()->student; // Giả sử đã khai báo relation student() trong User model

        // Kiểm tra xem sinh viên này có thuộc đề tài của mốc này không (Logic tùy thuộc DB của cậu)
        // ...

        // Tạo bản ghi nộp bài
        MilestoneSubmission::updateOrCreate(
            [
                'milestone_id' => $milestone->id,
                'student_id' => $student->id,
            ],
            [
                'file_path' => $request->file_path,
                'comment' => 'Nộp bài qua form',
                'submitted_at' => now(),
                'status' => 'Submitted'
            ]
        );

        return back()->with('success', 'Nộp bài thành công!');
    }
}