@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back to orders</a>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Order {{ $order->transaction_id }}</h5>
                    <p class="text-muted small">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ $item->product->image }}" width="50" class="rounded me-2" alt="">
                                            {{ $item->product->name }}
                                        </td>
                                        <td>{{ config('shop.currency') }} {{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ config('shop.currency') }} {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr><th colspan="3" class="text-end">Total</th><th>{{ config('shop.currency') }} {{ number_format($order->total, 2) }}</th></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Status</h6>
                    <p><span class="badge bg-success text-capitalize">{{ $order->status }}</span>
                       <span class="badge bg-info text-capitalize">{{ $order->payment_status }}</span></p>
                    <h6>Shipping</h6>
                    <p class="mb-0">{{ $order->shipping_name }}<br>{{ $order->shipping_phone }}<br>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
