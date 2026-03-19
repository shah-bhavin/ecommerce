<?php

use App\Models\{Product, Review};
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]

    public Product $product;
    public $selectedVariantId;
    public $quantity = 1;
    public $rating = 5;
    public $comment = '';

    public function mount($slug) {
        $this->product = Product::where('slug', $slug)->firstOrFail();
        $this->selectedVariantId = $this->product->first()?->id;
    }

    public function addToBag() {
        $cart = session()->get('cart', []);
        $variant = $this->product->find($this->selectedVariantId);
        
        $cartKey = $this->product->id . '-' . ($this->selectedVariantId ?? 'base');

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $this->quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'image' => $this->product->image,
                'quantity' => $this->quantity,
                'variant_id' => $this->selectedVariantId,
                'variant_name' => $variant?->volume ?? 'Standard'
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
        $this->dispatch('toast', type: 'success', text: 'Added to your bag');
    }

    public function submitReview() {
        $this->validate(['comment' => 'required|min:5']);
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment
        ]);
        $this->comment = '';
        $this->dispatch('toast', text: 'Thank you for your review');
    }
};
?>

<div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-24">
    <div class="bg-zinc-50 aspect-[4/5] overflow-hidden">
        <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
    </div>

    <div class="space-y-10 lg:sticky lg:top-32 h-fit">
        <div class="space-y-2">
            <h1 class="text-5xl font-serif tracking-tight">{{ $product->name }}</h1>
            <p class="text-2xl font-light">₹{{ number_format($product->price, 2) }}</p>
        </div>

        {{--@if($product->count() > 0)
            <div class="space-y-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Select Volume</p>
                <div class="flex gap-4">
                    @foreach($product->variants as $v)
                        <button wire:click="$set('selectedVariantId', {{ $v->id }})" 
                            class="px-8 py-4 border text-xs tracking-widest transition-all {{ $selectedVariantId == $v->id ? 'bg-black text-white' : 'border-zinc-200 text-zinc-400 hover:border-black' }}">
                            {{ $v->volume }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif--}}

        <div class="flex gap-4">
            <flux:input type="number" wire:model="quantity" min="1" class="w-20 text-center rounded-none" />
            <flux:button wire:click="addToBag" size="sm" class="flex-1 bg-black text-white h-14 rounded-none uppercase text-[10px] tracking-[0.3em]">
                Add to Bag
            </flux:button>
        </div>

        <div class="border-t border-zinc-100 pt-8 space-y-6">
            <details class="group cursor-pointer">
                <summary class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest py-4">The Science <flux:icon.plus size="sm" class="group-open:hidden" /></summary>
                <div class="text-sm text-zinc-500 leading-relaxed italic pb-4">{{ $product->ingredients }}</div>
            </details>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="mt-32 border-t border-zinc-100 pt-20">
        <h2 class="text-3xl font-serif italic mb-12 text-center">Clinical Results & Reviews</h2>
        
        <div class="grid lg:grid-cols-3 gap-20">
            {{-- Review Form --}}
            <div class="space-y-6">
                <h4 class="text-[10px] font-bold uppercase tracking-widest">Write a Review</h4>
                <div class="flex gap-2">
                    @for($i=1; $i<=5; $i++)
                        <button wire:click="$set('rating', {{ $i }})">
                            <flux:icon.star variant="solid" class="size-5 {{ $i <= $rating ? 'text-black' : 'text-zinc-200' }}" />
                        </button>
                    @endfor
                </div>
                <flux:textarea wire:model="comment" placeholder="Describe your experience..." class="rounded-none" />
                <flux:button wire:click="submitReview" class="bg-black text-white w-full rounded-none uppercase text-[10px] tracking-widest">Submit</flux:button>
            </div>

            {{-- Reviews List --}}
            <div class="lg:col-span-2 space-y-12">
                @foreach($product->reviews as $review)
                    <div class="border-b border-zinc-50 pb-8">
                        <div class="flex gap-1 mb-2">
                            @for($i=1; $i<=5; $i++)
                                <flux:icon.star variant="solid" class="size-3 {{ $i <= $review->rating ? 'text-black' : 'text-zinc-200' }}" />
                            @endfor
                        </div>
                        <p class="text-sm text-zinc-600 italic font-light">"{{ $review->comment }}"</p>
                        <p class="text-[9px] uppercase tracking-widest text-zinc-400 mt-4">— {{ $review->user->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>