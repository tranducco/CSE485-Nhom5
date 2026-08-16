@extends('layouts.admin')

@section('title', 'Tiêu chí đánh giá')

@section('content')

<div class="card">

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Danh sách tiêu chí đánh giá</h2>

        <a
            href="{{ route('evaluation-criterias.create') }}"
            class="btn"
        >
            + Thêm tiêu chí
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($criteria->count())

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Đề tài</th>
                    <th>Tên tiêu chí</th>
                    <th>Mô tả</th>
                    <th>Điểm tối đa</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @foreach($criteria as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration + ($criteria->currentPage() - 1) * $criteria->perPage() }}
                        </td>

                        <td>
                            {{ $item->topic->title ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $item->name }}
                        </td>

                        <td>
                            {{ $item->description ?? 'Không có mô tả' }}
                        </td>

                        <td>
                            {{ $item->max_score }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('evaluation-criterias.show', $item) }}"
                                    class="btn-view"
                                >
                                    Xem
                                </a>

                                <a
                                    href="{{ route('evaluation-criterias.edit', $item) }}"
                                    class="btn-edit"
                                >
                                    Sửa
                                </a>

                                <form
                                    action="{{ route('evaluation-criterias.destroy', $item) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa tiêu chí này không?');"
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
            {{ $criteria->links() }}
        </div>

    @else

        <p style="margin-top: 20px;">
            Chưa có tiêu chí đánh giá nào.
        </p>

    @endif

</div>

@endsection