<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function index1()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
}
