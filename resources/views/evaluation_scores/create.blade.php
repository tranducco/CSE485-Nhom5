@extends('layouts.admin')

@section('title', 'Chấm điểm đánh giá')

@section('content')

<div class="card">

    <h2>Chấm điểm đánh giá</h2>

    <p>
        <strong>Giảng viên:</strong>
        {{ $topicAssignment->lecturer->name ?? 'Không có' }}
    </p>

    <p>
        <strong>Đề tài:</strong>
        {{ $topicAssignment->topic->code ?? '' }}
        -
        {{ $topicAssignment->topic->title ?? '' }}
    </p>

    @if($registration && $registration->student)

        <p>
            <strong>Sinh viên:</strong>
            {{ $registration->student->user->name ?? 'Không có tên' }}
        </p>

        <p>
            <strong>Mã sinh viên:</strong>
            {{ $registration->student->student_code ?? 'Không có' }}
        </p>

    @else

        <div
            style="
                background:#fef3c7;
                color:#92400e;
                padding:12px;
                border-radius:6px;
                margin:15px 0;
            "
        >
            Đề tài này chưa có sinh viên đăng ký được duyệt.
        </div>

    @endif


    {{-- Hiển thị lỗi --}}
    @if($errors->any())

        <div
            style="
                background:#fee2e2;
                color:#991b1b;
                padding:12px;
                border-radius:6px;
                margin:15px 0;
            "
        >

            <ul style="margin:0; padding-left:20px;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Thông báo lỗi --}}
    @if(session('error'))

        <div
            style="
                background:#fee2e2;
                color:#991b1b;
                padding:12px;
                border-radius:6px;
                margin:15px 0;
            "
        >
            {{ session('error') }}
        </div>

    @endif


    @if($criteria->isEmpty())

        <div
            style="
                background:#fef3c7;
                color:#92400e;
                padding:15px;
                border-radius:6px;
                margin:20px 0;
            "
        >
            <strong>Chưa có tiêu chí đánh giá.</strong>

            <br>

            Hãy tạo tiêu chí cho đề tài này trước khi chấm điểm.
        </div>

    @else

        <form
            action="{{ route(
                'evaluation-scores.store',
                $topicAssignment
            ) }}"
            method="POST"
        >

            @csrf


            <h3 style="margin-top:25px;">
                Các tiêu chí đánh giá
            </h3>


            <table style="width:100%; border-collapse:collapse;">

                <thead>

                    <tr>

                        <th
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:left;
                            "
                        >
                            STT
                        </th>

                        <th
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:left;
                            "
                        >
                            Tiêu chí
                        </th>

                        <th
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:left;
                            "
                        >
                            Mô tả
                        </th>

                        <th
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:center;
                            "
                        >
                            Điểm tối đa
                        </th>

                        <th
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:center;
                            "
                        >
                            Điểm
                        </th>

                    </tr>

                </thead>


                <tbody>

                @foreach($criteria as $index => $criterion)

                    @php

                        $existingScore =
                            $existingScores->get($criterion->id);

                        $currentScore =
                            $existingScore->score ?? '';

                        $currentComment =
                            $existingScore->comment ?? '';

                    @endphp


                    <tr>

                        {{-- STT --}}
                        <td
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:center;
                            "
                        >
                            {{ $index + 1 }}
                        </td>


                        {{-- Tên tiêu chí --}}
                        <td
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                            "
                        >

                            <strong>
                                {{ $criterion->name }}
                            </strong>

                        </td>


                        {{-- Mô tả --}}
                        <td
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                            "
                        >

                            {{ $criterion->description ?? 'Không có mô tả' }}

                        </td>


                        {{-- Điểm tối đa --}}
                        <td
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:center;
                            "
                        >

                            <strong>
                                {{ $criterion->max_score }}
                            </strong>

                        </td>


                        {{-- Điểm --}}
                        <td
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                text-align:center;
                            "
                        >

                            <input
                                type="number"
                                name="scores[{{ $criterion->id }}]"
                                value="{{ old(
                                    'scores.' . $criterion->id,
                                    $currentScore
                                ) }}"
                                min="0"
                                max="{{ $criterion->max_score }}"
                                step="0.01"
                                style="
                                    width:90px;
                                    padding:7px;
                                    border:1px solid #ccc;
                                    border-radius:5px;
                                "
                                required
                            >

                        </td>

                    </tr>


                    {{-- Nhận xét --}}
                    <tr>

                        <td
                            colspan="5"
                            style="
                                border:1px solid #ddd;
                                padding:10px;
                                background:#f9fafb;
                            "
                        >

                            <label>
                                <strong>
                                    Nhận xét cho:
                                    {{ $criterion->name }}
                                </strong>
                            </label>

                            <br>

                            <textarea
                                name="comments[{{ $criterion->id }}]"
                                rows="2"
                                style="
                                    width:100%;
                                    margin-top:6px;
                                    padding:8px;
                                    border:1px solid #ccc;
                                    border-radius:5px;
                                "
                            >{{ old(
                                'comments.' . $criterion->id,
                                $currentComment
                            ) }}</textarea>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>


            {{-- Tổng điểm --}}
            <div
                style="
                    margin-top:20px;
                    padding:15px;
                    background:#f3f4f6;
                    border-radius:6px;
                "
            >

                <strong>
                    Tổng điểm tối đa:
                </strong>

                {{ $criteria->sum('max_score') }}

            </div>


            <br>


            <button
                type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    padding:10px 20px;
                    border:none;
                    border-radius:6px;
                    cursor:pointer;
                "
            >
                Lưu điểm
            </button>

        </form>

    @endif


    <br>

    <a href="{{ route('evaluation-scores.index') }}">
        ← Quay lại
    </a>

</div>

@endsection