<div class="card h-100 shadow-sm">
    <a href="{{ route('products.show', $product) }}">
        <img src="{{ $product->image }}" class="card-img-top product-img" alt="{{ $product->name }}">
    </a>
    <div class="card-body d-flex flex-column">
        <small class="text-muted">{{ $product->brand->name }} &middot; {{ $product->category->name }}</small>
        <h6 class="card-title mt-1">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
        </h6>
        <p class="fw-bold text-primary mb-3">{{ config('shop.currency') }} {{ number_format($product->price, 2) }}</p>
        <div class="mt-auto d-flex gap-2">
            @auth
                <form method="POST" action="{{ route('cart.store', $product) }}" class="flex-grow-1">
                    @csrf
                    <button class="btn btn-sm btn-primary w-100">Add to Cart</button>
                </form>
                <form method="POST" action="{{ route('wishlist.store', $product) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" title="Add to wishlist">&#9825;</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary w-100">Login to buy</a>
            @endauth
        </div>
    </div>
</div>
