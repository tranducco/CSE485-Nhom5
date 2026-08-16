@extends('layouts.admin')

@section('title', 'Sửa đề tài')

@section('content')

<div class="card">

    <h2>Sửa đề tài</h2>

    <br>

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;margin-bottom:15px;border-radius:5px;">
            <ul style="margin:0 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('topics.update', $topic) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <p>
            <label>Mã đề tài</label><br>

            <input
                type="text"
                name="code"
                value="{{ old('code', $topic->code) }}"
                maxlength="20"
                style="width:100%;padding:8px;"
                required
            >
        </p>

        <br>

        <p>
            <label>Tên đề tài</label><br>

            <input
                type="text"
                name="title"
                value="{{ old('title', $topic->title) }}"
                maxlength="255"
                style="width:100%;padding:8px;"
                required
            >
        </p>

        <br>

        <p>
            <label>Mô tả</label><br>

            <textarea
                name="description"
                rows="5"
                maxlength="5000"
                style="width:100%;padding:8px;"
            >{{ old('description', $topic->description) }}</textarea>
        </p>

        <br>

        <p>
            <label>Số sinh viên tối đa</label><br>

            <input
                type="number"
                name="max_students"
                value="{{ old('max_students', $topic->max_students) }}"
                min="1"
                max="100"
                style="padding:8px;"
                required
            >
        </p>

        <br>

        <p>
            <label>Trạng thái</label><br>

            <select
                name="status"
                style="padding:8px;"
                required
            >
                <option
                    value="Open"
                    {{ old('status', $topic->status) === 'Open' ? 'selected' : '' }}
                >
                    Đang mở
                </option>

                <option
                    value="Closed"
                    {{ old('status', $topic->status) === 'Closed' ? 'selected' : '' }}
                >
                    Đã đóng
                </option>
            </select>
        </p>

        <br>

        <button type="submit" class="btn">
            Cập nhật
        </button>

        <a
            href="{{ route('topics.index') }}"
            class="btn"
            style="background:#6b7280;"
        >
            Quay lại
        </a>

    </form>

</div>

@endsection