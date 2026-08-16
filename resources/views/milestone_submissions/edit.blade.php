@extends('layouts.admin')

@section('title', 'Sửa bài nộp milestone')

@section('content')

<div class="card">

    <h2>Sửa bài nộp milestone</h2>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Có lỗi xảy ra:</strong>

            <ul style="margin-top: 8px; margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('milestone-submissions.update', $milestoneSubmission) }}"
    >

        @csrf
        @method('PUT')

        {{-- Milestone --}}
        <div class="form-group">

            <label for="milestone_id">
                <strong>Milestone</strong>
            </label>

            <select name="milestone_id" id="milestone_id" required>

                <option value="">-- Chọn milestone --</option>

                @foreach ($milestones as $milestone)

                    <option
                        value="{{ $milestone->id }}"
                        {{ old('milestone_id', $milestoneSubmission->milestone_id) == $milestone->id ? 'selected' : '' }}
                    >
                        {{ $milestone->title }}

                        @if ($milestone->topic)
                            - {{ $milestone->topic->title }}
                        @endif
                    </option>

                @endforeach

            </select>

        </div>


        {{-- Sinh viên --}}
        <div class="form-group">

            <label for="student_id">
                <strong>Sinh viên</strong>
            </label>

            <select name="student_id" id="student_id" required>

                <option value="">-- Chọn sinh viên --</option>

                @foreach ($students as $student)

                    <option
                        value="{{ $student->id }}"
                        {{ old('student_id', $milestoneSubmission->student_id) == $student->id ? 'selected' : '' }}
                    >
                        {{ $student->student_code }}

                        @if ($student->user)
                            - {{ $student->user->name }}
                        @endif
                    </option>

                @endforeach

            </select>

        </div>


        {{-- File --}}
        <div class="form-group">

            <label for="file_path">
                <strong>File bài nộp</strong>
            </label>

            <input
                type="text"
                name="file_path"
                id="file_path"
                value="{{ old('file_path', $milestoneSubmission->file_path) }}"
                placeholder="Tên hoặc đường dẫn file"
            >

        </div>


        {{-- Comment --}}
        <div class="form-group">

            <label for="comment">
                <strong>Ghi chú</strong>
            </label>

            <textarea
                name="comment"
                id="comment"
                rows="5"
                placeholder="Nhập ghi chú..."
            >{{ old('comment', $milestoneSubmission->comment) }}</textarea>

        </div>


        {{-- Thời gian nộp --}}
        <div class="form-group">

            <label for="submitted_at">
                <strong>Thời gian nộp</strong>
            </label>

            <input
                type="datetime-local"
                name="submitted_at"
                id="submitted_at"
                value="{{ old(
                    'submitted_at',
                    $milestoneSubmission->submitted_at
                        ? $milestoneSubmission->submitted_at->format('Y-m-d\TH:i')
                        : ''
                ) }}"
            >

        </div>


        {{-- Status --}}
        <div class="form-group">

            <label for="status">
                <strong>Trạng thái</strong>
            </label>

            <select name="status" id="status" required>

                <option
                    value="Pending"
                    {{ old('status', $milestoneSubmission->status) == 'Pending' ? 'selected' : '' }}
                >
                    Pending
                </option>

                <option
                    value="Submitted"
                    {{ old('status', $milestoneSubmission->status) == 'Submitted' ? 'selected' : '' }}
                >
                    Submitted
                </option>

                <option
                    value="Reviewed"
                    {{ old('status', $milestoneSubmission->status) == 'Reviewed' ? 'selected' : '' }}
                >
                    Reviewed
                </option>

            </select>

        </div>


        {{-- Buttons --}}
        <div style="margin-top: 20px;">

            <button type="submit" class="btn">
                Cập nhật
            </button>

            <a
                href="{{ route('milestone-submissions.show', $milestoneSubmission) }}"
                class="back-link"
                style="margin-left: 10px;"
            >
                Hủy
            </a>

        </div>

    </form>

</div>

@endsection