@extends('layouts.admin')

@section('content')
    <table border="1" cellpadding="10">
        <tr>
            <th>Mã SV</th>
            <th>Họ và Tên</th>
            <th>Email</th>
            <th>Lớp</th>
            <th>Chuyên ngành</th>
        </tr>
        @foreach($students as $sv)
        <tr>
            <td>{{ $sv->student_code }}</td>
            <td>{{ $sv->user->name }}</td>
            <td>{{ $sv->user->email }}</td>
            <td>{{ $sv->class_name }}</td>
            <td>{{ $sv->specialization->name }}</td>
        </tr>
        @endforeach
    </table>
@endsection