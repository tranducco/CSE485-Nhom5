@extends('layouts.admin')

@section('title', 'Quản lý Điểm đánh giá')

@section('content')

<div class="card">

    @if(session('success'))
        <div style="
            background:#d1fae5;
            color:#065f46;
            padding:12px;
            margin-bottom:15px;
            border-radius:6px;
        ">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="
            background:#fee2e2;
            color:#991b1b;
            padding:12px;
            margin-bottom:15px;
            border-radius:6px;
        ">
            {{ session('error') }}
        </div>
    @endif

    <h2>Danh sách điểm đánh giá</h2>

    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID Đơn</th>
                <th>Mã SV</th>
                <th>Tên Sinh Viên</th> 
                <th>Tên Đề tài</th>
                <th>Tiến độ nộp bài</th> <!-- CỘT MỚI THÊM VÀO -->
                <th>Điểm</th>
                <th>Nhận xét</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        @forelse($approvedRegistrations as $registration)

            @php
                // Tìm thông tin Assignment tương ứng với Đề tài này
                $assignment = \App\Models\TopicAssignment::where('topic_id', $registration->topic_id)->first();
                
                // Lấy điểm (nếu đã chấm)
                $scoreRecord = null;
                if ($assignment && isset($scores[$assignment->id])) {
                    $scoreRecord = $scores[$assignment->id];
                }

                // Truy vấn số lượng mốc và số bài đã nộp của sinh viên này
                $topicMilestones = \App\Models\Milestone::where('topic_id', $registration->topic_id)->get();
                $totalMilestones = $topicMilestones->count();
                $submittedCount = 0;
                
                if($totalMilestones > 0) {
                    $submittedCount = \App\Models\MilestoneSubmission::whereIn('milestone_id', $topicMilestones->pluck('id'))
                                        ->where('student_id', $registration->student_id)
                                        ->count();
                }
            @endphp

            <tr>
                <td>{{ $registration->id }}</td>

                <td>
                    {{ $registration->student->student_code ?? 'Lỗi Dữ Liệu' }}
                </td>

                <td style="font-weight: bold; color: #1f2937;">
                    {{ $registration->student->user->name ?? 'Sinh viên ẩn danh' }}
                </td>

                <td>
                    {{ $registration->topic->title ?? 'Chưa có' }}
                    <br>
                    <small class="text-muted">Mã: {{ $registration->topic->topic_code ?? $registration->topic->id }}</small>
                </td>
                
                <!-- CỘT HIỂN THỊ TIẾN ĐỘ VÀ NÚT XEM BÀI NỘP -->
                <td class="text-center">
                    @if($totalMilestones > 0)
                        <span class="badge {{ $submittedCount == $totalMilestones ? 'bg-success' : 'bg-warning text-dark' }}">
                            Đã nộp: {{ $submittedCount }}/{{ $totalMilestones }} mốc
                        </span>
                        <br>
                        <button type="button" class="btn btn-sm btn-info text-white mt-2" data-bs-toggle="modal" data-bs-target="#milestoneModal-{{ $registration->id }}" style="font-size: 12px;">
                            👁️ Xem bài nộp
                        </button>
                    @else
                        <span style="color:#6b7280; font-size: 12px; font-style: italic;">Chưa giao mốc</span>
                    @endif
                </td>

                <td>
                    @if($scoreRecord)
                        <strong style="color:#16a34a; font-size: 16px;">
                            {{ $scoreRecord->score }}
                        </strong>
                    @else
                        <span style="color:#6b7280; font-style: italic;">
                            Chưa nhập
                        </span>
                    @endif
                </td>

                <td>
                    {{ $scoreRecord->comment ?? '...' }}
                </td>

                <td style="white-space:nowrap;">

                    @if($assignment)
                        @if($scoreRecord)
                            {{-- Đã có điểm --}}
                            <a href="{{ route('evaluation-scores.create', $assignment->id) }}"
                            style="
                                display:inline-block;
                                background:#f59e0b;
                                color:white;
                                padding:7px 12px;
                                border-radius:5px;
                                text-decoration:none;
                            ">
                                ✏️ Sửa điểm
                            </a>
                        @else
                            {{-- Chưa có điểm --}}
                            <a href="{{ route('evaluation-scores.create', $assignment->id) }}"
                            style="
                                display:inline-block;
                                background:#2563eb;
                                color:white;
                                padding:7px 12px;
                                border-radius:5px;
                                text-decoration:none;
                            ">
                                ➕ Nhập điểm
                            </a>
                        @endif
                    @else
                        <span style="color: red; font-size: 12px;">Admin chưa phân công</span>
                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" style="text-align:center; padding: 20px; color: #6b7280;">
                    Hiện tại chưa có sinh viên nào được duyệt tham gia các đề tài do bạn hướng dẫn.
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>

</div>

<!-- ========================================== -->
<!-- MODAL XEM CHI TIẾT BÀI NỘP CỦA SINH VIÊN -->
<!-- ========================================== -->
@foreach($approvedRegistrations as $registration)
    @php
        $topicMilestones = \App\Models\Milestone::where('topic_id', $registration->topic_id)->get();
    @endphp

    @if($topicMilestones->count() > 0)
    <div class="modal fade" id="milestoneModal-{{ $registration->id }}" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Quá trình nộp bài - Sinh viên: {{ $registration->student->user->name ?? '' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Tên mốc (Hạn nộp)</th>
                                <th>Trạng thái nộp</th>
                                <th>Thời gian nộp</th>
                                <th>Tài liệu đính kèm</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topicMilestones as $m)
                                @php
                                    $submission = \App\Models\MilestoneSubmission::where('milestone_id', $m->id)
                                                        ->where('student_id', $registration->student_id)
                                                        ->first();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $m->title }}</strong><br>
                                        <small class="text-danger">Hạn: {{ \Carbon\Carbon::parse($m->due_date)->format('d/m/Y') }}</small>
                                    </td>
                                    
                                    @if($submission)
                                        <td><span class="badge bg-success">Đã nộp</span></td>
                                        <td>{{ \Carbon\Carbon::parse($submission->submitted_at)->format('H:i d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ $submission->file_path }}" target="_blank" class="btn btn-sm btn-primary">Mở link tài liệu</a>
                                        </td>
                                    @else
                                        <td><span class="badge bg-secondary">Chưa nộp</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng cửa sổ</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<!-- Script Bootstrap để Modal hoạt động -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection