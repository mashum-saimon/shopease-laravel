<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DemoPaymentGateway;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private DemoPaymentGateway $gateway)
    {
    }

    public function index()
    {
        $items = auth()->user()->cartItems()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', ['items' => $items, 'total' => $items->sum->subtotal, 'user' => auth()->user()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:100'],
            'shipping_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:500'],
        ]);

        $items = $request->user()->cartItems()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($request, $items, $data) {
            $order = Order::create($data + [
                'user_id' => $request->user()->id,
                'transaction_id' => 'TXN-'.strtoupper(Str::random(12)),
                'total' => $items->sum->subtotal,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            return $order;
        });

        return redirect($this->gateway->createSession($order));
    }

    public function gateway(string $transaction)
    {
        $order = $this->ownedOrder($transaction);

        abort_if($order->payment_status !== 'unpaid', 404);

        return view('checkout.gateway', ['order' => $order]);
    }

    public function success(string $transaction): RedirectResponse
    {
        $order = $this->ownedOrder($transaction);

        if ($order->payment_status === 'unpaid') {
            DB::transaction(function () use ($order) {
                $this->gateway->markPaid($order);
                $order->user->cartItems()->delete();
            });
        }

        return redirect()->route('orders.show', $order)->with('success', 'Payment successful! Your order has been placed.');
    }

    public function fail(string $transaction): RedirectResponse
    {
        $this->gateway->markFailed($this->ownedOrder($transaction), 'failed');

        return redirect()->route('cart.index')->with('error', 'Payment failed. Your cart is still saved.');
    }

    public function cancel(string $transaction): RedirectResponse
    {
        $this->gateway->markFailed($this->ownedOrder($transaction), 'cancelled');

        return redirect()->route('cart.index')->with('error', 'Payment cancelled. Your cart is still saved.');
    }

    private function ownedOrder(string $transaction): Order
    {
        return Order::where('transaction_id', $transaction)->where('user_id', auth()->id())->firstOrFail();
    }
}
