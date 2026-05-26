<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('shop.index');
    }

    public function show(Product $product)
    {
        if (!$product->is_published) {
            abort(404);
        }
        
        return view('shop.show', compact('product'));
    }
}
