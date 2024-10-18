@extends('layouts.layout')

@section('content')
<h1>Thông tin thanh toán</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(!empty($cart) && $cart->items->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart->items as $item)
                @php 
                    $totalPrice = $item->product->price * $item->quantity; // Lấy giá từ bảng sản phẩm
                    $total += $totalPrice;
                @endphp
                <tr>
                    <td>{{ $item->product->name }}</td> <!-- Lấy tên sản phẩm từ bảng products -->
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->product->price, 0, ',', '.') }} VND</td> <!-- Giá sản phẩm -->
                    <td>{{ number_format($totalPrice, 0, ',', '.') }} VND</td> <!-- Thành tiền -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <h3>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VND</h3>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="tel" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Phương thức thanh toán</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                <option value="online">Thanh toán online</option>
            </select>
        </div>

        <br>
        <button type="submit" class="btn btn-success">Thanh toán</button>
    </form>

@else
    <p>Giỏ hàng của bạn trống.</p>
@endif

<br>
<a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endsection
