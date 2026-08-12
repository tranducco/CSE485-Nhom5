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

    <h2>Danh sách điểm đánh giá</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Giảng viên</th>
                <th>Mã đề tài</th>
                <th>Tên đề tài</th>
                <th>Ngày phân công</th>
                <th>Điểm</th>
                <th>Nhận xét</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        @forelse($assignments as $assignment)

            <tr>
                <td>{{ $assignment->id }}</td>

                <td>
                    {{ $assignment->lecturer->name ?? 'Chưa có' }}
                </td>

                <td>
                    {{ $assignment->topic->code ?? 'Chưa có' }}
                </td>

                <td>
                    {{ $assignment->topic->title ?? 'Chưa có' }}
                </td>

                <td>
                    {{ $assignment->assigned_date }}
                </td>

                <td>
                    @if($assignment->evaluationScore)
                        <strong style="color:#16a34a;">
                            {{ $assignment->evaluationScore->score }}
                        </strong>
                    @else
                        <span style="color:#6b7280;">
                            Chưa nhập
                        </span>
                    @endif
                </td>

                <td>
                    {{ $assignment->evaluationScore->comment ?? 'Chưa có' }}
                </td>

                <td style="white-space:nowrap;">

                    @if($assignment->evaluationScore)

                        {{-- Đã có điểm --}}
                        <a href="{{ route(
                            'evaluation-scores.create',
                            $assignment
                        ) }}"
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
                        <a href="{{ route(
                            'evaluation-scores.create',
                            $assignment
                        ) }}"
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

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" style="text-align:center;">
                    Chưa có phân công để đánh giá.
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>

</div>

@endsection
