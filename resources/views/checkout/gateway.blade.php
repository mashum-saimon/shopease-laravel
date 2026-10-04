@extends('layouts.app')

@section('title', 'SSLCommerz Demo Gateway')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white fw-bold">SSLCommerz &mdash; Demo Payment Gateway</div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-1">Transaction ID</p>
                    <p class="fw-semibold">{{ $order->transaction_id }}</p>
                    <p class="text-muted small mb-1">Amount payable</p>
                    <h3 class="mb-4">{{ config('shop.currency') }} {{ number_format($order->total, 2) }}</h3>
                    <p class="small text-muted">This is a simulated gateway. No real payment is taken.</p>

                    <form method="POST" action="{{ route('payment.success', $order->transaction_id) }}" class="mb-2">
                        @csrf
                        <button class="btn btn-success w-100">Pay Now (Success)</button>
                    </form>
                    <form method="POST" action="{{ route('payment.fail', $order->transaction_id) }}" class="mb-2">
                        @csrf
                        <button class="btn btn-outline-danger w-100">Simulate Failure</button>
                    </form>
                    <form method="POST" action="{{ route('payment.cancel', $order->transaction_id) }}">
                        @csrf
                        <button class="btn btn-outline-secondary w-100">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
