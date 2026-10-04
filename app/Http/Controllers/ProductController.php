<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])->latest()->paginate(12);

        return view('products.index', ['products' => $products, 'heading' => 'All Products']);
    }

    public function show(Product $product)
    {
        $product->load(['brand', 'category']);
        $related = Product::where('category_id', $product->category_id)
            ->whereKeyNot($product->id)->take(4)->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
            'inWishlist' => auth()->check() && auth()->user()->wishlistProducts()->whereKey($product->id)->exists(),
        ]);
    }

    public function byBrand(Brand $brand)
    {
        return view('products.index', [
            'products' => $brand->products()->with(['brand', 'category'])->latest()->paginate(12),
            'heading' => "Brand: {$brand->name}",
        ]);
    }

    public function byCategory(Category $category)
    {
        return view('products.index', [
            'products' => $category->products()->with(['brand', 'category'])->latest()->paginate(12),
            'heading' => "Category: {$category->name}",
        ]);
    }
}
