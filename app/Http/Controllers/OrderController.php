<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;


class OrderController extends Controller
{
    // Hiển thị đơn hàng
    public function index()
    {
        // Lấy giỏ hàng của người dùng hiện tại
        $cart = Cart::with('items')->where('user_id', auth()->id())->first();

        // Kiểm tra nếu giỏ hàng không tồn tại
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Kiểm tra nếu giỏ hàng không có sản phẩm
        if (count($cart->items) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
        }

        // Nếu có giỏ hàng và sản phẩm
        return view('orders.index', compact('cart'));
    }

    // Hiển thị giỏ hàng
    public function showCart()
    {
        // Lấy giỏ hàng của người dùng hiện tại
        $cart = Cart::with(['items.product'])->where('user_id', auth()->id())->where('status', 'pending')->first();

        // Kiểm tra nếu giỏ hàng không tồn tại
        if ($cart) {
            return view('orders.index', ['cart' => $cart]);
        } else {
            return view('orders.index', ['cart' => null]);
        }
    }

    public function store(Request $request)
{
    // Lấy giỏ hàng của người dùng hiện tại
    $cart = Cart::with(['items.product'])->where('user_id', auth()->id())->where('status', 'pending')->first();

    if (!$cart || $cart->items->count() === 0) {
        return redirect()->back()->with('error', 'Giỏ hàng trống');
    }

    // Kiểm tra nếu có sản phẩm không đủ số lượng
    foreach ($cart->items as $item) {
        if ($item->product->quantity < $item->quantity) {
            return redirect()->back()->with('error', 'Sản phẩm "' . $item->product->name . '" không đủ số lượng. Còn lại: ' . $item->product->quantity);
        }
    }

    // Tính tổng tiền của đơn hàng
    $total = 0;
    foreach ($cart->items as $item) {
        $total += $item->product->price * $item->quantity;
    }

    // Tạo đơn hàng mới
    $order = Orders::create([
        'user_id' => Auth::id(),
        'total' => $total,
        'status' => 'processing',
        'payment_method' => $request->payment_method,
        'customer_name' => $request->name,
        'customer_email' => $request->email,
        'customer_address' => $request->address,
        'customer_phone' => $request->phone,
    ]);

    // Lưu các mặt hàng trong đơn hàng và cập nhật số lượng sản phẩm
    foreach ($cart->items as $item) {
        // Tạo bản ghi mới trong bảng order_items
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);

        // Cập nhật số lượng sản phẩm còn lại trong bảng products
        $product = Product::find($item->product_id);
        $product->quantity -= $item->quantity;  // Trừ đi số lượng đã đặt hàng
        $product->save();  // Lưu lại thay đổi
    }

    // Xóa giỏ hàng sau khi đặt hàng
    $cart->items()->delete();  // Xóa các sản phẩm trong giỏ hàng
    $cart->delete();  // Xóa giỏ hàng

    return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công! Chờ xác nhận.');
}
public function myOrders()
{
    $orders = Orders::where('user_id', Auth::id())->with('orderItems.product')->get();
    return view('orders.my_orders', compact('orders'));
}


    public function adminIndex()
{
    $orders = Orders::with('orderItems.product')->get(); // Lấy tất cả các đơn hàng và sản phẩm trong đơn hàng
    return view('admin.orders.index', compact('orders'));
}



public function updateStatus(Request $request, $id)
{
    $order = Orders::findOrFail($id);
    $order->status = $request->status; // Đảm bảo rằng $request->status là 'paid'
    $order->save();

    // Nếu trạng thái được cập nhật thành 'paid', tạo bản ghi thanh toán
    if ($request->status === 'paid') {
        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total,
            'payment_method' => $order->payment_method,
        ]);
    }

    return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
}
}
