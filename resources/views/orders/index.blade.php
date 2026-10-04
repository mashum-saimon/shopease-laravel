@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h4 class="mb-3">Order History</h4>
    @if ($orders->isEmpty())
        <p class="text-muted">You have not placed any orders yet.</p>
    @else
        <div class="table-responsive">
            <table class="table align-middle bg-white shadow-sm">
                <thead><tr><th>Transaction</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->transaction_id }}</td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td>{{ $order->items_count }}</td>
                            <td>{{ config('shop.currency') }} {{ number_format($order->total, 2) }}</td>
                            <td><span class="badge bg-success text-capitalize">{{ $order->status }}</span></td>
                            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links('pagination::bootstrap-5') }}
    @endif
@endsection
