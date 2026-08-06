@extends('layouts.admin')

@section('title', 'Quản lý Đề tài')

@section('content')

<div class="card">

    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:10px;margin-bottom:15px;border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ url('/topics/create') }}" class="btn">
        + Thêm đề tài
    </a>

    <table>

        <thead>
        <tr>
            <th>ID</th>
            <th>Mã</th>
            <th>Tên đề tài</th>
            <th>Mô tả</th>
            <th>Số SV tối đa</th>
            <th>Trạng thái</th>
        </tr>
        </thead>

        <tbody>

        @forelse($topics as $topic)

            <tr>
                <td>{{ $topic->id }}</td>
                <td>{{ $topic->code }}</td>
                <td>{{ $topic->title }}</td>
                <td>{{ $topic->description }}</td>
                <td>{{ $topic->max_students }}</td>
                <td>{{ $topic->status }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="6" style="text-align:center">
                    Chưa có dữ liệu.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <br>

    {{ $topics->links() }}

</div>

@endsection