<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản lý Đồ án')</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Segoe UI;
        }

        body{
            background:#f5f5f5;
        }

        .wrapper{
            display:flex;
            min-height:100vh;
        }

        .sidebar{
            width:240px;
            background:#1f2937;
            color:white;
            padding:20px;
        }

        .sidebar h2{
            margin-bottom:25px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:10px;
            margin-bottom:5px;
            border-radius:6px;
        }

        .sidebar a.active{
            background:#2563eb;
        }

        .sidebar a:hover{
            background:#374151;
        }

        .content{
            flex:1;
        }

        .topbar{
            background:white;
            padding:20px;
            border-bottom:1px solid #ddd;
            font-size:22px;
            font-weight:bold;
        }

        .main{
            padding:25px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:8px;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table th,
        table td{
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
        }

        table th{
            background:#f3f4f6;
        }

        .btn{
            display:inline-block;
            padding:8px 15px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:5px;
            margin-bottom:15px;
        }

    </style>

</head>


<body>

<div class="wrapper">


    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>QL Đồ Án</h2>


        <a href="#">
            Dashboard
        </a>


        <!-- Chưa có route sinh viên nên để tạm -->
        <a href="#">
            Quản lý Sinh viên
        </a>


        <!-- Module của bạn -->
        <a class="{{ request()->is('lecturers*') ? 'active' : '' }}"
           href="{{ url('/lecturers') }}">
            Quản lý Giảng viên
        </a>


        <a href="#">
            Quản lý Đề tài
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