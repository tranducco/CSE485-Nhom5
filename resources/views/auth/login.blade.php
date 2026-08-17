<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h3 class="text-center mb-4 fw-bold text-primary">Đăng Nhập</h3>
                
                @if ($errors->any())
                    <div class="alert alert-danger p-2 mb-3">
                        <small>{{ $errors->first() }}</small>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Đăng nhập</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="text-decoration-none text-secondary"><small>← Quay lại Trang chủ</small></a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>