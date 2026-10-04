<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlist.index', [
            'products' => auth()->user()->wishlistProducts()->with(['brand', 'category'])->latest('wishlists.created_at')->get(),
        ]);
    }

    public function store(Product $product): RedirectResponse
    {
        auth()->user()->wishlistProducts()->syncWithoutDetaching([$product->id]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        auth()->user()->wishlistProducts()->detach($product->id);

        return back()->with('success', 'Removed from wishlist.');
    }
}
