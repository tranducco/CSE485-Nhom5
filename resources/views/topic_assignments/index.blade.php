@extends('layouts.admin')

@section('title', 'Quản lý Phân công')

@section('content')

<div class="card">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <a
        href="{{ route('topic-assignments.create') }}"
        class="btn btn-add"
    >
        + Thêm phân công
    </a>

    <h2>Danh sách phân công hướng dẫn</h2>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Giảng viên</th>
                <th>Chuyên môn</th>
                <th>Mã đề tài</th>
                <th>Tên đề tài</th>
                <th>Ngày phân công</th>
                <th>Điểm</th>
                <th>Thao tác</th>
            </tr>

        </thead>

        <tbody>

        @forelse($assignments as $assignment)

            <tr>

                <td>
                    {{ $assignment->id }}
                </td>

                <td>
                    {{ $assignment->lecturer->name ?? 'Không có' }}
                </td>

                <td>
                    {{ $assignment->lecturer->specialization->name ?? 'Chưa có' }}
                </td>

                <td>
                    {{ $assignment->topic->code ?? 'Không có' }}
                </td>

                <td>
                    {{ $assignment->topic->title ?? 'Không có' }}
                </td>

                <td>
                    {{ $assignment->assigned_date }}
                </td>

                <td>

                    @if($assignment->evaluationScore)

                        <strong style="color:#16a34a;">
                            {{ $assignment->evaluationScore->score }}/10
                        </strong>

                    @else

                        <span style="color:#9ca3af;">
                            Chưa nhập
                        </span>

                    @endif

                </td>

                <td>

                    <div class="actions">

                        {{-- SỬA PHÂN CÔNG --}}
                        <a
                            href="{{ route(
                                'topic-assignments.edit',
                                $assignment
                            ) }}"
                            class="btn-edit"
                        >
                            Sửa
                        </a>

                        {{-- NHẬP / SỬA ĐIỂM --}}
                        <a
                            href="{{ route(
                                'evaluation-scores.create',
                                $assignment
                            ) }}"
                            class="btn-score"
                        >
                            @if($assignment->evaluationScore)
                                Sửa điểm
                            @else
                                Nhập điểm
                            @endif
                        </a>

                        {{-- XÓA --}}
                        <form
                            action="{{ route(
                                'topic-assignments.destroy',
                                $assignment
                            ) }}"
                            method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa phân công này?');"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-delete"
                            >
                                Xóa
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    style="text-align:center;"
                >
                    Chưa có phân công.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
