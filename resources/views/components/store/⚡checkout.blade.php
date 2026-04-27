<?php

use App\Models\{Order, OrderItem, CartItem};
use App\Models\Address;
use App\Models\Coupon;
use App\Services\ShippingCalculator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]
    public $email, $fullname, $address, $address_id, $city, $pincode, $house_no, $area, $phone, $landmark, $type, $is_default, $coupon_id_text;
    public $coupon_id = '';
    public $discount = 0;
    public $hasAddress = false;
    public $user;


    public function mount(){

        $this->hasAddress = Auth::user()->address()->get();
        $this->address_id = (string) $this->hasAddress->where('is_default', 1)->first()?->id;
        $this->user = Auth::user();

        if (session()->get('cart') == null || count(session()->get('cart')) === 0) {
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
        // $this->validate([
        //     'email' => 'required|email',
        //     'fullname' => 'required',
        //     'city' => 'required',
        //     'pincode' => 'required'
        // ]);

        // Address::create([
        //     'user_id' => Auth::id(),
        //     'fullname' => $this->fullname,
        //     'email' => $this->email,
        //     'phone' => $this->phone,
        //     'house_no' => $this->house_no,
        //     'area' => $this->area,
        //     'landmark' => $this->landmark,
        //     'city' => $this->city,
        //     'state' => $this->city,
        //     'pincode' => $this->pincode,
        //     'type' => $this->type,
        //     'is_default' => $this->is_default,
        // ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'address_id' => $this->address_id,
            'order_number' => 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
            'subtotal' => $this->getSubtotal(),
            'discount_amount' => $this->discount,
            'coupon_id' => $this->coupon_id ?: null,
            'shipping_charges' => $this->getShippingFeeProperty(),
            'total' => $this->getSubtotal() - $this->discount + $this->getShippingFeeProperty(),
            'status' => 'pending',
        ]);

        // 2. Transfer Cart Items to Order Items
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'quantity' => $item->quantity
            ]);
        }

        // 3. Clear Cart
        CartItem::where('user_id', Auth::id())->delete();

        session()->forget('cart');
        return redirect()->route('thanks', ['orderid' => $order->order_number]);

    }

    public function getSubtotal() {
        $cart = session()->get('cart', []);
        return array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
    }

    public function getShippingFeeProperty(){
        return ShippingCalculator::getFee($this->getSubtotal());
    }

    public function getTotal() {
        return $this->getSubTotal() + $this->getShippingFeeProperty() - $this->discount;
    }

    public function applyCoupon() {
        $this->resetErrorBag();

        $couponData = Coupon::where('code', $this->coupon_id_text)
            ->where('is_active', 1)
            ->first();

        if (!$couponData) {
            $this->dispatch('toast', text: 'Invalid or inactive coupon code.', type: 'error');
            return;
        }

        if ($couponData->expiry_date && Carbon::parse($couponData->expiry_date)->isPast()) {
            $this->dispatch('toast', text: 'This coupon has expired.', type: 'error');
            return;
        }

        if ($this->getSubtotal() < $couponData->min_order_amount) {
            $this->dispatch('toast', text: 'Minimum spend of ₹' . $couponData->min_order_amount . ' required.', type: 'error');
            return;
        }

        if ($couponData->usage_limit && $couponData->used_count >= $couponData->usage_limit) {
            $this->dispatch('toast', text: 'This coupon has reached its usage limit.', type: 'error');
            return;
        }

        if ($couponData->type === 'percent') {
            $this->coupon_id = $couponData->id;
            $this->discount = ($this->getSubtotal() * ($couponData->value / 100));
            $this->dispatch('toast', text: 'Coupon Code Applied Successfully', type: 'success');
        } else {
            $this->coupon_id = $couponData->id;
            $this->discount = $couponData->value;
            $this->dispatch('toast', text: 'Coupon Code Applied Successfully', type: 'success');
        }

    }
};
?>

<main class="pt-16 pb-16 px-6 md:px-12 max-w-7xl mx-auto">
    <div class="mb-24">
        <h1 class="font-headline text-4xl md:text-5xl tracking-tight mb-4">Checkout</h1>
        <p class="text-on-surface-variant font-body">Refining your ritual. Please provide your shipping and payment information.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">        
        <section class="lg:col-span-7 space-y-3">          

            <h2 class="font-headline font-bold uppercase text-md mb-3 flex items-center gap-2">Add Coupon Code</h2>                    
            <div class="flex flex-col sm:flex-row gap-4 mb-12">
                <input placeholder="Enter Coupon Code" class="w-full input-theme" wire:model="coupon_id_text">
                <button class="btn-theme" wire:click="applyCoupon">{{ $discount > 0 ? 'Applied' : 'Apply' }}</button>
            </div>

                        
            <div class="space-y-10">
                <div>
                    @if($this->hasAddress->isEmpty())
                    <h2 class="font-headline font-bold uppercase text-md mb-3 flex items-center gap-2">Add Shipping Details</h2>                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="relative md:col-span-2">
                            <label
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Full
                                Name</label>
                            <input wire:model="fullname"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Sophia Al-Maktoum" type="text" />
                                @error('fullname')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Email
                                Address</label>
                            <input wire:model="email"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="sophia@example.com" type="email" />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label wire:model="phone"
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Phone</label>
                            <input wire:model="phone"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="99999 99999" type="tel" />
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label wire:model="house_no"
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">House No</label>
                            <input wire:model="house_no"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="A-7" type="text" />
                                @error('house_no')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label wire:model="area"
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Area</label>
                            <input wire:model="area"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Downtown" type="text" />
                                @error('area')
                                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="relative">
                            <label 
                                class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">Landmark</label>
                            <input wire:model="landmark"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                                placeholder="Downtown Boulevard, Villa 42" type="text" />
                                @error('landmark')
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
                            <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-1 ml-1">
                                Type
                            </label>
                            <select wire:model="type"
                                class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Select Type</option>
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                                <option value="Other">Other</option>
                            </select>
                            
                            @error('type')
                                <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative">
                            <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-3 ml-1">
                                Set as Default?
                            </label>
                            <div class="flex items-center gap-6 px-1">
                                <label class="flex items-center cursor-pointer text-sm">
                                    <input type="radio" wire:model="is_default" value="1" 
                                        class="w-4 h-4 border-outline-variant text-secondary focus:ring-secondary focus:ring-offset-0 bg-transparent transition-colors">
                                    <span class="ml-2 text-on-surface">Yes</span>
                                </label>

                                <label class="flex items-center cursor-pointer text-sm">
                                    <input type="radio" wire:model="is_default" value="0" 
                                        class="w-4 h-4 border-outline-variant text-secondary focus:ring-secondary focus:ring-offset-0 bg-transparent transition-colors">
                                    <span class="ml-2 text-on-surface">No</span>
                                </label>
                            </div>

                            @error('is_default')
                                <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                    @else
                    <div class="mx-auto space-y-2">
                        <h2 class="font-headline font-bold uppercase text-md mb-3 flex items-center gap-2">Choose Shipping Address</h2>                    

                        @foreach($this->hasAddress as $address)
                        <div class="group address-card">
                            <label class="flex items-center p-4 cursor-pointer">
                            <input
                                type="radio" 
                                wire:model="address_id" 
                                value="{{ $address->id }}"                                
                                class="w-4 h-4 text-gray-950 border-slate-300" 
                                {{ $address->is_default == 1 ? "checked" : "" }}
                            />

                            <div class="ml-3 flex-1">
                                <span class="block font-semibold text-slate-900 text-[14px]">{{ strtoupper($address->type) }}</span>
                                <div class="grid grid-rows-[0fr] transition-all duration-300 group-has-[:checked]:grid-rows-[1fr]">
                                    <div class="overflow-hidden">
                                        <p class="mt-2 text-sm text-slate-500">{{ $address->fullname }}</p>
                                        <p class="mt-2 text-sm text-slate-500">{{ $address->phone }}</p>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="mt-2 text-sm text-slate-500">
                                            {{ $address->house_no }}, {{ $address->area }}, {{ $address->landmark }}, {{ $address->city }}, {{ $address->pincode }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endif
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
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1">{{ $item['category_name'] }}</p>
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
                        @if($this->shippingFee == 0)
                            <span class="text-green-600 font-bold uppercase tracking-widest text-[10px]">Complimentary</span>
                        @else
                            <span class="text-secondary">₹{{ number_format($this->shippingFee, 2) }}</span>
                        @endif
                        
                    </div>

                    <div class="flex justify-between items-center text-xs uppercase tracking-widest">
                        <span class="text-on-surface-variant">Discount</span>
                        @if($this->discount == 0)
                            <span class="text-green-600 font-bold uppercase tracking-widest text-[10px]"></span>
                        @else
                            <span class="text-secondary"> - ₹{{ number_format($this->discount, 2) }}</span>
                        @endif
                        
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-on-surface/10">
                        <span class="font-label font-bold uppercase tracking-widest">Total</span>
                        <span class="font-headline text-2xl text-primary">₹{{ number_format($this->getTotal(), 2) }}</span>
                    </div>
                </div>
                <button wire:click="placeOrder" class="w-full btn-theme cursor-pointer">
                    Complete Order
                </button>
                <div
                    class="flex items-center justify-center gap-2 text-[9px] uppercase tracking-widest text-on-surface-variant">
                    <x-lucide-lock class="size-4"/>
                    Secure Encrypted Transaction
                </div>
            </div>
        </aside>
    </div>
</main>