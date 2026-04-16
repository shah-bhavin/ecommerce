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

    public function mount(){
        if (session()->get('cart') == null || count(session()->get('cart')) === 0) {
            
            // 2. Redirect back to shop with a message
            return redirect()->route('shop')->with('notify', 'Your bag must contain items to checkout.');
        }
        if (!Auth::check()) {
            return redirect()->route('login')->with(
                'toast', [
                    'type'=> 'danger', 
                    'text'=> 'Please login first to checkout'
                ]);
        }
    }

    public function placeOrder() {
        $this->validate([
            'email' => 'required|email',
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required'
        ]);

        $order = Order::create([
            //'user_id' => Auth::id(),

            'user_id' => 2,
            'total' => $this->getSubtotal() - $this->discount,
            'status' => 'pending',
            'order_number' => Str::random(5),
            'subtotal' => $this->getSubtotal(),
            //'coupon_code' => $this->coupon_code
        ]);

        // 2. Transfer Cart Items to Order Items
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                //'price' => 420,
                'quantity' => $item->quantity
            ]);
        }

        // 3. Clear Cart
        CartItem::where('user_id', Auth::id())->delete();
        //return redirect()->route('thanks', ['orderid' => $order->id]);

        session()->forget('cart');
        return redirect()->route('thanks', ['orderid' => $order->order_number]);

    }

    // public function getSubtotal() {
    //     $cart = session()->get('cart', []);
    //     return array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
    // }

    // public function applyCoupon() {
    //     if ($this->coupon === 'LUMI10') {
    //         $this->discount = 500; // Fixed discount for example
    //         $this->dispatch('toast', text: 'Coupon Applied!');
    //     } else {
    //         $this->addError('coupon', 'Invalid coupon code.');
    //     }
    // }
};
?>

{{--<div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-20">
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
</div>--}}


<main class="pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
        <section class="lg:col-span-7 space-y-12">
            <div>
                <h1 class="font-headline text-4xl md:text-5xl tracking-tight mb-4">Checkout</h1>
                <p class="text-on-surface-variant font-body">Refining your ritual. Please provide your shipping and
                    payment information.{{ Auth::id() }}</p>
            </div>
            <div class="space-y-10">
                <div>
                    <h2 class="font-headline text-xl mb-6 flex items-center gap-2">
                        Shipping Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="relative">
                            <label
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Full
                                Name</label>
                            <input wire:model="name"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Sophia Al-Maktoum" type="text" />
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label wire:model="address"
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Email
                                Address</label>
                            <input wire:model="email"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="sophia@example.com" type="email" />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative md:col-span-2">
                            <label 
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Street
                                Address</label>
                            <input wire:model="address"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Downtown Boulevard, Villa 42" type="text" />
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">City</label>
                            <input wire:model="city"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Dubai" type="text" />
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Postal
                                Code</label>
                            <input wire:model="pincode"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="00000" type="text" />
                                @error('pincode')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <aside class="lg:col-span-5">
            <div class="sticky top-32 bg-surface-container p-8 md:p-12 space-y-8">
                <h2 class="font-headline text-2xl tracking-tight">Order Summary</h2>
                <div class="space-y-6">
                    @foreach(session()->get('cart', []) as $item)
                    <div class="flex gap-6 items-center">
                        <div class="w-20 h-20 bg-surface-container-highest flex-shrink-0">
                            <img alt="Radiant Serum" class="w-full h-full object-cover"
                                data-alt="Close-up of a frosted glass skincare bottle with golden liquid inside, minimalist luxury studio lighting on a warm rose background"
                                src="{{ asset('storage/'.$item['image']) }}" />
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-label font-bold text-sm uppercase tracking-wide">{{ $item['name'] }} (x{{ $item['quantity'] }})</h3>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1">{{ $item['variant_name'] }}</p>
                            <p class="font-headline text-secondary mt-2">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="space-y-4 pt-8 border-t border-outline-variant/30">
                    <div class="flex justify-between items-center text-xs uppercase tracking-widest">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span>₹{{ number_format($this->getSubtotal(), 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs uppercase tracking-widest">
                        <span class="text-on-surface-variant">Shipping</span>
                        <span class="text-secondary">Complimentary</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-on-surface/10">
                        <span class="font-label font-bold uppercase tracking-widest">Total</span>
                        <span class="font-headline text-2xl text-primary">₹{{ number_format($this->getSubtotal(), 2) }}</span>
                    </div>
                </div>
                <button wire:click="placeOrder"
                    class="w-full bg-primary! text-white py-6 px-8 text-xs font-bold uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:scale-[1.02] transition-transform duration-400">
                    Complete Order
                </button>
                <div
                    class="flex items-center justify-center gap-2 text-[9px] uppercase tracking-widest text-on-surface-variant">
                    <span class="material-symbols-outlined text-xs" data-icon="lock">lock</span>
                    Secure Encrypted Transaction
                </div>
            </div>
        </aside>
    </div>
</main>