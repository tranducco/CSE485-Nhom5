@extends('layouts.admin')

@section('title','Thêm đề tài')

@section('content')

<div class="card">

<form action="{{ url('/topics') }}" method="POST">

    @csrf

    <p>
        <label>Mã đề tài</label><br>
        <input type="text" name="code" style="width:100%">
    </p>

    <p>
        <label>Tên đề tài</label><br>
        <input type="text" name="title" style="width:100%">
    </p>

    <p>
        <label>Mô tả</label><br>
        <textarea name="description" style="width:100%"></textarea>
    </p>

    <p>
        <label>Số sinh viên tối đa</label><br>
        <input type="number" name="max_students" value="2">
    </p>

    <p>
        <label>Trạng thái</label><br>

        <select name="status">

            <option value="Open">Open</option>
            <option value="Closed">Closed</option>

        </select>

    </p>

    <button class="btn">
        Lưu
    </button>

</form>

</div>

@endsection