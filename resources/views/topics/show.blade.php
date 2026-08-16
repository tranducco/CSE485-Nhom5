@extends('layouts.admin')

@section('title', 'Chi tiết đề tài')

@section('content')

<div class="card">

    <h2>{{ $topic->title }}</h2>

    <table>

        <tr>
            <th style="width:200px;">ID</th>
            <td>{{ $topic->id }}</td>
        </tr>

        <tr>
            <th>Mã đề tài</th>
            <td>{{ $topic->code }}</td>
        </tr>

        <tr>
            <th>Tên đề tài</th>
            <td>{{ $topic->title }}</td>
        </tr>

        <tr>
            <th>Mô tả</th>
            <td>
                {{ $topic->description ?: 'Chưa có mô tả.' }}
            </td>
        </tr>

        <tr>
            <th>Số sinh viên tối đa</th>
            <td>{{ $topic->max_students }}</td>
        </tr>

        <tr>
            <th>Số sinh viên đã đăng ký</th>
            <td>
                {{ $topic->topic_registrations_count }}
            </td>
        </tr>

        <tr>
            <th>Phân công giảng viên</th>
            <td>
                {{ $topic->topic_assignments_count }}
            </td>
        </tr>

        <tr>
            <th>Trạng thái</th>
            <td>
                {{ $topic->status === 'Open'
                    ? 'Đang mở'
                    : 'Đã đóng' }}
            </td>
        </tr>

        <tr>
            <th>Ngày tạo</th>
            <td>
                {{ $topic->created_at?->format('d/m/Y H:i') }}
            </td>
        </tr>

    </table>

    <br>

    <a
        href="{{ route('topics.edit', $topic) }}"
        class="btn"
    >
        Sửa đề tài
    </a>

    <a
        href="{{ route('topics.index') }}"
        class="btn"
        style="background:#6b7280;"
    >
        Quay lại
    </a>

</div>

@endsection