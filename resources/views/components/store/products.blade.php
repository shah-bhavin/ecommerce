{{-- Featured Products --}}
{{--<section class="py-8 max-w-7xl mx-auto px-6">
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
                        <p class="text-sm font-bold">₹{{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
                <button wire:click="addToBag({{ $product->id }})" class="mt-4 w-full border border-black py-3 text-[9px] uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 transition-opacity hover:bg-black hover:text-white">
                    Quick Add +
                </button>
            </div>
        @endforeach
    </div>
</section>--}}


<section class="py-32 container mx-auto px-12">
    <div class="flex flex-col md:flex-row items-end justify-between mb-20 gap-8">
        <div class="max-w-xl">
            <h2 class="text-primary font-headline text-5xl mb-6">Desert Essentials</h2>
            <p class="text-on-surface-variant leading-relaxed">Formulated for the extreme climate of the Emirates, our signature line balances hydration and protection with uncompromising luxury.</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
        <div class="md:col-span-7 group">
            <div class="relative overflow-hidden aspect-[4/5] bg-surface-container-highest mb-8">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Luxury sunscreen bottle on a marble pedestal, dramatic shadows, warm desert aesthetic, high-end packaging design" src="{{ asset('storage/'.$products[0]->image) }}" />
                <div class="absolute bottom-6 right-6">
                    <button type="button" wire:click="addToBag({{ $products[0]->id }})" class="bg-white/90 backdrop-blur p-4 shadow-xl hover:bg-primary! hover:text-white transition-colors duration-400">
                        <span class="material-symbols-outlined" data-icon="add">add</span>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-headline text-2xl text-on-surface mb-2 italic">{{ $products[0]->name }}</h3>
                    <p class="font-label text-xs text-on-surface-variant uppercase tracking-widest">{{ $products[0]->name }}</p>
                </div>
                <span class="font-headline text-xl text-primary">₹{{ number_format($products[0]->price, 2) }}</span>
            </div>
        </div>
        <div class="md:col-span-5 md:mt-24 group">
            <div class="relative overflow-hidden aspect-[4/5] bg-surface-container-highest mb-8">
                <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Elegant face wash glass bottle with golden pump, placed near splashing water and desert stones, soft morning light" src="{{ asset('storage/'.$products[1]->image) }}" />
                <div class="absolute bottom-6 right-6">
                    <button wire:click="addToBag({{ $products[1]->id }})" class="bg-white/90 backdrop-blur p-4 shadow-xl hover:bg-primary! hover:text-white transition-colors duration-400">
                        <span class="material-symbols-outlined" data-icon="add">add</span>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-headline text-2xl text-on-surface mb-2 italic">{{ $products[1]->name }}</h3>
                    <p class="font-label text-xs text-on-surface-variant uppercase tracking-widest">{{ $products[1]->name }}</p>
                </div>
                <span class="font-headline text-xl text-primary">₹{{ number_format($products[1]->price, 2) }}</span>
            </div>
        </div>
    </div>
</section>