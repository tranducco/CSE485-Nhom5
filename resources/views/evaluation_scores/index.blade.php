@extends('layouts.admin')

@section('title', 'Quản lý điểm đánh giá')

@section('content')

<div class="container-fluid py-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Danh sách điểm đánh giá</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>STT</th>
                            <th>Mã SV</th>
                            <th>Tên Sinh Viên</th>
                            <th>Tên Đề tài</th>
                            <th>Tiến độ nộp bài</th>
                            <th>Điểm đánh giá</th>
                            <th>Chi tiết tiêu chí</th>
                            <th>Thao tác</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($assignments as $assignment)

                        @php

                            /*
                             * Sinh viên đăng ký đề tài
                             */
                            $registration = $assignment->registration;

                            /*
                             * Lấy toàn bộ điểm theo tiêu chí
                             */
                            $evaluationScores = $assignment->evaluationScores;

                            /*
                             * Tổng điểm đã chấm
                             *
                             * Ví dụ:
                             * 45 + 20 + 25 = 90
                             */
                            $totalScore = $evaluationScores->sum('score');

                            /*
                             * Tổng điểm tối đa
                             *
                             * Ví dụ:
                             * 50 + 25 + 25 = 100
                             */
                            $maxScore = $evaluationScores->sum(function ($score) {
                                return $score->evaluationCriteria->max_score ?? 0;
                            });

                            /*
                             * Quy đổi về thang 10
                             *
                             * 90 / 100 * 10 = 9
                             */
                            $scoreOn10 = $maxScore > 0
                                ? ($totalScore / $maxScore) * 10
                                : 0;

                            /*
                             * Lấy các tiêu chí của assignment
                             */
                            $criteriaScores = $evaluationScores;

                            /*
                             * Tiến độ mốc
                             */
                            $topicMilestones = $registration
                                ? \App\Models\Milestone::where(
                                    'topic_id',
                                    $registration->topic_id
                                )->get()
                                : collect();

                            $totalMilestones = $topicMilestones->count();

                            $submittedCount = 0;

                            if (
                                $registration &&
                                $totalMilestones > 0
                            ) {

                                $submittedCount =
                                    \App\Models\MilestoneSubmission::whereIn(
                                        'milestone_id',
                                        $topicMilestones->pluck('id')
                                    )
                                    ->where(
                                        'student_id',
                                        $registration->student_id
                                    )
                                    ->count();
                            }

                        @endphp


                        <tr>

                            {{-- STT --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- MÃ SINH VIÊN --}}
                            <td>

                                {{ $registration?->student?->student_code
                                    ?? 'Lỗi dữ liệu' }}

                            </td>


                            {{-- TÊN SINH VIÊN --}}
                            <td>

                                <strong>

                                    {{ $registration?->student?->user?->name
                                        ?? 'Sinh viên ẩn danh' }}

                                </strong>

                            </td>


                            {{-- TÊN ĐỀ TÀI --}}
                            <td>

                                <strong>
                                    {{ $assignment->topic->title ?? 'Chưa có' }}
                                </strong>

                                <br>

                                <small class="text-muted">

                                    Mã:
                                    {{ $assignment->topic->topic_code
                                        ?? $assignment->topic->code
                                        ?? $assignment->topic->id }}

                                </small>

                            </td>


                            {{-- TIẾN ĐỘ --}}
                            <td class="text-center">

                                @if($totalMilestones > 0)

                                    <span
                                        class="badge
                                        {{ $submittedCount == $totalMilestones
                                            ? 'bg-success'
                                            : 'bg-warning text-dark' }}"
                                    >

                                        Đã nộp:
                                        {{ $submittedCount }}/{{ $totalMilestones }}

                                    </span>

                                    <br>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-info text-white mt-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#milestoneModal-{{ $assignment->id }}"
                                    >
                                        Xem bài nộp
                                    </button>

                                @else

                                    <span class="text-muted">
                                        Chưa giao mốc
                                    </span>

                                @endif

                            </td>


                            {{-- ĐIỂM ĐÁNH GIÁ --}}
                            <td class="text-center">

                                @if($evaluationScores->count() > 0)

                                    <strong
                                        style="
                                            color:#16a34a;
                                            font-size:18px;
                                        "
                                    >

                                        {{ number_format($scoreOn10, 2) }}

                                        / 10

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ number_format($totalScore, 2) }}
                                        /
                                        {{ number_format($maxScore, 2) }}

                                    </small>

                                @else

                                    <span class="text-muted">
                                        Chưa nhập
                                    </span>

                                @endif

                            </td>


                            {{-- CHI TIẾT TIÊU CHÍ --}}
                            <td>

                                @if($criteriaScores->count() > 0)

                                    <ul class="mb-0 ps-3">

                                        @foreach($criteriaScores as $score)

                                            <li>

                                                <strong>

                                                    {{ $score->evaluationCriteria->name
                                                        ?? 'Tiêu chí' }}

                                                </strong>

                                                :

                                                {{ number_format($score->score, 2) }}

                                                /

                                                {{ number_format(
                                                    $score->evaluationCriteria->max_score ?? 0,
                                                    2
                                                ) }}

                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    <span class="text-muted">
                                        Chưa có điểm
                                    </span>

                                @endif

                            </td>


                            {{-- THAO TÁC --}}
                            <td class="text-center">

                                <a
                                    href="{{ route(
                                        'evaluation-scores.create',
                                        $assignment->id
                                    ) }}"
                                    class="btn btn-warning btn-sm"
                                >

                                    {{ $evaluationScores->count() > 0
                                        ? 'Sửa điểm'
                                        : 'Nhập điểm' }}

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center text-muted py-4"
                            >

                                Chưa có sinh viên nào được duyệt.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- MODAL XEM BÀI NỘP --}}
    {{-- ================================================= --}}

    @foreach($assignments as $assignment)

        @php

            $registration = $assignment->registration;

            $topicMilestones = $registration
                ? \App\Models\Milestone::where(
                    'topic_id',
                    $registration->topic_id
                )->get()
                : collect();

        @endphp


        @if($registration && $topicMilestones->count() > 0)

            <div
                class="modal fade"
                id="milestoneModal-{{ $assignment->id }}"
                tabindex="-1"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">

                                Quá trình nộp bài -

                                {{ $registration->student->user->name
                                    ?? '' }}

                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>

                        </div>


                        <div class="modal-body">

                            <table class="table table-bordered">

                                <thead class="table-secondary">

                                    <tr>
                                        <th>Tên mốc</th>
                                        <th>Hạn nộp</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian nộp</th>
                                        <th>Tài liệu</th>
                                    </tr>

                                </thead>


                                <tbody>

                                @foreach($topicMilestones as $milestone)

                                    @php

                                        $submission =
                                            \App\Models\MilestoneSubmission::where(
                                                'milestone_id',
                                                $milestone->id
                                            )
                                            ->where(
                                                'student_id',
                                                $registration->student_id
                                            )
                                            ->first();

                                    @endphp


                                    <tr>

                                        <td>
                                            {{ $milestone->title }}
                                        </td>

                                        <td>

                                            @if($milestone->due_date)

                                                {{ \Carbon\Carbon::parse(
                                                    $milestone->due_date
                                                )->format('d/m/Y') }}

                                            @else

                                                -

                                            @endif

                                        </td>


                                        @if($submission)

                                            <td>
                                                <span class="badge bg-success">
                                                    Đã nộp
                                                </span>
                                            </td>

                                            <td>

                                                @if($submission->submitted_at)

                                                    {{ \Carbon\Carbon::parse(
                                                        $submission->submitted_at
                                                    )->format('H:i d/m/Y') }}

                                                @else

                                                    -

                                                @endif

                                            </td>

                                            <td>

                                                <a
                                                    href="{{ $submission->file_path }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-primary"
                                                >
                                                    Mở tài liệu
                                                </a>

                                            </td>

                                        @else

                                            <td>
                                                <span class="badge bg-secondary">
                                                    Chưa nộp
                                                </span>
                                            </td>

                                            <td>-</td>

                                            <td>-</td>

                                        @endif

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>


                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Đóng
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    @endforeach

</div>


{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection