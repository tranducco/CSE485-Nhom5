@extends('layouts.admin')

@section('title', 'Sửa mốc thực hiện')

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

    <form
        action="{{ route('milestones.update', $milestone) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Đề tài</label><br>

            <select name="topic_id">

                @foreach($topics as $topic)

                    <option
                        value="{{ $topic->id }}"
                        {{ old('topic_id', $milestone->topic_id) == $topic->id ? 'selected' : '' }}
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
                value="{{ old('title', $milestone->title) }}"
            >
        </div>

        <div class="form-group">
            <label>Mô tả</label><br>

            <textarea
                name="description"
                rows="4"
            >{{ old('description', $milestone->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label><br>

            <input
                type="date"
                name="start_date"
                value="{{ old('start_date', $milestone->start_date) }}"
            >
        </div>

        <div class="form-group">
            <label>Hạn hoàn thành</label><br>

            <input
                type="date"
                name="due_date"
                value="{{ old('due_date', $milestone->due_date) }}"
            >
        </div>

        <div class="form-group">
            <label>Trạng thái</label><br>

            <select name="status">

                <option
                    value="Pending"
                    {{ old('status', $milestone->status) == 'Pending' ? 'selected' : '' }}
                >
                    Pending
                </option>

                <option
                    value="In Progress"
                    {{ old('status', $milestone->status) == 'In Progress' ? 'selected' : '' }}
                >
                    In Progress
                </option>

                <option
                    value="Completed"
                    {{ old('status', $milestone->status) == 'Completed' ? 'selected' : '' }}
                >
                    Completed
                </option>

                <option
                    value="Overdue"
                    {{ old('status', $milestone->status) == 'Overdue' ? 'selected' : '' }}
                >
                    Overdue
                </option>

            </select>
        </div>

        <button type="submit" class="btn">
            Cập nhật
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