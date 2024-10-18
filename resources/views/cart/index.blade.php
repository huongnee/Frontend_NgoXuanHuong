

@extends('layouts.layout')

@section('content')

<style>
    /* General table and page layout */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        text-align: left;
        padding: 10px;
        background-color: #f8f8f8;
        font-weight: 600;
    }

    .table tbody tr td {
        padding: 10px;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid #e0e0e0;
    }

    .text-right {
        margin-top: 20px;
    }

    /* Styling the quantity input group */
    .input-group {
        display: flex;
        align-items: center;
    }

    input.quantity-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    input.quantity-input:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Update and delete buttons */
    button.btn {
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-secondary {
        background-color: #ddd;
        color: #333;
    }

    .btn-danger {
        background-color: #ff4d4f;
        color: #fff;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    /* Custom layout for cart summary */
    .cart-summary-container{
        margin-top:3rem; 
    }
    .cart-summary {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        max-width: 350px;
        margin-left: auto;
    }

    .cart-summary h3 {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .cart-summary p {
        margin-bottom: 0;
        font-size: 1.2rem;
    }

    .cart-summary .total-price {
        font-size: 1.25rem;
        font-weight: 600;
        color: #ff4d4f;
    }

    /* Adjust layout to mimic the design */
    .cart-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .cart-products {
        width: 70%;
    }

    .cart-summary-container {
        width: 30%;
    }

    /* Buttons for actions */
    .btn-place-order {
        background-color: #333;
        color: #fff;
        width: 28%;
        padding: 15px;
        text-align: center;
        font-size: 16px;
        border-radius: 8px;
        text-transform: uppercase;
        border: none;
        margin-top: 20px;
    }

    .btn-continue-shopping {
        background-color: #f8f8f8;
        color: #333;
        text-transform: uppercase;
        border: none;
        /* padding: 10px 20px; */
        border-radius: 8px;
        margin-top: 20px;
    }

    .cart-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
</style>

<div class="cart-wrapper">
    <div class="cart-products">
        <h1>Giỏ hàng của bạn</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @php
                session()->forget('success');
            @endphp
        @endif

        @if($cart && $cart->items && $cart->items->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
                <th>Danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart->items as $item)
                @php
                    $itemTotal = $item->product->price * $item->quantity;
                    $total += $itemTotal;
                @endphp
                <tr>
                    <!-- Hiển thị tên sản phẩm -->
                    <td>{{ $item->product->name }}</td>
                    
                    <!-- Form cập nhật số lượng -->
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <div class="input-group">
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control text-center quantity-input" style="width:60px;">
                                <button type="submit" class="btn btn-sm btn-secondary ml-2">Cập nhật</button>
                            </div>
                        </form>
                    </td>
                    
                    
                    <!-- Hiển thị giá sản phẩm -->
                    <td>{{ number_format($item->product->price, 0, ',', '.') }} VND</td>
                    
                    <!-- Hiển thị thành tiền (giá * số lượng) -->
                    <td>{{ number_format($itemTotal, 0, ',', '.') }} VND</td>
                    
                    <!-- Hiển thị danh mục sản phẩm -->
                    <td>{{ $item->product->category->name }}</td>
                    
                    <!-- Form xóa sản phẩm -->
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <!-- Hiển thị tổng tiền -->
            <tr>
                <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                <td colspan="2">{{ number_format($total, 0, ',', '.') }} VND</td>
            </tr>
        </tbody>
    </table>
@else
    <p>Giỏ hàng của bạn trống.</p>
@endif

    </div>

    <div class="cart-summary-container">
        <div class="cart-summary">
            <h3>Tổng tiền giỏ hàng</h3>
            @if($cart && $cart->items->count() > 0)
                <p>Số lượng sản phẩm: {{ $cart->items->count() }}</p>
                <p>Tổng tiền hàng: {{ number_format($total, 2) }} VND</p>
            @else
                <p>Số lượng sản phẩm: 0</p>
            @endif
            <p class="total-price">Thành tiền: {{ number_format($total, 2) }} VND</p>
        </div>
    </div>
</div>

<div class="cart-actions">
    <a href="{{ route('products.index') }}" class="btn-continue-shopping">Tiếp tục mua sắm</a>
    <a href="{{ route('orders.index') }}" class="btn-place-order">Đặt hàng</a>
</div>

@endsection
