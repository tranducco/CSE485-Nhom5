@extends('layouts.admin')

@section('title', 'Thêm phân công')

@section('content')

<div class="card">

    <h2>Thêm phân công hướng dẫn</h2>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('topic-assignments.store') }}"
        method="POST"
    >

        @csrf

        <label>Giảng viên</label>
        <br>

        <select name="lecturer_id" required>

            <option value="">
                -- Chọn giảng viên --
            </option>

            @foreach($lecturers as $lecturer)

                <option value="{{ $lecturer->id }}">

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

            <option value="">
                -- Chọn đề tài --
            </option>

            @foreach($topics as $topic)

                <option value="{{ $topic->id }}">

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
            value="{{ old('assigned_date', date('Y-m-d')) }}"
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
            Lưu phân công
        </button>

    </form>

    <br>

    <a href="{{ route('topic-assignments.index') }}">
        ← Quay lại
    </a>

</div>

@endsection
