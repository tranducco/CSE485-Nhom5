<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cổng Sinh Viên')</title>
    <!-- Nhúng Bootstrap 5 (tương tự như layout admin của cậu) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Thanh Điều Hướng (Navbar) dành riêng cho Sinh viên -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🎓 Cổng Sinh Viên</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Link quay lại trang đăng ký đề tài -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('student.topics.index') }}">Đăng ký Đề tài</a>
                    </li>
                    <!-- Có thể thêm link xem trạng thái đơn ở đây sau này -->
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="{{ url('/') }}">🚪 Thoát về Trang chủ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Khu vực chứa nội dung chính -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>