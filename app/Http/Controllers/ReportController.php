<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders; 
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;

class ReportController extends Controller
{
    public function index()
    {
        // Tổng số sản phẩm
        $totalProducts = Product::count();
        // Tổng số danh mục
        $totalCategories = Category::count();
        // Tổng số đơn hàng
        $totalOrders = Orders::count();
        // Tổng số khách hàng
        $totalCustomers = DB::table('users')->where('role', 'customer')->count();
        // Đếm số đơn hàng theo trạng thái
        $ordersProcessing = Orders::where('status', 'processing')->count();
        $ordersPaid = Orders::where('status', 'paid')->count();
    
        // Thống kê tổng doanh thu theo từng danh mục chỉ với đơn hàng "Paid"
        $categoryRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid') // Thêm điều kiện để chỉ tính các đơn hàng "Paid"
            ->select('categories.name as category_name', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->groupBy('categories.name')
            ->get();
    
        // Doanh thu theo ngày từ bảng payments chỉ với đơn hàng "Paid"
        $revenueByDate = DB::table('payments')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid') // Thêm điều kiện để chỉ tính các đơn hàng "Paid"
            ->select(DB::raw('DATE(payment_date) as date, SUM(amount) as total_revenue'))
            ->groupBy('date')
            ->get();
    
        // Doanh thu theo tháng từ bảng payments chỉ với đơn hàng "Paid"
        $revenueByMonth = DB::table('payments')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid') // Thêm điều kiện để chỉ tính các đơn hàng "Paid"
            ->select(DB::raw('MONTH(payment_date) as month, SUM(amount) as total_revenue'))
            ->groupBy('month')
            ->get();
    
        // Doanh thu theo năm từ bảng payments chỉ với đơn hàng "Paid"
        $revenueByYear = DB::table('payments')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid') // Thêm điều kiện để chỉ tính các đơn hàng "Paid"
            ->select(DB::raw('YEAR(payment_date) as year, SUM(amount) as total_revenue'))
            ->groupBy('year')
            ->get();
    
        // Doanh thu theo phương thức thanh toán chỉ với đơn hàng "Paid"
        $revenueByPaymentMethod = DB::table('payments')
        ->join('orders', 'payments.order_id', '=', 'orders.id')
        ->where('orders.status', 'paid') // Thêm điều kiện để chỉ tính các đơn hàng "Paid"
        ->select('payments.payment_method', DB::raw('SUM(payments.amount) as total_revenue'))
        ->groupBy('payments.payment_method')
        ->get();
    
        // Trả về view với các dữ liệu đã được lấy từ database
        return view('admin.reports.index', compact(
            'totalProducts', 
            'totalCategories', 
            'totalOrders', 
            'totalCustomers', 
            'ordersProcessing', 
            'ordersPaid', 
            'categoryRevenue', 
            'revenueByDate', 
            'revenueByMonth', 
            'revenueByYear', 
            'revenueByPaymentMethod'
        ));
    }
    
}
