<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'required|string',
            'price_cents' => 'required|integer|min:0',
            'material_composition' => 'required|array',
            'image_url' => 'required|url',
            'is_published' => 'boolean',
            'is_preorder' => 'boolean',
            'materials_cost_cents' => 'required|integer|min:0',
            'labor_cost_cents' => 'required|integer|min:0',
            'shipping_cost_cents' => 'required|integer|min:0',
            'operations_cost_cents' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products')->with('message', 'Product created successfully.');
    }
}
