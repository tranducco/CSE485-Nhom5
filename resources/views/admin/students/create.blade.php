@extends('layouts.admin')

@section('header_title', 'Thêm mới Sinh viên')

@section('content')
<div class="card">
    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Họ và tên:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" style="width: 100%; padding: 8px;" required>
            @error('name') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Email (Tài khoản đăng nhập):</label><br>
            <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 8px;" required>
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Mật khẩu:</label><br>
            <input type="password" name="password" style="width: 100%; padding: 8px;" required>
            @error('password') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Mã Sinh Viên:</label><br>
            <input type="text" name="student_code" value="{{ old('student_code') }}" style="width: 100%; padding: 8px;" required>
            @error('student_code') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Lớp:</label><br>
            <input type="text" name="class_name" value="{{ old('class_name') }}" style="width: 100%; padding: 8px;" required>
            @error('class_name') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label>Chuyên ngành:</label><br>
            <select name="specialization_id" style="width: 100%; padding: 8px;" required>
                <option value="">-- Chọn chuyên ngành --</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>
            @error('specialization_id') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn">Lưu sinh viên</button>
        <a href="{{ route('admin.students.index') }}" style="margin-left: 10px; color: #555;">Hủy quay lại</a>
    </form>
</div>
@endsection