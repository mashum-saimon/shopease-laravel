@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
    <h4 class="mb-3">My Wishlist</h4>
    <div class="row row-cols-2 row-cols-md-4 g-3">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image }}" class="card-img-top product-img" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body">
                        <h6>{{ $product->name }}</h6>
                        <p class="fw-bold text-primary">{{ config('shop.currency') }} {{ number_format($product->price, 2) }}</p>
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('cart.store', $product) }}" class="flex-grow-1">
                                @csrf
                                <button class="btn btn-sm btn-primary w-100">Add to Cart</button>
                            </form>
                            <form method="POST" action="{{ route('wishlist.destroy', $product) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Your wishlist is empty.</p>
        @endforelse
    </div>
@endsection
