@extends('layouts.layout')

@section('content')
@if(session('success'))
    <div class="alert-container">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @php
        session()->forget('success');
    @endphp
@endif

{{-- css cho giao diện lưới và thanh điều hướng --}}
<style>
    *{
        margin: 0;
        padding: 0;

    }
    body {
        background-color: #f7f7f7;
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #2c3e50;
        font-weight: bold;
        margin-top: 30px;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .product-item {
        width: calc(30% - 20px); /* Điều chỉnh để cân đối margin */
        background-color: white;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .product-item:hover {
        transform: scale(1.05); /* Hiệu ứng phóng to nhẹ khi hover */
    }

    .product-item img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .product-item h4 {
        font-size: 18px;
        color: #333;
        margin: 10px 0;
    }

    .product-item p {
        color: #777;
    }

    .product-item .price {
        color: #e74c3c;
        font-weight: bold;
        margin: 10px 0;
    }

    .btn {
        border-radius: 20px;
        padding: 10px 20px;
    }

    .navbar {
        margin-bottom: 30px;
        background-color: #007bff;
        padding: 15px;
    }

    .navbar .navbar-nav .nav-link {
        color: white;
        margin-right: 15px;
    }

    .navbar .nav-item .cart-icon {
        font-size: 22px;
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -12px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 5px;
        font-size: 12px;
    }

    /* Tùy chỉnh phân trang */
    .pagination {
        margin-top: 20px;
    }

    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px; /* Điều chỉnh kích thước chữ của phân trang */
    }

    .pagination .page-link svg, 
    .pagination .page-link i { /* Đối với SVG hoặc icon */
        width: 16px; /* Kích thước mũi tên */
        height: 16px; /* Kích thước mũi tên */
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc;
    }
    .h-5{
        width: 40px;
    }
    .flex.justify-between.flex-1 {
    display: none; /* Ẩn phần tử */
}
.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
     /* Ẩn thẻ <p> */
}
.flex items-center justify-between{

}
.cart-icon {
    font-size: 22px; /* Kích thước icon */
    margin-right: px; /* Khoảng cách giữa icon và số lượng */
}

.cart-count {
    position: relative;
    top: -15px; /* Điều chỉnh vị trí số lượng nếu cần */
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 5px;
    font-size: 12px;
}
.text-center{
    margin-top:100px 
}

.alert-container {
    display: flex;
    justify-content: left; /* Căn giữa theo chiều ngang */
    position: relative;
    top: 50px; /* Khoảng cách từ trên xuống */
}
.form-inline {
    display: flex;
    align-items: center;
}

.form-control {
    margin-right: 5px; /* Khoảng cách giữa ô tìm kiếm và nút */
}
div>.text-sm{
    display: none;
}
span.relative a{
    text-decoration: none !important;
    color: #e74c3c;
    border: none !important;

}
span.relative{
    color: #e74c3c;
    border: none !important;
}
nav.flex{
    background-color: white !important;
}
.product-item a {
    text-decoration: none; /* Xóa gạch chân dưới chữ */
    color: inherit; /* Giữ nguyên màu mặc định của chữ */
}

.product-item a:hover {
    color: #333; /* Màu khi hover vào link */
}


</style>

<div class="container">
    <!-- Thanh điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">  <i class="fas fa-home icon"></i> <!-- Biểu tượng ngôi nhà --></a>
                    
                </li>
                <li class="nav-item">
                    <form action="{{ route('product.search') }}" method="GET" class="form-inline">
                        <input type="text" name="id" class="form-control" placeholder="Tìm theo ID" required>
                        <button type="submit" class="btn btn-link text-white">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </li>
                <!-- Thêm mục "My Order" -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.my_orders') }}">My Order</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost:8000/cart">
                        <i class="fa fa-shopping-cart cart-icon"></i>
                        <span class="cart-count">{{ $count ?? 0 }}</span> <!-- Cập nhật giá trị -->
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-white">
                        <i class="fas fa-sign-out-alt icon"></i> <!-- Biểu tượng đăng xuất -->
                    </button>
                </form>
            </li>
            </ul>
        </div>
    </nav>

    <h1 class="text-center mb-4">Sản Phẩm Máy Giặt</h1>

    <!-- Hiển thị thông báo thành công khi thêm vào giỏ hàng -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Lưới sản phẩm -->
<div class="product-grid">
    @if(isset($product)) <!-- Kiểm tra xem có sản phẩm hay không -->
        <div class="product-item">
            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
            <h4>{{ $product->name }}</h4>
            <p>{{ $product->category->name }}</p>
            <p class="price">{{ number_format($product->price, 0, ',', '.') }} VND</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-danger">
                    <i class="fas fa-cart-plus icon"></i> <!-- Biểu tượng thêm vào giỏ hàng -->
                </button>
            </form>
            
        </div>
    @else
    @foreach ($products as $product)
    <div class="product-item" id="product-item-{{ $product->id }}">
        <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none;"> <!-- Thêm link bao bọc ảnh và tên -->
            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
            <h4>{{ $product->name }}</h4>
        </a>
        <p>{{ $product->category->name }}</p>
        <p>Số lượng: {{ $product->quantity }}</p> <!-- Hiển thị số lượng -->
        <div style="display: flex;justify-content: space-between;padding-left: 3rem;padding-right:3rem ">
            <p class="price">{{ number_format($product->price, 0, ',', '.') }} VND</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link text-danger">
                    <i class="fas fa-cart-plus icon"></i>
                </button>
            </form>
        </div>
    </div>
@endforeach

    @endif
</div>

<!-- Phân trang -->
<div class="d-flex justify-content-center">
    {{ $products->links() }} <!-- Luôn hiển thị phân trang -->
</div>

</div>

@endsection
