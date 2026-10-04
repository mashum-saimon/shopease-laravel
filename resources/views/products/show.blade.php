@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <img src="{{ $product->image }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">
                Brand: <a href="{{ route('brands.show', $product->brand) }}">{{ $product->brand->name }}</a> &middot;
                Category: <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
            </p>
            <h3 class="text-primary">{{ config('shop.currency') }} {{ number_format($product->price, 2) }}</h3>
            <p class="mt-3">{{ $product->description }}</p>

            @auth
                <form method="POST" action="{{ route('cart.store', $product) }}" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="99" class="form-control w-25">
                    <button class="btn btn-primary">Add to Cart</button>
                </form>

                @if ($inWishlist)
                    <form method="POST" action="{{ route('wishlist.destroy', $product) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-secondary">Remove from Wishlist</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('wishlist.store', $product) }}">
                        @csrf
                        <button class="btn btn-outline-danger">&#9825; Add to Wishlist</button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login to buy</a>
            @endauth
        </div>
    </div>

    @if ($related->isNotEmpty())
        <h4 class="mb-3">Related Products</h4>
        <div class="row row-cols-2 row-cols-md-4 g-3">
            @foreach ($related as $product)
                <div class="col">@include('partials.product-card')</div>
            @endforeach
        </div>
    @endif
@endsection
