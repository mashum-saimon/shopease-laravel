@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h4 class="mb-3">Shopping Cart</h4>
    @if ($items->isEmpty())
        <p class="text-muted">Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a></p>
    @else
        <div class="table-responsive">
            <table class="table align-middle bg-white shadow-sm">
                <thead>
                    <tr><th>Product</th><th>Price</th><th style="width:180px">Quantity</th><th>Subtotal</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <img src="{{ $item->product->image }}" width="60" class="rounded me-2" alt="">
                                <a href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a>
                            </td>
                            <td>{{ config('shop.currency') }} {{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="d-flex gap-1">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                            </td>
                            <td>{{ config('shop.currency') }} {{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th colspan="2">{{ config('shop.currency') }} {{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
    @endif
@endsection
