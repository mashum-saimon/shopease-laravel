@extends('layouts.app')

@section('title', $heading)

@section('content')
    <h4 class="mb-3">{{ $heading }}</h4>
    <div class="row row-cols-2 row-cols-md-4 g-3">
        @forelse ($products as $product)
            <div class="col">@include('partials.product-card')</div>
        @empty
            <p class="text-muted">No products found.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
