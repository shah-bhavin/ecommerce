<?php

use App\Models\{Product, Review};
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]

    // public Product $product;
    // public $selectedVariantId;
    // public $quantity = 1;
    // public $rating = 5;
    // public $comment = '';

    // public function mount($slug)
    // {
    //     $this->product = Product::where('slug', $slug)->firstOrFail();
    //     $this->selectedVariantId = $this->product->first()?->id;
    // }

    // public function addToBag()
    // {
    //     $cart = session()->get('cart', []);
    //     $variant = $this->product->find($this->selectedVariantId);

    //     $cartKey = $this->product->id . '-' . ($this->selectedVariantId ?? 'base');

    //     if (isset($cart[$cartKey])) {
    //         $cart[$cartKey]['quantity'] += $this->quantity;
    //     } else {
    //         $cart[$cartKey] = [
    //             'id' => $this->product->id,
    //             'name' => $this->product->name,
    //             'price' => $this->product->price,
    //             'image' => $this->product->image,
    //             'quantity' => $this->quantity,
    //             'variant_id' => $this->selectedVariantId,
    //             'variant_name' => $variant?->volume ?? 'Standard'
    //         ];
    //     }

    //     session()->put('cart', $cart);
    //     $this->dispatch('cart-updated');
    //     $this->dispatch('toast', type: 'success', text: 'Added to your bag');
    // }

    // public function submitReview()
    // {
    //     $this->validate(['comment' => 'required|min:5']);
    //     Review::create([
    //         'user_id' => auth()->id(),
    //         'product_id' => $this->product->id,
    //         'rating' => $this->rating,
    //         'comment' => $this->comment
    //     ]);
    //     $this->comment = '';
    //     $this->dispatch('toast', text: 'Thank you for your review');
    // }
};
?>

{{--<div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-24">
    <div class="bg-zinc-50 aspect-[4/5] overflow-hidden">
        <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover">
</div>

<div class="space-y-10 lg:sticky lg:top-32 h-fit">
    <div class="space-y-2">
        <h1 class="text-5xl font-serif tracking-tight">{{ $product->name }}</h1>
        <p class="text-2xl font-light">₹{{ number_format($product->price, 2) }}</p>
    </div>

    @if($product->count() > 0)
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
@endif

<div class="flex gap-4">
    <flux:input type="number" wire:model="quantity" min="1" class="w-20 text-center rounded-none" />
    <flux:button wire:click="addToBag" size="sm" class="flex-1 bg-black text-white h-14 rounded-none uppercase text-[10px] tracking-[0.3em]">
        Add to Bag
    </flux:button>
</div>

<div class="border-t border-zinc-100 pt-8 space-y-6">
    <details class="group cursor-pointer">
        <summary class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest py-4">The Science
            <flux:icon.plus size="sm" class="group-open:hidden" />
        </summary>
        <div class="text-sm text-zinc-500 leading-relaxed italic pb-4">{{ $product->ingredients }}</div>
    </details>
</div>
</div>

<div class="mt-32 border-t border-zinc-100 pt-20">
    <h2 class="text-3xl font-serif italic mb-12 text-center">Clinical Results & Reviews</h2>

    <div class="grid lg:grid-cols-3 gap-20">
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

        <div class="lg:col-span-2 space-y-12">
            @foreach($product->reviews as $review)
            <div class="border-b border-zinc-50 pb-8">
                <div class="flex gap-1 mb-2">
                    @for($i=1; $i
                    <=5; $i++)
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
</div>--}}

<div class="min-h-screen bg-[#fffef2]">
    <div class="max-w-[1400px] mx-auto px-6 pt-8"><a class="inline-flex items-center gap-2 text-sm text-[#666666] hover:text-[#333333] transition-colors" href="/shop" data-discover="true" style="font-family: Inter, sans-serif;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left" aria-hidden="true">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>Back to Shop</a></div>
    <section class="py-12 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div><img alt="Pure Essence Toner" class="w-full h-[600px] object-cover hover-lift" src="https://images.pexels.com/photos/9496253/pexels-photo-9496253.jpeg"></div>
                <div>
                    <div class="sticky top-24">
                        <p class="text-sm text-[#666666] mb-4 tracking-wide uppercase" style="font-family: Inter, sans-serif;">Skincare</p>
                        <h1 class="hero-medium mb-4">Pure Essence Toner</h1>
                        <p class="heading-2 mb-8 font-medium">£95</p>
                        <p class="body-large text-[#666666] mb-8 leading-relaxed">A refined toner that balances and prepares skin for optimal absorption.</p>
                        <div class="mb-8 pb-8 border-b border-[#bcbbb4]">
                            <div class="mb-4">
                                <h3 class="text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">KEY INGREDIENTS</h3>
                                <p class="body-regular text-[#666666]">Rose Water, Witch Hazel, Aloe Vera, Green Tea</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">SIZE</h3>
                                <p class="body-regular text-[#666666]">100ml</p>
                            </div>
                        </div>
                        <div class="mb-8">
                            <div class="flex items-center gap-4 mb-6"><label class="text-sm font-medium tracking-wide" style="font-family: Inter, sans-serif;">QUANTITY</label>
                                <div class="flex items-center border border-[#bcbbb4]"><button class="px-4 py-2 text-[#333333] hover:bg-[#f6f5e8] transition-colors">−</button><span class="px-6 py-2 border-x border-[#bcbbb4] text-sm" style="font-family: Inter, sans-serif;">1</span><button class="px-4 py-2 text-[#333333] hover:bg-[#f6f5e8] transition-colors">+</button></div>
                            </div><button class="btn-primary w-full flex items-center justify-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag" aria-hidden="true">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>Add to Cart</button>
                        </div>
                        <div class="space-y-3 text-sm text-[#666666]" style="font-family: Inter, sans-serif;">
                            <p>✓ Free shipping on orders over £100</p>
                            <p>✓ Complimentary samples with every order</p>
                            <p>✓ Luxury packaging included</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8]">
        <div class="max-w-[1400px] mx-auto">
            <h2 class="heading-2 mb-12 text-center">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"><a class="group" href="/product/skin-1" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift"><img alt="Luminous Facial Serum" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1622618991227-412b19e4fef9"></div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Luminous Facial Serum</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">A vitamin-rich serum that delivers radiant, youthful-looking skin with 24-carat gold essence.</p>
                    <p class="body-regular font-medium">£185</p>
                </a><a class="group" href="/product/skin-2" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift"><img alt="Velvet Hydration Cream" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1739980737820-b6bb1a9b8456"></div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Velvet Hydration Cream</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">Luxuriously rich moisturizer that deeply nourishes and restores skin's natural barrier.</p>
                    <p class="body-regular font-medium">£165</p>
                </a><a class="group" href="/product/skin-3" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift"><img alt="Radiance Night Elixir" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1622618991746-fe6004db3a47"></div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Radiance Night Elixir</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">An overnight treatment that transforms skin while you sleep, revealing luminous complexion.</p>
                    <p class="body-regular font-medium">£210</p>
                </a></div>
        </div>
    </section>
</div>