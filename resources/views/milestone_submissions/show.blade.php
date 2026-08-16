@extends('layouts.admin')

@section('title', 'Chi tiết bài nộp')

@section('content')

<div class="card">

    <h2>Chi tiết bài nộp</h2>

    <table>
        <tr>
            <th>Sinh viên</th>
            <td>
                @if($milestoneSubmission->student)
                    {{ $milestoneSubmission->student->student_code }}

                    @if($milestoneSubmission->student->user)
                        - {{ $milestoneSubmission->student->user->name }}
                    @endif
                @else
                    N/A
                @endif
            </td>
        </tr>

        <tr>
            <th>Đề tài</th>
            <td>
                @if($milestoneSubmission->milestone && $milestoneSubmission->milestone->topic)
                    {{ $milestoneSubmission->milestone->topic->title }}
                @else
                    N/A
                @endif
            </td>
        </tr>

        <tr>
            <th>Milestone</th>
            <td>
                @if($milestoneSubmission->milestone)
                    {{ $milestoneSubmission->milestone->title }}
                @else
                    N/A
                @endif
            </td>
        </tr>

        <tr>
            <th>File bài nộp</th>
            <td>
                {{ $milestoneSubmission->file_path ?? 'Không có file' }}
            </td>
        </tr>

        <tr>
            <th>Ghi chú</th>
            <td>
                {{ $milestoneSubmission->comment ?? 'Không có ghi chú' }}
            </td>
        </tr>

        <tr>
            <th>Thời gian nộp</th>
            <td>
                @if($milestoneSubmission->submitted_at)
                    {{ $milestoneSubmission->submitted_at->format('d/m/Y H:i') }}
                @else
                    Chưa nộp
                @endif
            </td>
        </tr>

        <tr>
            <th>Trạng thái</th>
            <td>
                {{ $milestoneSubmission->status }}
            </td>
        </tr>

        <tr>
            <th>Ngày tạo</th>
            <td>
                @if($milestoneSubmission->created_at)
                    {{ $milestoneSubmission->created_at->format('d/m/Y H:i') }}
                @endif
            </td>
        </tr>
    </table>

    <div style="margin-top: 20px;">

        <a
            href="{{ route('milestone-submissions.edit', $milestoneSubmission) }}"
            class="btn-edit"
        >
            Sửa
        </a>

        <a
            href="{{ route('milestone-submissions.index') }}"
            class="back-link"
            style="margin-left: 10px;"
        >
            Quay lại
        </a>

    </div>

</div>

@endsection