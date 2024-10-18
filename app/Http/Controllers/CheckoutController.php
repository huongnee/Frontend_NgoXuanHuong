<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            // Bạn có thể thêm các trường khác tùy theo yêu cầu
        ]);

        // Thực hiện xử lý thanh toán ở đây (giả định là thanh toán thành công)
        // ...

        // Nếu thanh toán thành công
        session()->forget('cart'); // Reset giỏ hàng
        return redirect()->route('products.index')->with('success', 'Thanh toán thành công!');
    }
}
