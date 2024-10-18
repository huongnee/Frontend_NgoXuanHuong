{{-- Kế thừa layout --}}
@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Chỉnh sửa Sản phẩm</h1>
    
    <!-- Thêm enctype="multipart/form-data" để xử lý upload ảnh -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="price">Giá:</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        
        <div class="form-group mb-4">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Hiển thị ảnh hiện tại -->
        @if($product->image)
            <div class="form-group mb-4">
                <label>Ảnh hiện tại:</label>
                <div>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" style="max-width: 100px;">
                </div>
            </div>
        @endif

        <!-- upload ảnh -->
        <div class="form-group mb-4">
            <label for="image">Thay đổi ảnh sản phẩm (nếu muốn):</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>
@endsection
