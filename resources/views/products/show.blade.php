@extends('layouts.layout')

@section('content')
<style>
    .btn-continue-shopping {
        background-color: #f8f8f8;
        color: #333;
        text-transform: uppercase;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    .btn-continue-shopping:hover {
        background-color: #ddd;
    }

    .product-detail {
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
        background-color: #fff;
        padding: 20px;
        margin-top: 30px;
    }

    .product-image {
        max-height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #e74c3c;
    }

    .product-title {
        font-size: 2rem;
        font-weight: 600;
    }

    .product-category {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 15px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 product-detail">
            <div class="row">
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid product-image">
                </div>
                <div class="col-md-7">
                    <h2 class="product-title">{{ $product->name }}</h2>
                    <p class="product-category">{{ $product->category->name }}</p>
                    <p>{{ $product->description }}</p> <!-- Thêm mô tả sản phẩm -->
                    <p>Số lượng: {{ $product->quantity }}</p> <!-- Hiển thị số lượng -->
                    <p class="price">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                    
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex justify-content-between">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg">Thêm vào giỏ hàng</button>
                        <a href="{{ route('products.index') }}" class="btn-continue-shopping">Tiếp tục mua sắm</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
