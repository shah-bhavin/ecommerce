<div class="border border-zinc-100 p-10 space-y-6">
    <h3 class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-100 pb-2">Your Wishlist</h3>
    <div class="space-y-4">
        <p class="text-sm tracking-tight">{{ $wishlistCount }} Items Saved</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3! gap-x-8 gap-y-16">
        @foreach($wishlists as $wishlist)
            <div class="group relative">
                <button wire:click="toggleWishlist({{ $wishlist->product->id }})" class="absolute top-4 right-4 z-10 p-2 bg-white/80 backdrop-blur rounded-full hover:scale-110 transition-transform">
                    <flux:icon.heart variant="{{ $wishlist->product->isWishlisted ? 'solid' : 'outline' }}" class="size-4 {{ $wishlist->product->isWishlisted ? 'text-red-500' : 'text-zinc-400' }}" />
                </button>
                <a href="/product/{{ $wishlist->product->slug }}" class="block space-y-4">
                    <div class="aspect-[4/5] bg-zinc-50 overflow-hidden relative">
                        <img src="{{ asset('storage/'.$wishlist->product->image) }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                        @if($wishlist->product->is_featured)
                            <span class="absolute top-4 left-4 text-[8px] bg-black text-white px-2 py-1 uppercase tracking-[0.2em]">Best Seller</span>
                        @endif
                    </div>
                    <div class="text-center px-4">
                        <h3 class="font-serif text-lg leading-tight mb-1">{{ $wishlist->product->name }}</h3>
                        <p class="text-sm font-bold">₹{{ number_format($wishlist->product->price, 2) }}</p>
                    </div>
                </a>
                <button wire:click="addToBag({{ $wishlist->product->id }})" class="mt-4 w-full border border-black! py-3 text-[9px] uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 transition-opacity hover:bg-black hover:text-white">
                    Quick Add +
                </button>
            </div>
        @endforeach
    </div>
</div>