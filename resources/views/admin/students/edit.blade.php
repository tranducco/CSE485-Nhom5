@extends('layouts.admin')

@section('title', 'Sửa thông tin Sinh viên')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chỉnh sửa thông tin Sinh viên</h2>
        <!-- Nút quay lại trang danh sách -->
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <!-- Hiển thị thông báo lỗi chung nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            Vui lòng kiểm tra lại các trường dữ liệu bên dưới.
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Form cập nhật dữ liệu, trỏ về hàm update và truyền ID sinh viên -->
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Mã sinh viên -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                        <input type="text" name="student_code" class="form-control @error('student_code') is-invalid @enderror" 
                               value="{{ old('student_code', $student->student_code) }}" required>
                        @error('student_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Họ và tên -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $student->user->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email', $student->user->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lớp học -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lớp học</label>
                        <input type="text" name="class_name" class="form-control @error('class_name') is-invalid @enderror" 
                                value="{{ old('class_name', $student->class_name) }}">
                        @error('class_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Chuyên ngành (Khóa ngoại) -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Chuyên ngành <span class="text-danger">*</span></label>
                        <select name="specialization_id" class="form-select @error('specialization_id') is-invalid @enderror" required>
                            <option value="">-- Chọn chuyên ngành --</option>
                            @foreach($specializations as $spec)
                                <!-- Kiểm tra nếu ID chuyên ngành khớp với dữ liệu cũ hoặc dữ liệu hiện tại của sinh viên thì tự động selected -->
                                <option value="{{ $spec->id }}" @selected(old('specialization_id', $student->specialization_id) == $spec->id)>
                                    {{ $spec->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialization_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <button type="reset" class="btn btn-light border">Nhập lại</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection