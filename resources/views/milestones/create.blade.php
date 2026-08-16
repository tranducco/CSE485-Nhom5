@extends('layouts.admin')

@section('title', 'Thêm mốc thực hiện')

@section('content')

<div class="card">

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('milestones.store') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>Đề tài</label><br>

            <select name="topic_id">

                <option value="">
                    -- Chọn đề tài --
                </option>

                @foreach($topics as $topic)

                    <option
                        value="{{ $topic->id }}"
                        {{ old('topic_id') == $topic->id ? 'selected' : '' }}
                    >
                        {{ $topic->code }} - {{ $topic->title }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Tên mốc</label><br>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Ví dụ: Hoàn thành phân tích yêu cầu"
            >
        </div>

        <div class="form-group">
            <label>Mô tả</label><br>

            <textarea
                name="description"
                rows="4"
                placeholder="Mô tả nội dung mốc thực hiện..."
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label><br>

            <input
                type="date"
                name="start_date"
                value="{{ old('start_date') }}"
            >
        </div>

        <div class="form-group">
            <label>Hạn hoàn thành</label><br>

            <input
                type="date"
                name="due_date"
                value="{{ old('due_date') }}"
            >
        </div>

        <div class="form-group">
            <label>Trạng thái</label><br>

            <select name="status">

                <option
                    value="Pending"
                    {{ old('status', 'Pending') == 'Pending' ? 'selected' : '' }}
                >
                    Pending
                </option>

                <option
                    value="In Progress"
                    {{ old('status') == 'In Progress' ? 'selected' : '' }}
                >
                    In Progress
                </option>

                <option
                    value="Completed"
                    {{ old('status') == 'Completed' ? 'selected' : '' }}
                >
                    Completed
                </option>

                <option
                    value="Overdue"
                    {{ old('status') == 'Overdue' ? 'selected' : '' }}
                >
                    Overdue
                </option>

            </select>
        </div>

        <button type="submit" class="btn">
            Lưu
        </button>

        <a
            href="{{ route('milestones.index') }}"
            class="back-link"
        >
            Quay lại
        </a>

    </form>

</div>

@endsection