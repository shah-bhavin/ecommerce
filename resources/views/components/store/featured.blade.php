{{-- Featured Products --}}
<section class="py-8 max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-end mb-16">
        <h2 class="text-2xl font-serif">The Essentials</h2>
        <a href="/shop" class="text-[10px] font-bold uppercase tracking-widest border-b border-black pb-1">View All</a>
    </div>

    <div class="grid md:grid-cols-4 gap-4">
        @foreach($products as $product)
            <div class="group relative">
                <button wire:click="toggleWishlist({{ $product->id }})" class="absolute top-4 right-4 z-10 p-2 bg-white/80 backdrop-blur rounded-full hover:scale-110 transition-transform">
                    <flux:icon.heart variant="{{ $product->isWishlisted ? 'solid' : 'outline' }}" class="size-4 {{ $product->isWishlisted ? 'text-red-500' : 'text-zinc-400' }}" />
                </button>
                <a href="/product/{{ $product->slug }}" class="block space-y-4">
                    <div class="aspect-[4/5] bg-zinc-50 overflow-hidden relative">
                        <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                        @if($product->is_featured)
                            <span class="absolute top-4 left-4 text-[8px] bg-black text-white px-2 py-1 uppercase tracking-[0.2em]">Best Seller</span>
                        @endif
                    </div>
                    <div class="text-center px-4">
                        <h3 class="font-serif text-lg leading-tight mb-1">{{ $product->name }}</h3>
                        <p class="text-[9px] text-zinc-400 uppercase tracking-[0.2em] mb-3">{{ $product->skin_type }}</p>
                        <p class="text-sm font-bold">₹{{ number_format($product->base_price, 2) }}</p>
                    </div>
                </a>
                <button wire:click="addToBag({{ $product->id }})" class="mt-4 w-full border border-black py-3 text-[9px] uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 transition-opacity hover:bg-black hover:text-white">
                    Quick Add +
                </button>
            </div>
        @endforeach
    </div>
</section>