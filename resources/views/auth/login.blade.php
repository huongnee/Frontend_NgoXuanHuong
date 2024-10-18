@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Đăng nhập</h1>

    {{-- Hiển thị thông báo lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Nhớ tôi</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
</div>
@endsection
