@extends('layouts.admin')

@section('title', 'Thêm giảng viên')

@section('content')

<div class="card">

    <h2>Thêm giảng viên</h2>

    <form action="{{ route('lecturers.store') }}" method="POST">
        @csrf

        <div>
            <label>Mã giảng viên</label>
            <br>
            <input type="text" name="code" required>
        </div>

        <br>

        <div>
            <label>Họ tên</label>
            <br>
            <input type="text" name="name" required>
        </div>

        <br>

        <div>
            <label>Email</label>
            <br>
            <input type="email" name="email" required>
        </div>

        <br>

        <div>
            <label>Số điện thoại</label>
            <br>
            <input type="text" name="phone">
        </div>

        <br>

        <!-- Thêm chuyên ngành -->
        <div>
            <label>Chuyên ngành</label>
            <br>

            <select name="specialization_id" required>
                <option value="">
                    -- Chọn chuyên ngành --
                </option>

                @foreach($specializations as $specialization)

                    <option value="{{ $specialization->id }}">
                        {{ $specialization->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <br>

        <button type="submit"
            style="
                background:#2563eb;
                color:white;
                padding:10px 20px;
                border:none;
                border-radius:6px;
                cursor:pointer;
            ">
            Thêm giảng viên
        </button>

    </form>

    <br>

    <a href="{{ route('lecturers.index') }}">
        ← Quay lại danh sách
    </a>

</div>

@endsection