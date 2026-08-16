@extends('layouts.admin')

@section('title', 'Quản lý Đề tài')

@section('content')

<div class="card">

    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:10px;margin-bottom:15px;border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:10px;margin-bottom:15px;border-radius:5px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:10px;margin-bottom:15px;border-radius:5px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('topics.create') }}" class="btn">
        + Thêm đề tài
    </a>

    <table>

        <thead>
        <tr>
            <th>ID</th>
            <th>Mã</th>
            <th>Tên đề tài</th>
            <th>Mô tả</th>
            <th>SV đăng ký</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        </thead>

        <tbody>

        @forelse($topics as $topic)

            <tr>
                <td>{{ $topic->id }}</td>

                <td>
                    <strong>{{ $topic->code }}</strong>
                </td>

                <td>{{ $topic->title }}</td>

                <td>
                    {{ $topic->description
                        ? \Illuminate\Support\Str::limit($topic->description, 80)
                        : '—' }}
                </td>

                <td>
                    {{ $topic->topic_registrations_count }}
                    /
                    {{ $topic->max_students }}
                </td>

                <td>
                    @if($topic->status === 'Open')
                        <span style="color:#059669;font-weight:bold;">
                            Đang mở
                        </span>
                    @else
                        <span style="color:#dc2626;font-weight:bold;">
                            Đã đóng
                        </span>
                    @endif
                </td>

                <td>

                    <a
                        href="{{ route('topics.show', $topic) }}"
                        class="btn"
                    >
                        Xem
                    </a>

                    <a
                        href="{{ route('topics.edit', $topic) }}"
                        class="btn"
                        style="background:#d97706;"
                    >
                        Sửa
                    </a>

                    <form
                        action="{{ route('topics.destroy', $topic) }}"
                        method="POST"
                        style="display:inline;"
                        onsubmit="return confirm('Bạn có chắc muốn xóa đề tài này?');">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn"
                            style="background:#dc2626;border:none;cursor:pointer;"
                        >
                            Xóa
                        </button>
                    </form>

                </td>
            </tr>

        @empty

            <tr>
                <td colspan="7" style="text-align:center;">
                    Chưa có dữ liệu.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <br>

    {{ $topics->links() }}

</div>

@endsection