@extends('layouts.admin')

@section('title', 'Chi tiết mốc thực hiện')

@section('content')

<div class="card">

    <p style="margin-bottom: 15px;">
        <strong>ID:</strong>
        {{ $milestone->id }}
    </p>

    <p style="margin-bottom: 15px;">
        <strong>Đề tài:</strong>
        {{ $milestone->topic->code ?? '—' }}
        -
        {{ $milestone->topic->title ?? 'Không xác định' }}
    </p>

    <p style="margin-bottom: 15px;">
        <strong>Tên mốc:</strong>
        {{ $milestone->title }}
    </p>

    <p style="margin-bottom: 15px;">
        <strong>Mô tả:</strong>
        {{ $milestone->description ?? 'Không có mô tả.' }}
    </p>

    <p style="margin-bottom: 15px;">
        <strong>Ngày bắt đầu:</strong>
        {{ \Carbon\Carbon::parse($milestone->start_date)->format('d/m/Y') }}
    </p>

    <p style="margin-bottom: 15px;">
        <strong>Hạn hoàn thành:</strong>
        {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}
    </p>

    <p style="margin-bottom: 20px;">
        <strong>Trạng thái:</strong>
        {{ $milestone->status }}
    </p>

    <a
        href="{{ route('milestones.edit', $milestone) }}"
        class="btn-edit"
    >
        Sửa
    </a>

    <a
        href="{{ route('milestones.index') }}"
        class="back-link"
        style="margin-left: 10px;"
    >
        Quay lại
    </a>

</div>

@endsection