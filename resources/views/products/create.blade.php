{{-- Kế thừa layout chính từ file 'layouts/layout.blade.php' --}}
@extends('layouts.layout') 
{{-- Bắt đầu phần nội dung chính của trang --}}
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Thêm Sản phẩm</h1>
    
    <!-- Thêm enctype="multipart/form-data" để xử lý upload ảnh -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        @csrf
        
        <div class="form-group mb-3">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="price">Giá:</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" required>
        </div>
        
        <div class="form-group mb-4">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Trường upload ảnh -->
        <div class="form-group mb-4">
            <label for="image">Ảnh sản phẩm:</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </div>
    </form>
</div>
@endsection
