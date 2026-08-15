<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Quản lý Đồ án')
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background: #f5f6fa;
            color: #1f2937;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 250px;
            background: #1f2937;
            color: white;
            padding: 20px;
            flex-shrink: 0;
        }

        .sidebar h2 {
            margin-bottom: 25px;
            font-size: 22px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 12px;
            margin-bottom: 5px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .sidebar a.active {
            background: #2563eb;
        }

        .sidebar a:hover {
            background: #374151;
        }

        .menu-title {
            color: #9ca3af;
            font-size: 12px;
            font-weight: bold;
            margin-top: 22px;
            margin-bottom: 8px;
            padding-left: 10px;
            letter-spacing: 0.5px;
        }

        /* ================= CONTENT ================= */

        .content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 20px 25px;
            border-bottom: 1px solid #ddd;
            font-size: 22px;
            font-weight: bold;
        }

        .main {
            padding: 25px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        /* ================= TABLE ================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        table th,
        table td {
            border: 1px solid #e5e7eb;
            padding: 11px 10px;
            text-align: left;
        }

        table th {
            background: #f3f4f6;
            font-weight: 600;
            color: #111827;
        }

        table tr:hover td {
            background: #f9fafb;
        }

        /* ================= BUTTON ================= */

        .btn {
            display: inline-block;
            padding: 9px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .btn-add {
            background: #2563eb;
        }

        .btn-edit {
            display: inline-block;
            background: #f59e0b;
            color: white;
            padding: 7px 11px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            padding: 7px 11px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        .btn-score {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 7px 11px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-score:hover {
            background: #15803d;
        }

        .btn-view {
            display: inline-block;
            background: #6366f1;
            color: white;
            padding: 7px 11px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        /* ================= ACTION ================= */

        .actions {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ================= MESSAGE ================= */

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        /* ================= FORM ================= */

        input,
        select,
        textarea {
            padding: 9px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            width: 100%;
            max-width: 500px;
            margin-top: 5px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .back-link {
            color: #2563eb;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>

<div class="wrapper">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>QL Đồ Án</h2>

        <a href="#">
            🏠 Dashboard
        </a>

        <!-- SINH VIÊN -->

        <div class="menu-title">
            SINH VIÊN
        </div>

        <a
            class="{{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
            href="{{ route('admin.students.index') }}"
        >
            👨‍🎓 Quản lý Sinh viên
        </a>
        <a href="{{ route('admin.topic_registrations.index') }}" class="nav-link">
    📌 Đơn đăng ký Đề tài
        </a>
        <!-- MODULE CỦA BẠN -->

        <div class="menu-title">
            GIẢNG VIÊN & PHÂN CÔNG
        </div>

        <a
            class="{{ request()->routeIs('lecturers.*') ? 'active' : '' }}"
            href="{{ route('lecturers.index') }}"
        >
            👨‍🏫 Giảng viên
        </a>

        <a
            class="{{ request()->routeIs('specializations.*') ? 'active' : '' }}"
            href="{{ route('specializations.index') }}"
        >
            📚 Chuyên môn
        </a>

        <a
            class="{{ request()->routeIs('topic-assignments.*') ? 'active' : '' }}"
            href="{{ route('topic-assignments.index') }}"
        >
            📋 Phân công hướng dẫn
        </a>

        <a
            class="{{ request()->routeIs('evaluation-scores.*') ? 'active' : '' }}"
            href="{{ route('evaluation-scores.index') }}"
        >
            ⭐ Điểm đánh giá
        </a>

        <!-- ĐỀ TÀI -->

        <div class="menu-title">
            ĐỀ TÀI & TIẾN ĐỘ
        </div>

        <a
            class="{{ request()->routeIs('topics.*') ? 'active' : '' }}"
            href="{{ route('topics.index') }}"
        >
            📌 Quản lý Đề tài
        </a>

    </div>


    <!-- CONTENT -->

    <div class="content">

        <div class="topbar">
            @yield('title', 'Quản lý Đồ án')
        </div>

        <div class="main">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>
