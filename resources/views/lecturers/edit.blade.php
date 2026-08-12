@extends('layouts.admin')

@section('title', 'Sửa giảng viên')

@section('content')

<div class="card">

    <h2>Sửa giảng viên</h2>

    @if($errors->any())
        <div style="
            background:#fee2e2;
            color:#991b1b;
            padding:12px;
            border-radius:6px;
            margin-bottom:15px;
        ">
            <ul style="margin-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lecturers.update', $lecturer) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div>
            <label>Mã giảng viên</label>
            <br>

            <input type="text"
                   name="code"
                   value="{{ old('code', $lecturer->code) }}"
                   required>
        </div>

        <br>

        <div>
            <label>Họ tên</label>
            <br>

            <input type="text"
                   name="name"
                   value="{{ old('name', $lecturer->name) }}"
                   required>
        </div>

        <br>

        <div>
            <label>Email</label>
            <br>

            <input type="email"
                   name="email"
                   value="{{ old('email', $lecturer->email) }}"
                   required>
        </div>

        <br>

        <div>
            <label>Số điện thoại</label>
            <br>

            <input type="text"
                   name="phone"
                   value="{{ old('phone', $lecturer->phone) }}">
        </div>

        <br>

        <div>
            <label>Chuyên ngành</label>
            <br>

            <select name="specialization_id" required>

                <option value="">
                    -- Chọn chuyên ngành --
                </option>

                @foreach($specializations as $specialization)

                    <option value="{{ $specialization->id }}"
                        {{ old(
                            'specialization_id',
                            $lecturer->specialization_id
                        ) == $specialization->id ? 'selected' : '' }}>

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
            Cập nhật
        </button>

    </form>

    <br>

    <a href="{{ route('lecturers.index') }}">
        ← Quay lại danh sách
    </a>

</div>

@endsection
