@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Đơn Hàng Của Bạn</h1>

    @if ($orders->isEmpty())
        <div class="alert alert-info text-center">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        @foreach ($orders as $order)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Mã đơn hàng:</strong> {{ $order->id }} <br>
                        <strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                    </div>
                    <button class="btn btn-light btn-sm toggle-details" data-order-id="{{ $order->id }}">
                        Chi tiết <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body">
                    <strong>Họ và tên:</strong> {{ $order->customer_name }} <br>
                    <strong>Email:</strong> {{ $order->customer_email }} <br>
                    <strong>Địa chỉ:</strong> {{ $order->customer_address }} <br>
                    <strong>Số điện thoại:</strong> {{ $order->customer_phone }} <br>
                    <strong>Tổng tiền:</strong> <span class="text-danger">{{ number_format($order->total, 0, ',', '.') }} VND</span> <br>
                    <strong>Trạng thái:</strong> {{ $order->status }}
                    {{-- @if($order->status == 'Đã xử lý')
                        <span class="badge badge-success">{{ $order->status }}</span>
                    @else
                        <span class="badge badge-warning">{{ $order->status }}</span>
                    @endif --}}
                </div>
                
                <div class="card-body order-details" id="order-details-{{ $order->id }}" style="display: none;">
                    <h5> Chi tiết đơn hàng:</h5>
                    <ul class="list-group">
                        @foreach ($order->orderItems as $item)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        {{ $item->product->name }}
                                    </div>
                                    <div class="col-md-2">
                                       <div class="col-md-2">
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;">
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>Số lượng:</strong> {{ $item->quantity }}
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong>Gía:</strong> {{ number_format($item->price, 0, ',', '.') }} VND
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        @endforeach
    @endif
    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Quay về trang chủ</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-details');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const details = document.getElementById(`order-details-${orderId}`);
                
                if (details.style.display === 'none') {
                    details.style.display = 'block';
                    this.innerHTML = 'Ẩn chi tiết <i class="fas fa-chevron-up"></i>';
                } else {
                    details.style.display = 'none';
                    this.innerHTML = 'Chi tiết <i class="fas fa-chevron-down"></i>';
                }
            });
        });
    });
</script>
@endsection
