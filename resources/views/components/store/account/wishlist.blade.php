<div class="border border-zinc-100 p-10 space-y-6">
    <h3 class="text-[18px] uppercase font-bold mb-4">Your Wishlist</h3>
    <div class="space-y-4">
        <p class="body-text">{{ $wishlistCount }} Items Saved</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3! gap-x-8 gap-y-16">
        @foreach($wishlists as $wishlist)
            <div class="relative group">
                <!-- Heart Button: Now OUTSIDE the product link -->
                <button
                    type="button"
                    wire:click="toggleWishlist({{ $wishlist->product->id }})"
                    class="absolute top-3 right-3 z-20 p-2 bg-white/80 backdrop-blur-sm rounded-full text-gray-600 hover:text-red-500 hover:bg-white transition-all shadow-sm">
                    <x-lucide-heart class="size-4" />
                </button>

                <!-- Product Link -->
                <a href="/product/{{ $wishlist->product->slug }}" class="block" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift">
                        <img alt="{{ $wishlist->product->name }}" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$wishlist->product->image) }}">
                    </div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">{{ $wishlist->product->name }}</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">{{ $wishlist->product->description }}</p>
                    <p class="body-regular font-medium">₹{{ number_format($wishlist->product->price, 2) }}</p>
                </a>
            </div>
        @endforeach
    </div>
</div>