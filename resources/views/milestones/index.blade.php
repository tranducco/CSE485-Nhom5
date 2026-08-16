@extends('layouts.admin')

@section('title', 'Quản lý mốc thực hiện')

@section('content')

<div class="card">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('milestones.create') }}" class="btn">
        + Thêm mốc thực hiện
    </a>

    <table>

        <thead>
        <tr>
            <th>ID</th>
            <th>Đề tài</th>
            <th>Tên mốc</th>
            <th>Mô tả</th>
            <th>Ngày bắt đầu</th>
            <th>Hạn hoàn thành</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>

        @forelse($milestones as $milestone)

            <tr>
                <td>{{ $milestone->id }}</td>

                <td>
                    {{ $milestone->topic->title ?? 'Không xác định' }}
                </td>

                <td>
                    {{ $milestone->title }}
                </td>

                <td>
                    {{ $milestone->description ?? '—' }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($milestone->start_date)->format('d/m/Y') }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}
                </td>

                <td>
                    {{ $milestone->status }}
                </td>

                <td>
                    <div class="actions">

                        <a
                            href="{{ route('milestones.show', $milestone) }}"
                            class="btn-view"
                        >
                            Xem
                        </a>

                        <a
                            href="{{ route('milestones.edit', $milestone) }}"
                            class="btn-edit"
                        >
                            Sửa
                        </a>

                        <form
                            action="{{ route('milestones.destroy', $milestone) }}"
                            method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa mốc này không?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-delete">
                                Xóa
                            </button>
                        </form>

                    </div>
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="8" style="text-align:center;">
                    Chưa có mốc thực hiện.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <br>

    {{ $milestones->links() }}

</div>

@endsection