@extends('layouts.admin')

@section('title', 'Sửa tiêu chí đánh giá')

@section('content')

<div class="card">

    <h2>Sửa tiêu chí đánh giá</h2>

    @if($errors->any())

        <div class="alert-error">

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        action="{{ route('evaluation-criterias.update', $evaluationCriteria) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="topic_id">
                Đề tài
            </label>

            <select
                name="topic_id"
                id="topic_id"
                required
            >

                <option value="">
                    -- Chọn đề tài --
                </option>

                @foreach($topics as $topic)

                    <option
                        value="{{ $topic->id }}"
                        {{ old('topic_id', $evaluationCriteria->topic_id) == $topic->id ? 'selected' : '' }}
                    >
                        {{ $topic->code }} - {{ $topic->title }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label for="name">
                Tên tiêu chí
            </label>

            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $evaluationCriteria->name) }}"
                required
            >

        </div>

        <div class="form-group">

            <label for="description">
                Mô tả
            </label>

            <textarea
                name="description"
                id="description"
                rows="4"
            >{{ old('description', $evaluationCriteria->description) }}</textarea>

        </div>

        <div class="form-group">

            <label for="max_score">
                Điểm tối đa
            </label>

            <input
                type="number"
                name="max_score"
                id="max_score"
                value="{{ old('max_score', $evaluationCriteria->max_score) }}"
                min="0"
                max="100"
                step="0.01"
                required
            >

        </div>

        <button
            type="submit"
            class="btn"
        >
            Cập nhật
        </button>

        <a
            href="{{ route('evaluation-criterias.index') }}"
            class="back-link"
        >
            Quay lại
        </a>

    </form>

</div>

@endsection