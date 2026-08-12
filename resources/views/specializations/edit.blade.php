@extends('layouts.admin')

@section('title', 'Sửa chuyên môn')

@section('content')

<div class="card">

    <h2>Sửa chuyên môn</h2>

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
        action="{{ route(
            'specializations.update',
            $specialization
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div>
            <label>Mã chuyên môn</label>
            <br>

            <input
                type="text"
                name="code"
                value="{{ old(
                    'code',
                    $specialization->code
                ) }}"
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
                value="{{ old(
                    'name',
                    $specialization->name
                ) }}"
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
            Cập nhật
        </button>

    </form>

    <br>

    <a href="{{ route('specializations.index') }}">
        ← Quay lại
    </a>

</div>

@endsection
