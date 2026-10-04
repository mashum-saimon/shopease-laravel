<?php

namespace App\Services;

use App\Models\Order;

/**
 * Demo stand-in for the SSLCommerz hosted payment flow.
 * It mimics the real gateway: create session -> redirect to gateway page -> success / fail / cancel callback.
 */
class DemoPaymentGateway
{
    public function createSession(Order $order): string
    {
        return route('payment.gateway', $order->transaction_id);
    }

    public function markPaid(Order $order): void
    {
        $order->update(['payment_status' => 'paid', 'status' => 'processing']);
    }

    public function markFailed(Order $order, string $status): void
    {
        $order->update(['payment_status' => $status, 'status' => 'cancelled']);
    }
}
