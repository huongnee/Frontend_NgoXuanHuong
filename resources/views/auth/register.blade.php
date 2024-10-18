@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Đăng ký</h1>

    {{-- Hiển thị thông báo thành công --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password_confirmation">Xác nhận mật khẩu:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>
        <!-- Trường ẩn role -->
        <input type="hidden" name="role" value="customer">
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>
</div>
@endsection
