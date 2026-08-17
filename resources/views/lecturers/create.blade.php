@extends('layouts.admin')

@section('title', 'Thêm giảng viên')

@section('content')

<div class="card">

    <h2>Thêm giảng viên</h2>

    <!-- HIỂN THỊ THÔNG BÁO LỖI TỔNG QUÁT NẾU CÓ -->
    @if ($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; margin-bottom: 15px; border-radius: 6px;">
            Vui lòng kiểm tra lại các thông tin bên dưới! Hệ thống đã phát hiện lỗi.
        </div>
    @endif

    <form action="{{ route('lecturers.store') }}" method="POST">
        @csrf

        <div>
            <label>Mã giảng viên</label>
            <br>
            <!-- Đổi name thành lecturer_code, thêm value = old() để giữ data khi nhập sai -->
            <input type="text" name="code" value="{{ old('code') }}" required style="width: 100%; padding: 8px;">
            <!-- Hiển thị lỗi riêng cho trường này -->
            @error('code')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <label>Họ tên</label>
            <br>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px;">
            @error('name')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <label>Email</label>
            <br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
            @error('email')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <br>
        
        <!-- TRƯỜNG MẬT KHẨU -->
        <div class="form-group mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <br>
            <input type="password" name="password" id="password" required style="width: 100%; padding: 8px;">
            <div style="font-size: 13px; color: #6c757d; margin-top: 5px;">
                Nhập mật khẩu để cấp tài khoản đăng nhập cho giảng viên (Tối thiểu 6 ký tự).
            </div>
            @error('password')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <label>Số điện thoại</label>
            <br>
            <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 8px;">
            @error('phone')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <label>Chuyên ngành</label>
            <br>

            <select name="specialization_id" required style="width: 100%; padding: 8px;">
                <option value="">
                    -- Chọn chuyên ngành --
                </option>

                @foreach($specializations as $specialization)
                    <!-- Giữ lại lựa chọn cũ bằng logic kiểm tra old() -->
                    <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                        {{ $specialization->name }}
                    </option>
                @endforeach
            </select>
            @error('specialization_id')
                <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
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
                font-size: 15px;
            ">
            Thêm giảng viên
        </button>

    </form>

    <br>

    <a href="{{ route('lecturers.index') }}" style="color: #2563eb; text-decoration: none;">
        ← Quay lại danh sách
    </a>

</div>

@endsection