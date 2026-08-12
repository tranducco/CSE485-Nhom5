@extends('layouts.admin')

@section('title', 'Quản lý Chuyên môn')

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
        href="{{ route('specializations.create') }}"
        class="btn btn-add"
    >
        + Thêm chuyên môn
    </a>

    <h2>Danh sách chuyên môn</h2>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Mã</th>
                <th>Tên chuyên môn</th>
                <th>Số giảng viên</th>
                <th>Số sinh viên</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        @forelse($specializations as $specialization)

            <tr>

                <td>{{ $specialization->id }}</td>

                <td>{{ $specialization->code }}</td>

                <td>{{ $specialization->name }}</td>

                <td>{{ $specialization->lecturers_count }}</td>

                <td>{{ $specialization->students_count }}</td>

                <td>

                    <div class="actions">

                        <a
                            href="{{ route('specializations.edit', $specialization) }}"
                            class="btn-edit"
                        >
                            Sửa
                        </a>

                        <form
                            action="{{ route('specializations.destroy', $specialization) }}"
                            method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa chuyên môn này?');"
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
                <td colspan="6" style="text-align:center;">
                    Chưa có chuyên môn.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
