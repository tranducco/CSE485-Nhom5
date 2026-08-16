@extends('layouts.admin')

@section('title', 'Chi tiết tiêu chí đánh giá')

@section('content')

<div class="card">

    <h2>Chi tiết tiêu chí đánh giá</h2>

    <table>

        <tr>
            <th>Đề tài</th>
            <td>
                {{ $evaluationCriteria->topic->title ?? 'N/A' }}
            </td>
        </tr>

        <tr>
            <th>Mã đề tài</th>
            <td>
                {{ $evaluationCriteria->topic->code ?? 'N/A' }}
            </td>
        </tr>

        <tr>
            <th>Tên tiêu chí</th>
            <td>
                {{ $evaluationCriteria->name }}
            </td>
        </tr>

        <tr>
            <th>Mô tả</th>
            <td>
                {{ $evaluationCriteria->description ?? 'Không có mô tả' }}
            </td>
        </tr>

        <tr>
            <th>Điểm tối đa</th>
            <td>
                {{ $evaluationCriteria->max_score }}
            </td>
        </tr>

        <tr>
            <th>Ngày tạo</th>
            <td>
                {{ $evaluationCriteria->created_at?->format('d/m/Y H:i') }}
            </td>
        </tr>

        <tr>
            <th>Cập nhật lần cuối</th>
            <td>
                {{ $evaluationCriteria->updated_at?->format('d/m/Y H:i') }}
            </td>
        </tr>

    </table>

    <div style="margin-top: 20px;">

        <a
            href="{{ route('evaluation-criterias.edit', $evaluationCriteria) }}"
            class="btn-edit"
        >
            Sửa
        </a>

        <a
            href="{{ route('evaluation-criterias.index') }}"
            class="back-link"
            style="margin-left: 10px;"
        >
            Quay lại
        </a>

    </div>

</div>

@endsection