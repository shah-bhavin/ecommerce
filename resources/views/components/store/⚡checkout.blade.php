<?php

use App\Models\{Order, OrderItem, CartItem};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]
    public $email, $name, $address, $city, $pincode;
    public $coupon = '';
    public $discount = 0;

    public function placeOrder() {
        $this->validate([
            'email' => 'required|email',
            'name' => 'required',
            'address' => 'required'
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $this->getSubtotal() - $this->discount,
            'status' => 'pending',
            'order_number' => Str::random(5),
            'subtotal' => $this->getSubtotal(),
            //'coupon_code' => $this->coupon_code
        ]);

        // 2. Transfer Cart Items to Order Items
        $cartItems = CartItem::where('user_id', Auth::id())->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                //'price' => $item->product->price,
                'price' => 420,
                'quantity' => $item->quantity
            ]);
        }

        // 3. Clear Cart
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('thank-you');
        
        session()->forget('cart');
        return redirect()->route('thank-you');
    }

    public function getSubtotal() {
        $cart = session()->get('cart', []);
        return array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
    }

    public function applyCoupon() {
        if ($this->coupon === 'LUMI10') {
            $this->discount = 500; // Fixed discount for example
            $this->dispatch('toast', text: 'Coupon Applied!');
        } else {
            $this->addError('coupon', 'Invalid coupon code.');
        }
    }
};
?>

<div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-20">
    <div class="space-y-12">
        <h2 class="text-3xl font-serif italic">Shipping Details</h2>
        <div class="grid gap-6">
            <flux:input wire:model="email" label="Email Address" class="rounded-none" />
            <flux:input wire:model="name" label="Full Name" class="rounded-none" />
            <flux:textarea wire:model="address" label="Street Address" class="rounded-none" />
            <div class="grid grid-cols-2 gap-6">
                <flux:input wire:model="city" label="City" class="rounded-none" />
                <flux:input wire:model="pincode" label="Pincode" />
            </div>
        </div>
    </div>

    <div class="bg-zinc-50 p-10 h-fit space-y-8">
        <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">Order Summary</h3>
        <div class="space-y-4">
             @foreach(session()->get('cart', []) as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                    <span class="font-mono">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
             @endforeach
        </div>
        <div class="border-t border-zinc-200 pt-6 flex justify-between items-center">
            <span class="text-lg font-serif">Total Due</span>
            <span class="text-2xl font-serif">₹{{ number_format($this->getSubtotal(), 2) }}</span>
        </div>
        <flux:button wire:click="placeOrder" class="w-full bg-black text-white h-16 rounded-none uppercase text-xs tracking-widest">
            Complete Purchase
        </flux:button>
    </div>
</div>