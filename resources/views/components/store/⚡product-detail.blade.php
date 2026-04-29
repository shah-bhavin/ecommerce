<?php

use App\Models\{Product, Review};
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Concerns\WishListTrait;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[Layout('layouts.store')]

    public Product $product;
    public $selectedVariantId;
    public $rating = 5;
    public $comment = '';
    public $products, $key;
    public $qty = 1;
    use WishListTrait; 

    public function mount($slug)
    {
        $this->product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $this->products = Product::with('category')->where('category_id', $this->product->category_id)->get();
        $this->qty;
    }

    public function increaseQty(){
        $this->qty++;
    }

    public function decreaseQty()
    {
         if ($this->qty > 1) {
            $this->qty--;
        }
    }

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

@section('title', $product->name . ' | Shop Abrari')
@section('meta_description', Str::limit($product->description, 155))
@section('og_type', 'product')
@section('meta_image', asset('storage/' . $product->image ))

@push('head')
<script type="application/ld+json">
@verbatim
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "image": ["{{ asset('storage/'.$product->image) }}"],
  "description": "{{ Str::limit($product->description, 150) }}",
  "sku": "{{ $product->sku }}",
  "brand": { "@type": "Brand", "name": "Abrari" },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "INR",
    "price": "{{ $product->price }}",
    "availability": "https://schema.org/InStock"
  }
}
@endverbatim
</script>
@endpush

<div class="min-h-screen bg-[#fffef2]">
    <div class="max-w-[1400px] mx-auto px-6 pt-8">
        <a class="inline-flex items-center gap-2 text-sm text-[#666666] hover:text-[#333333] transition-colors" href="/shop" data-discover="true" style="font-family: Inter, sans-serif;"><x-lucide-arrow-left class="size-4"/>Back to Shop</a>
    </div>
    <section class="py-12 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <img alt="Pure Essence Toner" class="w-full h-[600px] object-cover hover-lift" src="{{ asset('storage/'.$product->image) }}">
                </div>
                <div>
                    <div class="sticky top-24">
                        <p class="text-sm text-[#666666] mb-4 tracking-wide uppercase" style="font-family: Inter, sans-serif;">{{ $this->product->category->name }}</p>
                        <h1 class="hero-medium mb-4">{{ $this->product->name }}</h1>
                        <p class="heading-2 mb-8 font-medium">₹{{ number_format($this->product->price, 2) }}</p>
                        <p class="body-large text-[#666666] mb-8 leading-relaxed">{{ $this->product->description }}</p>
                        <div class="mb-8 pb-8 border-b border-[#bcbbb4]">
                            <div class="mb-4">
                                <h3 class="text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">KEY INGREDIENTS</h3>
                                <p class="body-regular text-[#666666]">{{ $this->product->key_ingredients }}</p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">SIZE</h3>
                                <p class="body-regular text-[#666666]">{{ $this->product->size }}</p>
                            </div>
                        </div>
                        <div class="mb-8">
                            <div class="flex items-center gap-4 mb-6"><label class="text-sm font-medium tracking-wide" style="font-family: Inter, sans-serif;">QUANTITY</label>
                                <div class="flex items-center border border-[#bcbbb4]">
                                    <button wire:click="decreaseQty" class="px-4 py-2 text-[#333333] hover:bg-[#f6f5e8] transition-colors">−</button>
                                        <span class="px-6 py-2 border-x border-[#bcbbb4] text-sm" style="font-family: Inter, sans-serif;">{{ $qty }}</span>
                                    <button wire:click="increaseQty" class="px-4 py-2 text-[#333333] hover:bg-[#f6f5e8] transition-colors">+</button>
                                </div>
                            </div>
                            <button wire:click="addToBag({{ $product->id }}, {{ $qty }})" class="cursor-pointer btn-theme w-full flex items-center justify-center gap-3"><x-lucide-shopping-bag class="size-4" />Add to Cart</button>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($this->products->random(3) as $product)
                <a class="group" href="{{ $product->slug }}" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift">
                        <img alt="{{ $product->name }}" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$product->image) }}"></div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">{{ $product->name }}</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">{{ $product->description }}</p>
                    <p class="body-regular font-medium">₹{{ number_format($product->price, 2) }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
</div>