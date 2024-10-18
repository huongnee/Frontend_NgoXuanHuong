<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng từ database
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart) {
            return view('cart.index', ['cart' => null, 'total' => 0, 'count' => 0]);
        }

        // Tính tổng số lượng sản phẩm trong giỏ hàng
        $total = $cart->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Tính tổng số lượng sản phẩm trong giỏ hàng
        $count = $cart->items->sum('quantity');

        return view('cart.index', compact('cart', 'total', 'count'));
    }

    // Thêm sản phẩm vào giỏ hàng trong database
    public function add(Request $request, Product $product)
    {
        // Kiểm tra hoặc tạo mới giỏ hàng cho user hiện tại
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'pending']
        );

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Nếu có rồi, tăng số lượng lên
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Xóa sản phẩm khỏi giỏ hàng trong database
    public function remove($itemId)
    {
        $cartItem = CartItem::find($itemId);

        if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete(); // Xóa sản phẩm khỏi giỏ hàng
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    // Cập nhật số lượng sản phẩm trong giỏ hàng
public function update(Request $request, $itemId)
{
    // Tìm sản phẩm trong giỏ hàng
    $cartItem = CartItem::find($itemId);

    // Kiểm tra xem sản phẩm có thuộc giỏ hàng của user hiện tại không
    if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
        // Lấy số lượng từ request
        $quantity = $request->quantity;

        // Kiểm tra số lượng có lớn hơn 0 không
        if ($quantity > 0) {
            // Cập nhật số lượng
            $cartItem->quantity = $quantity;
            $cartItem->save();

            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
        } else {
            // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ hàng
            $cartItem->delete();

            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
        }
    }

    // Nếu không tìm thấy sản phẩm hoặc không thuộc về user, trả về thông báo lỗi
    return redirect()->route('cart.index')->with('error', 'Cập nhật thất bại!');
}

}
