@extends('layouts.admin')

@section('title', 'Sửa phân công')

@section('content')

<div class="card">

    <h2>Sửa phân công</h2>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'topic-assignments.update',
            $topicAssignment
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <label>Giảng viên</label>
        <br>

        <select name="lecturer_id" required>

            @foreach($lecturers as $lecturer)

                <option
                    value="{{ $lecturer->id }}"
                    {{ $topicAssignment->lecturer_id == $lecturer->id
                        ? 'selected'
                        : '' }}
                >

                    {{ $lecturer->code }}
                    -
                    {{ $lecturer->name }}

                </option>

            @endforeach

        </select>

        <br><br>

        <label>Đề tài</label>
        <br>

        <select name="topic_id" required>

            @foreach($topics as $topic)

                <option
                    value="{{ $topic->id }}"
                    {{ $topicAssignment->topic_id == $topic->id
                        ? 'selected'
                        : '' }}
                >

                    {{ $topic->code }}
                    -
                    {{ $topic->title }}

                </option>

            @endforeach

        </select>

        <br><br>

        <label>Ngày phân công</label>
        <br>

        <input
            type="date"
            name="assigned_date"
            value="{{ $topicAssignment->assigned_date }}"
            required
        >

        <br><br>

        <button type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    padding:10px 20px;
                    border:none;
                    border-radius:6px;
                ">
            Cập nhật
        </button>

    </form>

    <br>

    <a href="{{ route('topic-assignments.index') }}">
        ← Quay lại
    </a>

</div>

@endsection
