@extends('layouts.layout')

@section('content')

{{-- css cho đẹp --}}
<style>
    body {
        background-color: #f7f7f7;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    td {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        border-radius: 20px;
    }

    h1 {
        color: #2c3e50;
        font-weight: bold;
    }

    img {
        max-width: 100px;
        height: auto;
        border-radius: 10px;
    }

    .logout-btn {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }
    
    /* Thanh nav gắn liền */
    .navbar {
    background-color: #343a40;
    padding: 20px 20px;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    justify-content: space-around;
    align-items: center;
    
}


    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-size: 1.2rem;
    }

    .navbar a:hover {
        color: #ddd;
    }

    .navbar .nav-icons i {
        font-size: 1.5rem;
        margin: 0 10px;
        cursor: pointer;
    }

    .navbar .nav-icons i:hover {
        color: #ddd;
    }
    
</style>
<div class="navbar">
    
    <a href="{{ route('admin.categories.index') }}" class="nav-link">
        <i class="fas fa-th-list"></i> Quản lý danh mục
    </a>
    <a href="{{ route('admin.products.index') }}" class="nav-link">
        <i class="fas fa-cogs"></i> Quản lý sản phẩm
    </a>
    <a href="{{ route('admin.orders.index') }}" class="nav-link">
        <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
    </a>
    <a href="{{ route('admin.reports.index') }}" class="nav-link">
        <i class="fas fa-chart-pie"></i> Thống kê
    </a>

<div class="nav-icons">
    <!-- Đăng xuất -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class="fas fa-sign-out-alt" style="color: white; font-size: 1.5rem;"></i>
        </button>
    </form>
</div>
</div>
<div class="container mt-5" style="margin-top:8rem !important; ">
    <h1 class="text-center mb-4">Sản Phẩm Máy Giặt</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm Sản phẩm</a>
    </div>

    <!-- Nút đăng xuất -->
    <div class="logout-btn">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">Đăng xuất</button>
        </form>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                 <!-- Thêm cột Hình ảnh -->
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Số lượng</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            {{-- lặp qua danh sách các sản phẩm và hiển thị chúng theo từng hàng --}}
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
