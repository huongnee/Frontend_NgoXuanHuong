@extends('layouts.layout')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
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

    /* Khoảng cách cho phần nội dung bên dưới */
    .content {
        margin-top: 80px; /* Để tránh bị che khuất bởi navbar */
    }

    /* Định dạng bảng điều khiển */
    .dashboard {
        padding: 20px;
    }

    .text-center {
        text-align: center;
    }

    .mb-5 {
        margin-bottom: 3rem;
    }

    .dashboard-grid {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card a {
        text-decoration: none;
        color: inherit;
    }

    .card-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .btn-logout {
        text-align: center;
    }

    .btn {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn:hover {
        background-color: #5a6268;
    }

    .empty-space {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }
</style>

<!-- Thanh nav gắn liền -->
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

<!-- Nội dung của trang -->
<div class="content">
    <div class="dashboard">
        <h1 class="text-center mb-5">Admin Dashboard</h1>

        <!-- Bảng điều khiển admin -->
        <div class="dashboard-grid">
            <div class="card">
                <!-- Quản lý danh mục -->
                <a href="{{ route('admin.categories.index') }}" class="card mb-3">
                    <i class="fas fa-th-list card-icon"></i>
                    <div class="card-title">Quản lý danh mục</div>
                </a>

                <!-- Quản lý sản phẩm -->
                <a href="{{ route('admin.products.index') }}" class="card mb-3">
                    <i class="fas fa-cogs card-icon"></i>
                    <div class="card-title">Quản lý sản phẩm</div>
                </a>

                <!-- Quản lý đơn hàng -->
                <a href="{{ route('admin.orders.index') }}" class="card mb-3">
                    <i class="fas fa-shopping-cart card-icon"></i>
                    <div class="card-title">Quản lý đơn hàng</div>
                </a>

                <!-- Thống kê -->
                <a href="{{ route('admin.reports.index') }}" class="card mb-3">
                    <i class="fas fa-chart-pie card-icon"></i>
                    <div class="card-title">Thống kê website</div>
                </a>
                <div class="btn-logout mb-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </div>
            </div>

            <!-- Khoảng trắng bên phải -->
            <div class="empty-space">
                <!-- Chèn ảnh hoặc nội dung khác tại đây -->
                <img src="https://png.pngtree.com/thumb_back/fw800/background/20230802/pngtree-laundry-room-with-a-washer-and-dryer-image_12980575.jpg" alt="Dashboard Image" class="img-fluid" />
            </div>
        </div>
    </div>
</div>
@endsection
