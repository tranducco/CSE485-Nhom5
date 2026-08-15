@extends('layouts.admin')

@section('content')
    <a href="{{ route('admin.students.create') }}" class="btn">+ Thêm sinh viên mới</a>
    <h2>Danh sách sinh viên</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Mã SV</th>
            <th>Họ và Tên</th>
            <th>Email</th>
            <th>Lớp</th>
            <th>Chuyên ngành</th>
            <th>Hành động</th>
        </tr>
        @foreach($students as $sv)
        <tr>
            <td>{{ $sv->student_code }}</td>
            <td>{{ $sv->user->name }}</td>
            <td>{{ $sv->user->email }}</td>
            <td>{{ $sv->class_name }}</td>
            <td>{{ $sv->specialization->name }}</td>
            <td>
                <div style="display: flex; gap: 5px;">
                    <!-- Nút Sửa -->
                    <a href="{{ route('admin.students.edit', $sv->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                    <!-- Form Xóa -->
                    <form action="{{ route('admin.students.destroy', $sv->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
@endsection