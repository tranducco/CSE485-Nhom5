@extends('layouts.admin')

@section('title', 'Quản lý Giảng viên')

@section('content')

<div class="card">

    <div style="margin-bottom:15px;">
        <a href="{{ route('lecturers.create') }}"
           style="
                display:inline-block;
                padding:10px 18px;
                background:#007bff;
                color:white;
                text-decoration:none;
                border-radius:5px;
           ">
            + Thêm giảng viên
        </a>
    </div>

    <h2>Danh sách giảng viên</h2>


    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Mã GV</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
            </tr>
        </thead>


        <tbody>

        @foreach($lecturers as $lecturer)

            <tr>
                <td>{{ $lecturer->id }}</td>
                <td>{{ $lecturer->code }}</td>
                <td>{{ $lecturer->name }}</td>
                <td>{{ $lecturer->email }}</td>
                <td>{{ $lecturer->phone }}</td>
            </tr>

        @endforeach

        </tbody>


    </table>


</div>

@endsection
