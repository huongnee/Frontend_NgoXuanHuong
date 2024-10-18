<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }
    
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    // public function index1()
    // {
    //     $categories = Category::all();
    //     return view('categories.index', compact('categories'));
    // }
}
