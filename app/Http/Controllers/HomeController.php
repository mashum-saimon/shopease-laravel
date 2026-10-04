<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'sliders' => Slider::latest()->get(),
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'latestProducts' => Product::with(['brand', 'category'])->latest()->take(8)->get(),
            'featuredProducts' => Product::with(['brand', 'category'])->where('is_featured', true)->latest()->take(8)->get(),
        ]);
    }
}
