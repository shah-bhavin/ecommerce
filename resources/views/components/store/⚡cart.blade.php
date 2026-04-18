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

    public function checkout() {
        return redirect('/checkout');
    }
};
?>

<main class="pt-16 pb-16 px-6 md:px-12 lg:px-24 max-w-7xl mx-auto">
    <header class="mb-8">
        <h1 class="hero-medium mb-4 text-center">Your Ritual Cart</h1>
    </header>
    @if(count($this->cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <div class="lg:col-span-8">
                @if(count($this->cart) > 0)
                <div class="space-y-12">
                    @foreach($this->cart as $key => $item)
                    <div class="flex flex-col md:flex-row gap-8 pb-12 border-b border-outline-variant/10 group">
                        <div class="w-full md:w-48 aspect-square overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover grayscale-[20%] group-hover:scale-105 transition-transform duration-700"
                                data-alt="Minimalist frosted glass bottle of facial serum on a warm sandstone surface with soft natural light shadows"
                                src="{{ asset('storage/'.$item['image']) }}" />
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-headline text-xl mb-1">{{ $item['name'] }}</h3>
                                    <p
                                        class="text-xs font-label uppercase tracking-widest text-on-surface-variant mb-4">
                                        {{ $item['variant_name'] }}</p>
                                </div>
                                <p class="font-headline text-lg">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                            <div class="flex justify-between items-center mt-8">
                                <div class="flex items-center gap-4">
                                    <input type="number" value="{{ $item['quantity'] }}" 
                                        wire:change="updateQty('{{ $key }}', $event.target.value)"
                                        class="w-12 border-0 bg-zinc-50 text-center text-sm p-2">
                                </div>
                                <button  wire:click="removeItem('{{ $key }}')"
                                    class="flex items-center text-xs font-label uppercase tracking-widest text-on-surface-variant hover:text-error transition-colors group">
                                    <span class="material-symbols-outlined text-sm mr-2"
                                        data-icon="delete">delete</span>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach                
                </div>
                @endif
            </div>
            <div class="lg:col-span-4 lg:sticky lg:top-32">
                <div class="bg-surface-container-low p-10">
                    <h2 class="font-headline text-2xl mb-8">Summary</h2>
                    <div class="space-y-6 mb-10 border-b border-outline-variant/10 pb-10">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-label text-on-surface-variant uppercase tracking-widest">Subtotal</span>
                            <span class="font-headline">₹{{ number_format($this->getTotal(), 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-label text-on-surface-variant uppercase tracking-widest">Shipping</span>
                            <span class="font-label italic text-secondary text-xs uppercase">Complimentary</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-label text-on-surface-variant uppercase tracking-widest">Estimated
                                Tax</span>
                            <span class="font-headline">₹{{ number_format($this->getTotal()*5/100, 2) }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-10">
                        <span class="font-headline text-xl">Total</span>
                        <span class="font-headline text-2xl text-primary">₹{{ number_format($this->getTotal()+ $this->getTotal()*5/100, 2) }}</span>
                    </div>
                    <button wire:click="checkout"
                        class="w-full hero-gradient bg-black text-white py-5 font-label uppercase tracking-[0.2em] text-xs font-bold hover:brightness-110 transition-all duration-300">
                        Checkout
                    </button>
                    <div class="mt-8 flex items-center justify-center space-x-4 opacity-50">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <p class="text-[10px] font-label uppercase tracking-widest">Encrypted Payment Gateway</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 border border-dashed border-zinc-200">
            <p class="hero-medium mb-8">
                Your selection is currently empty.
            </p>
            <a href="/" class="btn-theme">
                Continue Shopping
            </a>
        </div>
    @endif
</main>

