@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h4 class="mb-3">Checkout</h4>
    <div class="row g-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Shipping Details</h5>
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', $user->name) }}" class="form-control @error('shipping_name') is-invalid @enderror" required>
                            @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $user->phone) }}" class="form-control @error('shipping_phone') is-invalid @enderror" required>
                            @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="shipping_address" rows="3" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-success w-100">Pay with SSLCommerz (Demo)</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Order Summary</h5>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach ($items as $item)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ $item->product->name }} &times; {{ $item->quantity }}</span>
                                <span>{{ config('shop.currency') }} {{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span><span>{{ config('shop.currency') }} {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
