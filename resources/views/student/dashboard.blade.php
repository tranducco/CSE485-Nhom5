@extends('layouts.student')

@section('title', 'Tổng quan Sinh viên')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">
        Chào mừng, {{ $user->name }}!
    </h2>

    <div class="row">

        <!-- ========================================= -->
        <!-- KHỐI 1: THÔNG TIN CÁ NHÂN -->
        <!-- ========================================= -->
        <div class="col-md-5 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-primary text-white fw-bold">
                    Thông tin Sinh viên
                </div>

                <div class="card-body">

                    @if($student)

                        <p>
                            <strong>Mã SV:</strong>
                            {{ $student->student_code }}
                        </p>

                        <p>
                            <strong>Lớp:</strong>
                            {{ $student->class_name }}
                        </p>

                        <p>
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </p>

                        <p>
                            <strong>Chuyên ngành:</strong>
                            {{ $student->specialization->name ?? 'Chưa cập nhật' }}
                        </p>

                    @else

                        <p class="text-danger">
                            Hồ sơ sinh viên chưa được thiết lập.
                            Vui lòng liên hệ Admin.
                        </p>

                    @endif

                </div>

            </div>

        </div>


        <!-- ========================================= -->
        <!-- KHỐI 2: TIẾN ĐỘ VÀ ĐIỂM -->
        <!-- ========================================= -->
        <div class="col-md-7 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-success text-white fw-bold">
                    Tiến độ Đồ án Tốt nghiệp
                </div>

                <div class="card-body">

                    @if(!$registration)

                        <div class="alert alert-warning">

                            Bạn chưa đăng ký đồ án nào.

                            <a
                                href="{{ route('student.topics.index') }}"
                                class="fw-bold text-decoration-none"
                            >
                                Nhấn vào đây để xem danh sách đề tài
                            </a>.

                        </div>

                    @else

                        <!-- TÊN ĐỀ TÀI -->
                        <h5 class="text-primary">
                            {{ $registration->topic->title ?? 'Không rõ tên đề tài' }}
                        </h5>

                        <hr>


                        <!-- TRẠNG THÁI -->
                        <p>
                            <strong>Trạng thái duyệt:</strong>

                            @if($registration->status == 'Chờ duyệt')

                                <span class="badge bg-warning text-dark">
                                    Chờ duyệt
                                </span>

                            @elseif($registration->status == 'Đã duyệt')

                                <span class="badge bg-success">
                                    Đã duyệt
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Bị từ chối
                                    (Bạn có thể đăng ký đề tài khác)
                                </span>

                            @endif
                        </p>


                        <!-- ========================================= -->
                        <!-- KHU VỰC ĐIỂM ĐÁNH GIÁ -->
                        <!-- ========================================= -->
                        @if($registration->status == 'Đã duyệt')

                            <div class="alert alert-info mt-3">

                                @if($finalScore !== null)

                                    <!-- ĐIỂM TỔNG -->
                                    <div class="mb-3">

                                        <strong>
                                            Điểm đánh giá:
                                        </strong>

                                        <span class="fs-4 text-danger fw-bold">
                                            {{ number_format($finalScore, 2) }} / 10
                                        </span>

                                    </div>


                                    <!-- CHI TIẾT TỪNG TIÊU CHÍ -->
                                    @if(isset($evaluationScores) && $evaluationScores->count() > 0)

                                        <div>

                                            <strong>
                                                Chi tiết:
                                            </strong>

                                            <ul class="mb-0 mt-2">

                                                @foreach($evaluationScores as $evaluationScore)

                                                    @if($evaluationScore->evaluationCriteria)

                                                        <li class="mb-1">

                                                            <strong>
                                                                {{ $evaluationScore->evaluationCriteria->name }}:
                                                            </strong>

                                                            {{ rtrim(rtrim(number_format($evaluationScore->score, 2), '0'), '.') }}

                                                            /

                                                            {{ rtrim(rtrim(number_format($evaluationScore->evaluationCriteria->max_score, 2), '0'), '.') }}

                                                        </li>

                                                    @endif

                                                @endforeach

                                            </ul>

                                        </div>

                                    @else

                                        <div>
                                            <strong>Điểm đánh giá:</strong>
                                            Chưa có điểm
                                        </div>

                                        <div class="mt-1">
                                            Đang chờ giảng viên chấm điểm...
                                        </div>

                                    @endif

                                @else

                                    <strong>
                                        Điểm đánh giá:
                                    </strong>

                                    Chưa có điểm

                                    <br>

                                    <strong>
                                        Trạng thái:
                                    </strong>

                                    Đang chờ giảng viên chấm điểm...

                                @endif

                            </div>

                        @endif

                    @endif

                </div>

            </div>

        </div>


        <!-- ========================================= -->
        <!-- PHẦN 3: QUẢN LÝ TIẾN ĐỘ & NỘP BÀI -->
        <!-- ========================================= -->

        <div class="col-12">

            <div class="card mt-2 shadow-sm">

                <div class="card-header bg-primary text-white">

                    <h4 class="mb-0">
                        📍 Tiến độ & Nộp tài liệu Đồ án
                    </h4>

                </div>

                <div class="card-body">


                    <!-- THÔNG BÁO THÀNH CÔNG -->
                    @if(session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    <!-- THÔNG BÁO LỖI -->
                    @if(session('error'))

                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    @endif


                    <!-- ========================================= -->
                    <!-- DANH SÁCH MILESTONE -->
                    <!-- ========================================= -->

                    @if(isset($milestones) && $milestones->count() > 0)

                        <div class="row">

                            @foreach($milestones as $m)

                                <div class="col-md-6 mb-4">

                                    <div class="card border-info h-100">

                                        <div class="card-body">

                                            <!-- TÊN MỐC -->
                                            <h5 class="card-title text-info fw-bold">
                                                {{ $m->title }}
                                            </h5>


                                            <!-- HẠN NỘP -->
                                            <p class="card-text text-muted mb-2">

                                                <small>

                                                    📅 Hạn nộp:

                                                    {{ \Carbon\Carbon::parse($m->due_date)->format('d/m/Y') }}

                                                </small>

                                            </p>


                                            <!-- MÔ TẢ -->
                                            <p class="card-text">
                                                {{ $m->description }}
                                            </p>

                                            <hr>


                                            <!-- ========================================= -->
                                            <!-- KIỂM TRA BÀI NỘP -->
                                            <!-- ========================================= -->

                                            @php

                                                $submission = $m->submissions()
                                                    ->where(
                                                        'student_id',
                                                        Auth::user()->student->id ?? 0
                                                    )
                                                    ->first();

                                            @endphp


                                            @if($submission)

                                                <!-- ĐÃ NỘP -->
                                                <div
                                                    class="alert alert-success p-2 mb-0"
                                                    style="font-size: 14px;"
                                                >

                                                    ✅

                                                    <strong>
                                                        Đã nộp lúc:
                                                    </strong>

                                                    {{ \Carbon\Carbon::parse(
                                                        $submission->submitted_at
                                                    )->format('H:i d/m/Y') }}

                                                    <br>

                                                    📄

                                                    <strong>
                                                        Tài liệu:
                                                    </strong>

                                                    <a
                                                        href="{{ $submission->file_path }}"
                                                        target="_blank"
                                                        class="fw-bold"
                                                    >
                                                        Xem link đã nộp
                                                    </a>

                                                </div>

                                            @else

                                                <!-- CHƯA NỘP -->
                                                <form
                                                    action="{{ route(
                                                        'student.milestones.submit',
                                                        $m->id
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    <div class="mb-2">

                                                        <label
                                                            class="form-label"
                                                            style="font-size: 14px;"
                                                        >
                                                            Link tài liệu
                                                            (Google Drive, Docs,
                                                            Github...):
                                                        </label>

                                                        <input
                                                            type="url"
                                                            name="file_path"
                                                            class="form-control form-control-sm"
                                                            placeholder="https://..."
                                                            required
                                                        >

                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-info text-white w-100"
                                                    >
                                                        🚀 Bấm để Nộp bài
                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="text-muted mb-0">
                            Chưa có mốc tiến độ nào được giao cho đề tài này.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>
@endsection