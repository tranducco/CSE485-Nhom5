@extends('layouts.admin')

@section('title', 'Thêm bài nộp milestone')

@section('content')

<div class="card">

    <h2>Thêm bài nộp milestone</h2>

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('milestone-submissions.store') }}"
        method="POST"
    >
        @csrf

        <div class="form-group">
            <label for="milestone_id">
                Milestone
            </label>

            <select
                name="milestone_id"
                id="milestone_id"
                required
            >
                <option value="">-- Chọn milestone --</option>

                @foreach($milestones as $milestone)
                    <option
                        value="{{ $milestone->id }}"
                        {{ old('milestone_id') == $milestone->id ? 'selected' : '' }}
                    >
                        {{ $milestone->title }}
                        - {{ $milestone->topic->title ?? 'Không có đề tài' }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="student_id">
                Sinh viên
            </label>

            <select
                name="student_id"
                id="student_id"
                required
            >
                <option value="">-- Chọn sinh viên --</option>

                @foreach($students as $student)
                    <option
                        value="{{ $student->id }}"
                        {{ old('student_id') == $student->id ? 'selected' : '' }}
                    >
                        {{ $student->student_code }}
                        @if($student->user)
                            - {{ $student->user->name }}
                        @endif
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="file_path">
                Đường dẫn file
            </label>

            <input
                type="text"
                name="file_path"
                id="file_path"
                value="{{ old('file_path') }}"
                placeholder="Ví dụ: submissions/bai1.pdf"
            >
        </div>

        <div class="form-group">
            <label for="comment">
                Ghi chú
            </label>

            <textarea
                name="comment"
                id="comment"
                rows="5"
                placeholder="Nhập ghi chú..."
            >{{ old('comment') }}</textarea>
        </div>

        <div class="form-group">
            <label for="submitted_at">
                Thời gian nộp
            </label>

            <input
                type="datetime-local"
                name="submitted_at"
                id="submitted_at"
                value="{{ old('submitted_at') }}"
            >
        </div>

        <div class="form-group">
            <label for="status">
                Trạng thái
            </label>

            <select
                name="status"
                id="status"
                required
            >
                <option value="Pending"
                    {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="Submitted"
                    {{ old('status') == 'Submitted' ? 'selected' : '' }}>
                    Submitted
                </option>

                <option value="Reviewed"
                    {{ old('status') == 'Reviewed' ? 'selected' : '' }}>
                    Reviewed
                </option>
            </select>
        </div>

        <button type="submit" class="btn">
            Lưu bài nộp
        </button>

        <a
            href="{{ route('milestone-submissions.index') }}"
            class="back-link"
        >
            Quay lại
        </a>

    </form>

</div>

@endsection