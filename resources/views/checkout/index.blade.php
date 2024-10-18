@extends('layouts.layout')

@section('content')
<h1>Thông tin thanh toán</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(count($cart) > 0)
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
            @foreach($cart as $id => $details)
                @php $total += $details['price'] * $details['quantity']; @endphp
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>{{ $details['quantity'] }}</td>
                    <td>{{ number_format($details['price'], 2) }} VND</td>
                    <td>{{ number_format($details['price'] * $details['quantity'], 2) }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right">
        <h3>Tổng tiền: {{ number_format($total, 2) }} VND</h3>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
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
        <br>
        <button type="submit" class="btn btn-success">Thanh toán</button>
    </form>
@else
    <p>Giỏ hàng của bạn trống.</p>
@endif
<br>
<a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endsection
