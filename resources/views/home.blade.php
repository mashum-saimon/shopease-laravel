@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @if ($sliders->isNotEmpty())
        <div id="heroSlider" class="carousel slide mb-5 rounded overflow-hidden shadow" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($sliders as $slider)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ $slider->image }}" class="d-block w-100" alt="{{ $slider->title }}">
                        <div class="carousel-caption bg-dark bg-opacity-50 rounded">
                            <h3>{{ $slider->title }}</h3>
                            <p>{{ $slider->subtitle }}</p>
                            @if ($slider->link)
                                <a href="{{ $slider->link }}" class="btn btn-warning">Shop Now</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @endif

    <h4 class="mb-3">Shop by Brand</h4>
    <div class="row row-cols-3 row-cols-md-6 g-3 mb-5">
        @foreach ($brands as $brand)
            <div class="col">
                <a href="{{ route('brands.show', $brand) }}" class="text-decoration-none text-dark">
                    <div class="card text-center h-100 shadow-sm">
                        <img src="{{ $brand->image }}" class="card-img-top brand-img" alt="{{ $brand->name }}">
                        <div class="card-body p-2 small fw-semibold">{{ $brand->name }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <h4 class="mb-3">Shop by Category</h4>
    <div class="row row-cols-3 row-cols-md-6 g-3 mb-5">
        @foreach ($categories as $category)
            <div class="col">
                <a href="{{ route('categories.show', $category) }}" class="text-decoration-none text-dark">
                    <div class="card text-center h-100 shadow-sm">
                        <img src="{{ $category->image }}" class="card-img-top brand-img" alt="{{ $category->name }}">
                        <div class="card-body p-2 small fw-semibold">{{ $category->name }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <h4 class="mb-3">Latest Products</h4>
    <div class="row row-cols-2 row-cols-md-4 g-3 mb-5">
        @foreach ($latestProducts as $product)
            <div class="col">@include('partials.product-card')</div>
        @endforeach
    </div>

    <h4 class="mb-3">Featured Products</h4>
    <div class="row row-cols-2 row-cols-md-4 g-3">
        @foreach ($featuredProducts as $product)
            <div class="col">@include('partials.product-card')</div>
        @endforeach
    </div>
@endsection
