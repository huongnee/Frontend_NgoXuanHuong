<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// Route cho đăng ký
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Route cho đăng nhập
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route cho admin (có middleware auth và admin)
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Route quản lý sản phẩm
    Route::middleware(['auth', 'admin'])->group(function () {
        // Hiển thị danh sách sản phẩm
        Route::get('/admin/products', [ProductController::class, 'index1'])->name('admin.products.index');
    
        // Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
        // Hiển thị form để tạo sản phẩm mới
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    
        // Lưu sản phẩm mới vào cơ sở dữ liệu
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    
        // Hiển thị chi tiết thông tin sản phẩm
        Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
    
        // Hiển thị form để chỉnh sửa thông tin sản phẩm
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    
        // Cập nhật thông tin sản phẩm
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::patch('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update'); // Tùy chọn cho PUT/PATCH
    
        // Xóa sản phẩm khỏi cơ sở dữ liệu
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        //oder
        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        // Route::patch('/admin/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        // Route cập nhật trạng thái đơn hàng (có middleware auth và admin)
        Route::patch('/admin/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    });

    // Route quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
        'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route của categories
    ]);
});

// Route cho customer (chỉ cần middleware auth)
Route::middleware(['auth'])->group(function () {
    // Route::get('/admin/products', [ProductController::class, 'index1'])->name('admin.products.index');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Phương thức cho customer
    Route::get('/categories', [Controller::class, 'index1'])->name('categories.index'); // Phương thức cho customer
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store'); // Thêm route lưu đơn hàng
    
    // Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
});
// use App\Http\Controllers\CategoryController;
// Route::resource('categories', CategoryController::class);
use App\Http\Controllers\CartController;

// Route để thêm sản phẩm vào giỏ hàng
Route::middleware(['auth'])->post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// Route để hiển thị giỏ hàng
Route::middleware(['auth'])->get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route để xóa sản phẩm khỏi giỏ hàng
Route::middleware(['auth'])->delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Route để cập nhật số lượng sản phẩm trong giỏ hàng
Route::middleware(['auth'])->patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/products/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
//kiểm thử
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
//


// Route::middleware(['auth'])->group(function () {
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
// });

Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my_orders');

// Báo cáo thống kế
use App\Http\Controllers\ReportController;

Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');

// xóa sửa 
// Route để xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Route để cập nhật số lượng sản phẩm trong giỏ hàng
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
//chi tiết

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
