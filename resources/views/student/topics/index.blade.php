@extends('layouts.student') 

@section('title', 'Đăng ký Đề tài')

@section('content')
<div class="container-fluid py-4">
    <header class="mb-4">
        <h2>Danh sách Đề tài Mở Đăng ký</h2>
        <p class="text-muted">Lựa chọn đề tài phù hợp với chuyên ngành của bạn để đăng ký.</p>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Khối Grid chứa các thẻ đề tài -->
    <section class="row">
        @foreach($topics as $topic)
        <article class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mã: {{ $topic->topic_code ?? $topic->id }}</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title text-dark">{{ $topic->title }}</h4>
                    <p class="card-text text-secondary mb-4">
                        {{ $topic->description ?? 'Đề tài tập trung vào việc ứng dụng kiến thức chuyên ngành để giải quyết bài toán thực tế.' }}
                    </p>
                    
                    <!-- Form ẩn đẩy dữ liệu lên -->
                    <form action="{{ route('student.topics.register') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        <button type="submit" class="btn btn-outline-primary w-100" onclick="return confirm('Xác nhận nộp đơn đăng ký đề tài này?');">
                            Ghi danh / Đăng ký
                        </button>
                    </form>
                </div>
            </div>
        </article>
        @endforeach
    </section>
</div>
@endsection