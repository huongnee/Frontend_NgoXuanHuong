<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Orders;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
    public function dashboard()
    {
        // Lấy dữ liệu thống kê cho bảng điều khiển
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Orders::count();
        $ordersProcessing = Orders::where('status', 'processing')->count();
        $ordersPaid = Orders::where('status', 'paid')->count();

        // Trả về view dashboard
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalOrders', 'ordersProcessing', 'ordersPaid'));
    }
}
