<?php

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;


new class extends Component
{
    #[Layout('layouts.store')]
    public function getCartProperty() {
        return session()->get('cart', []);
    }

    public function removeItem($key) {
        $cart = session()->get('cart', []);
        unset($cart[$key]);
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }

    public function updateQty($key, $qty) {
        $cart = session()->get('cart', []);
        if($qty > 0) {
            $cart[$key]['quantity'] = $qty;
            session()->put('cart', $cart);
        }
    }

    public function getTotal() {
        return array_reduce($this->cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }
};
?>

<div class="max-w-4xl mx-auto px-6 py-20">
    <h1 class="text-4xl font-serif mb-16 italic text-center">Your Bag</h1>

    @if(count($this->cart) > 0)
        <div class="space-y-8">
            @foreach($this->cart as $key => $item)
                <div class="flex gap-8 border-b border-zinc-100 pb-8 items-center">
                    <img src="{{ asset('storage/'.$item['image']) }}" class="w-24 h-32 object-cover bg-zinc-50">
                    <div class="flex-1 space-y-1">
                        <h3 class="font-serif text-lg">{{ $item['name'] }}</h3>
                        <p class="text-[10px] uppercase text-zinc-400 tracking-widest">{{ $item['variant_name'] }}</p>
                        <button wire:click="removeItem('{{ $key }}')" class="text-[10px] uppercase underline tracking-widest pt-4">Remove</button>
                    </div>
                    <div class="flex items-center gap-4">
                        <input type="number" value="{{ $item['quantity'] }}" 
                            wire:change="updateQty('{{ $key }}', $event.target.value)"
                            class="w-12 border-0 bg-zinc-50 text-center text-sm p-2">
                    </div>
                    <p class="font-mono text-sm w-24 text-right">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                </div>
            @endforeach

            <div class="pt-10 flex flex-col items-end space-y-6">
                <div class="flex justify-between w-64 border-t border-black pt-4">
                    <span class="uppercase text-[10px] font-bold tracking-[0.2em]">Subtotal</span>
                    <span class="font-serif text-xl">₹{{ number_format($this->getTotal(), 2) }}</span>
                </div>
                <flux:button href="/checkout" class="w-64 bg-black text-white h-14 rounded-none uppercase text-[10px] tracking-widest">
                    Checkout
                </flux:button>
            </div>
        </div>
    @else
        <div class="text-center py-20 space-y-6">
            <p class="text-zinc-400 font-light italic">Your bag is currently empty.</p>
            <flux:button href="/shop" variant="ghost" class="border border-black px-12 rounded-none">Start Shopping</flux:button>
        </div>
    @endif
</div>