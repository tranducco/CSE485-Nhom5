<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Đồ án</title>
    <!-- Nhúng Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary">Hệ Thống Quản Lý Đồ Án</h1>
            <p class="text-muted">Vui lòng chọn phân hệ truy cập</p>
        </div>

        <div class="row justify-content-center gap-4">
            <!-- Cổng Sinh Viên -->
            <div class="col-md-5">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="display-3 mb-3">🎓</div>
                        <h3 class="card-title fw-bold">Dành cho Sinh viên</h3>
                        <p class="card-text text-secondary mb-4">
                            Khu vực dành cho sinh viên xem danh sách đề tài mở, đăng ký nguyện vọng và theo dõi tiến độ.
                        </p>
                        <!-- Nút dẫn thẳng vào Route của sinh viên -->
                        <a href="{{ url('/student/topics') }}" class="btn btn-primary btn-lg w-100 rounded-pill">
                            Vào cổng Sinh viên
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cổng Admin / Giảng viên -->
            <div class="col-md-5">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="display-3 mb-3">👨‍🏫</div>
                        <h3 class="card-title fw-bold">Dành cho Quản trị</h3>
                        <p class="card-text text-secondary mb-4">
                            Khu vực quản lý đề tài, xét duyệt đơn đăng ký, phân công giảng viên và chấm điểm đồ án.
                        </p>
                        <!-- Nút dẫn thẳng vào Route quản lý đơn của cậu -->
                        <a href="{{ url('/topic-registrations') }}" class="btn btn-dark btn-lg w-100 rounded-pill">
                            Vào cổng Quản trị
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>