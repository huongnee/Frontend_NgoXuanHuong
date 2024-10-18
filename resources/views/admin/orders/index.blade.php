@extends('layouts.layout')

@section('content')
<style>
    
    /* Thanh nav gắn liền */
    .navbar {
    background-color: #343a40;
    /* padding: 20px 20px; */
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
<div class="container mt-5"  style="margin-top:8rem !important; ">
    <h1>Quản lý đơn hàng</h1>

    @if(session('success'))
        {{-- Thông báo thành công hay không --}}
    @endif
    
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
    <table class="table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->customer_name }}<br>{{ $order->email }}<br>{{ $order->address }}<br>{{ $order->phone }}</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                    <td>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" id="status-form-{{ $order->id }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-control" onchange="confirmChangeStatus(event, {{ $order->id }})">
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm toggle-details" data-order-id="{{ $order->id }}">
                            Chi tiết <i class="fas fa-chevron-down"></i>
                        </button>
                    </td>
                </tr>
                <tr id="order-details-{{ $order->id }}" style="display: none;">
                    <td colspan="6">
                        <h5>Chi tiết đơn hàng:</h5>
                        <ul>
                            @foreach ($order->orderItems as $item)
                                <li>
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="50" height="50">
                                    {{ $item->product->name }} - Số lượng: {{ $item->quantity }} - Giá: {{ number_format($item->price, 0, ',', '.') }} VND
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.toggle-details').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.dataset.orderId;
            const detailsRow = document.getElementById(`order-details-${orderId}`);
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'table-row';
                this.innerHTML = 'Ẩn chi tiết <i class="fas fa-chevron-up"></i>';
            } else {
                detailsRow.style.display = 'none';
                this.innerHTML = 'Chi tiết <i class="fas fa-chevron-down"></i>';
            }
        });
    });

    function confirmChangeStatus(event, orderId) {
        const form = document.getElementById(`status-form-${orderId}`);
        const selectedStatus = form.querySelector('select[name="status"]').value;

        if (confirm(`Bạn chắc chắn muốn thay đổi trạng thái đơn hàng này thành "${selectedStatus}"?`)) {
            form.submit();
        } else {
            // Ngừng gửi form nếu người dùng không đồng ý
            event.preventDefault();
        }
    }
</script>
@endsection
