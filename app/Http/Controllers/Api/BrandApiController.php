<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPassport;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandApiController extends Controller
{
    public function listProducts(Request $request)
    {
        $brand = $request->authenticated_brand;
        $products = $brand->products()->with('category')->get();

        return response()->json($products);
    }

    public function createProduct(Request $request)
    {
        $brand = $request->authenticated_brand;

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price_cents' => 'required|integer|min:1',
            'material_composition' => 'required|array',
        ]);

        $product = Product::create([
            'brand_id' => $brand->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'price_cents' => $request->price_cents,
            'material_composition' => $request->material_composition,
            'is_published' => true,
        ]);

        return response()->json($product, 201);
    }

    public function mintPassport(Request $request)
    {
        $brand = $request->authenticated_brand;

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string',
            'factory_id' => 'required|exists:factories,id',
            'manufacturing_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->brand_id !== $brand->id) {
            return response()->json(['error' => 'Product does not belong to your brand.'], 403);
        }

        $passport = ProductPassport::create([
            'product_id' => $product->id,
            'batch_number' => $request->batch_number,
            'factory_id' => $request->factory_id,
            'manufacturing_date' => $request->manufacturing_date,
            'qr_token' => Str::upper(Str::random(3)) . '-' . Str::upper(Str::random(3)),
            'is_verified' => true,
            'last_audit_hash' => hash('sha256', Str::random(10)),
        ]);

        return response()->json($passport, 201);
    }
}
