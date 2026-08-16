<?php

namespace App\Http\Controllers;

use App\Models\MilestoneSubmission;
use App\Models\Milestone;
use App\Models\Student;
use Illuminate\Http\Request;

class MilestoneSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = MilestoneSubmission::with([
            'milestone.topic',
            'student.user'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'milestone_submissions.index',
            compact('submissions')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $milestones = Milestone::with('topic')
            ->orderBy('due_date')
            ->get();

        $students = Student::with('user')
            ->orderBy('student_code')
            ->get();

        return view(
            'milestone_submissions.create',
            compact('milestones', 'students')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'student_id' => 'required|exists:students,id',
            'file_path' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'status' => 'required|in:Pending,Submitted,Reviewed',
        ]);

        MilestoneSubmission::create($validated);

        return redirect()
            ->route('milestone-submissions.index')
            ->with('success', 'Thêm bài nộp thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MilestoneSubmission $milestoneSubmission)
    {
        $milestoneSubmission->load([
            'milestone.topic',
            'student.user'
        ]);

        return view(
            'milestone_submissions.show',
            compact('milestoneSubmission')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MilestoneSubmission $milestoneSubmission)
    {
        $milestones = Milestone::with('topic')
            ->orderBy('due_date')
            ->get();

        $students = Student::with('user')
            ->orderBy('student_code')
            ->get();

        return view(
            'milestone_submissions.edit',
            compact(
                'milestoneSubmission',
                'milestones',
                'students'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        MilestoneSubmission $milestoneSubmission
    ) {
        $validated = $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'student_id' => 'required|exists:students,id',
            'file_path' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'status' => 'required|in:Pending,Submitted,Reviewed',
        ]);

        $milestoneSubmission->update($validated);

        return redirect()
            ->route('milestone-submissions.index')
            ->with('success', 'Cập nhật bài nộp thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MilestoneSubmission $milestoneSubmission)
    {
        $milestoneSubmission->delete();

        return redirect()
            ->route('milestone-submissions.index')
            ->with('success', 'Xóa bài nộp thành công.');
    }
}