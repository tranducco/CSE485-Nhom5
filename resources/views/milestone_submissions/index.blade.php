@extends('layouts.admin')

@section('title', 'Quản lý bài nộp milestone')

@section('content')

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Danh sách bài nộp milestone</h2>

        <a href="{{ route('milestone-submissions.create') }}" class="btn">
            + Thêm bài nộp
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($submissions->count())

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sinh viên</th>
                    <th>Đề tài</th>
                    <th>Milestone</th>
                    <th>Ngày nộp</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach($submissions as $submission)

                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $submission->student->student_code ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $submission->milestone->topic->title ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $submission->milestone->title ?? 'N/A' }}
                        </td>

                        <td>
                            @if($submission->submitted_at)
                                {{ $submission->submitted_at->format('d/m/Y H:i') }}
                            @else
                                Chưa nộp
                            @endif
                        </td>

                        <td>
                            {{ $submission->status }}
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('milestone-submissions.show', $submission) }}"
                                    class="btn-view"
                                >
                                    Xem
                                </a>

                                <a
                                    href="{{ route('milestone-submissions.edit', $submission) }}"
                                    class="btn-edit"
                                >
                                    Sửa
                                </a>

                                <form
                                    action="{{ route('milestone-submissions.destroy', $submission) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa bài nộp này?');"
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

                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $submissions->links() }}
        </div>

    @else

        <p style="margin-top: 20px;">
            Chưa có bài nộp milestone nào.
        </p>

    @endif

</div>

@endsection