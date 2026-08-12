@extends('layouts.admin')

@section('title', 'Thêm chuyên môn')

@section('content')

<div class="card">

    <h2>Thêm chuyên môn</h2>

    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('specializations.store') }}"
        method="POST"
    >

        @csrf

        <div>
            <label>Mã chuyên môn</label>
            <br>

            <input
                type="text"
                name="code"
                value="{{ old('code') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Tên chuyên môn</label>
            <br>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <br>

        <button type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    padding:10px 20px;
                    border:none;
                    border-radius:6px;
                ">
            Lưu
        </button>

    </form>

    <br>

    <a href="{{ route('specializations.index') }}">
        ← Quay lại
    </a>

</div>

@endsection
