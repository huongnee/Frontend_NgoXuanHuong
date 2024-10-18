<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giao diện</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/resources/css/style.css">
    <style>
        
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
</head>
<body>
    <!-- Đảm bảo rằng bạn đã liên kết Bootstrap CSS trong layout của mình -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Category List</h2>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a>
            </div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Liên kết Bootstrap JS và các phụ thuộc -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>