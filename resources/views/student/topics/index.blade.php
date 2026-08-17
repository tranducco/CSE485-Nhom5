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
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mã: {{ $topic->topic_code ?? $topic->id }}</h5>
                    
                    <!-- HIỂN THỊ SĨ SỐ (LỖ HỔNG 2 ĐÃ ĐƯỢC FIX TRỰC QUAN) -->
                    @php
                        $registeredCount = \App\Models\TopicRegistration::where('topic_id', $topic->id)
                                                                        ->where('status', 'Đã duyệt')
                                                                        ->count();
                        $maxSlot = $topic->max_students ?? 2;
                    @endphp
                    <span class="badge bg-light text-dark">
                        Sĩ số: {{ $registeredCount }} / {{ $maxSlot }}
                    </span>
                </div>

                <div class="card-body d-flex flex-column">
                    <h4 class="card-title text-dark">{{ $topic->title }}</h4>
                    <p class="card-text text-secondary mb-3">
                        {{ $topic->description ?? 'Đề tài tập trung vào việc ứng dụng kiến thức chuyên ngành để giải quyết bài toán thực tế.' }}
                    </p>
                    
                    <!-- Form ẩn đẩy dữ liệu lên -->
                    <form action="{{ route('student.topics.register') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                        
                        @if($hasActiveRegistration)
                            <button class="btn btn-secondary w-100" disabled>Bạn đã đăng ký 1 đề tài</button>
                        @elseif($registeredCount >= $maxSlot)
                            <button class="btn btn-danger w-100" disabled>Đã đủ số lượng</button>
                        @else
                            <button type="submit" class="btn btn-primary w-100">Ghi danh / Đăng ký</button>
                        @endif
                    </form>
                </div>
            </div>
        </article>
        @endforeach
    </section>
</div>
@endsection