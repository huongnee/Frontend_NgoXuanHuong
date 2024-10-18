<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage; 
use App\Models\Product; 
use App\Models\Category; 

class ProductController extends Controller
{
    // Phương thức cho customer
    // public function index()
    // {
    //     $products = Product::with('category')->get(); // Lấy tất cả sản phẩm kèm theo thông tin danh mục
    //     return view('products.index', compact('products')); // Trả về view cho customer
    // }
    public function index() {
        $products = Product::paginate(9); // Hiển thị 6 sản phẩm mỗi trang
        return view('products.index', compact('products'));
    }

    // Phương thức cho admin
    public function index1()
    {
        $products = Product::with('category')->get(); // Lấy tất cả sản phẩm kèm theo thông tin danh mục
        return view('admin.products.index', compact('products')); // Trả về view cho admin
    }

    // Hiển thị form để tạo sản phẩm mới
    public function create()
    {
        $categories = Category::all(); // Lấy tất cả danh mục để hiển thị trong dropdown
        return view('admin.products.create', compact('categories')); // Trả về view 'products.create' với biến 'categories'
    }

    // Xử lý việc lưu sản phẩm mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Validate dữ liệu gửi từ form
        $request->validate([
            'name' => 'required', 
            'description' => 'required', 
            'quantity' => 'required|integer', 
            'price' => 'required|numeric', 
            'category_id' => 'required|exists:categories,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý việc upload ảnh
        $imagePath = null; 
        if ($request->hasFile('image')) { 
            $imagePath = $request->file('image')->store('images/products', 'public'); 
        }

        // Tạo sản phẩm mới với dữ liệu từ form
        Product::create([
            'name' => $request->name, 
            'description' => $request->description, 
            'quantity' => $request->quantity, 
            'price' => $request->price,
            'category_id' => $request->category_id, 
            'image' => $imagePath, 
        ]);

        // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    // Hiển thị form để chỉnh sửa thông tin sản phẩm
    public function edit(Product $product)
    {
        $categories = Category::all(); // Lấy tất cả danh mục để hiển thị trong dropdown
        return view('admin.products.edit', compact('product', 'categories')); // Trả về view 'products.edit' với biến 'product' và 'categories'
    }

    // Xử lý việc cập nhật thông tin sản phẩm
    public function update(Request $request, Product $product)
    {
        // Validate dữ liệu gửi từ form
        $request->validate([
            'name' => 'required', 
            'description' => 'required', 
            'quantity' => 'required|integer', 
            'price' => 'required|numeric', 
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Xử lý việc upload ảnh
        $imagePath = $product->image; // Lấy đường dẫn ảnh hiện tại
        if ($request->hasFile('image')) { // Nếu có file ảnh được gửi lên
            // Nếu có ảnh cũ, xóa nó
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath); // Xóa ảnh cũ
            }
            $imagePath = $request->file('image')->store('images/products', 'public'); // Lưu ảnh mới vào thư mục 'images/products' trong disk 'public'
        }

        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->name, 
            'description' => $request->description, 
            'quantity' => $request->quantity, 
            'price' => $request->price, 
            'category_id' => $request->category_id,
            'image' => $imagePath, 
        ]);

        // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    public function destroy(Product $product)
    {
        $product->delete(); // Xóa sản phẩm
        // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
    public function search(Request $request)
{
    $id = $request->input('id');
    $product = Product::where('id', $id)->paginate(6); // Phân trang sản phẩm tìm thấy

    if ($product->count() > 0) {
        return view('products.index', ['products' => $product]); // Truyền sản phẩm đã phân trang
    } else {
        return redirect()->route('products.index')->with('error', 'Sản phẩm không tìm thấy.'); // Chuyển hướng về trang danh sách sản phẩm
    }
}
public function show($id)
{
    $product = Product::with('category')->findOrFail($id); // Tìm sản phẩm theo ID và lấy luôn thông tin category

    return view('products.show', compact('product')); // Trả về view hiển thị chi tiết sản phẩm
}



}
