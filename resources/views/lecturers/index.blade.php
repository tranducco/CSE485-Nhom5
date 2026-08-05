<!DOCTYPE html>
<html>
<head>
    <title>Danh sách giảng viên</title>
</head>

<body>

<h2>Danh sách giảng viên</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Mã GV</th>
    <th>Họ tên</th>
    <th>Email</th>
    <th>Số điện thoại</th>
</tr>

@foreach($lecturers as $lecturer)

<tr>
    <td>{{ $lecturer->id }}</td>
    <td>{{ $lecturer->code }}</td>
    <td>{{ $lecturer->name }}</td>
    <td>{{ $lecturer->email }}</td>
    <td>{{ $lecturer->phone }}</td>
</tr>

@endforeach

</table>

</body>
</html>