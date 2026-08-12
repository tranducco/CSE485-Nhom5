@extends('layouts.admin')

@section('title', 'Nhập điểm đánh giá')

@section('content')

<div class="card">

    <h2>Nhập điểm đánh giá</h2>

    <p>
        <strong>Giảng viên:</strong>
        {{ $topicAssignment->lecturer->name }}
    </p>

    <p>
        <strong>Đề tài:</strong>
        {{ $topicAssignment->topic->code }}
        -
        {{ $topicAssignment->topic->title }}
    </p>

    <br>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'evaluation-scores.store',
            $topicAssignment
        ) }}"
        method="POST"
    >

        @csrf

        <label>Điểm</label>
        <br>

        <input
            type="number"
            name="score"
            min="0"
            max="10"
            step="0.1"
            value="{{ old(
                'score',
                $topicAssignment->evaluationScore->score ?? ''
            ) }}"
            required
        >

        <br><br>

        <label>Nhận xét</label>
        <br>

        <textarea
            name="comment"
            rows="5"
            style="width:100%;"
        >{{ old(
            'comment',
            $topicAssignment->evaluationScore->comment ?? ''
        ) }}</textarea>

        <br><br>

        <button type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    padding:10px 20px;
                    border:none;
                    border-radius:6px;
                ">
            Lưu điểm
        </button>

    </form>

    <br>

    <a href="{{ route('evaluation-scores.index') }}">
        ← Quay lại
    </a>

</div>

@endsection
