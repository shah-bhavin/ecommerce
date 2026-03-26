{{-- Featured Products --}}
<section class="py-8 max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-end mb-16">
        <h2 class="text-4xl font-serif">The Essentials</h2>
        <a href="/shop" class="text-[10px] font-bold uppercase tracking-widest border-b border-black pb-1">View All</a>
    </div>

    <div class="grid md:grid-cols-4 gap-12">
        @foreach($featured as $product)
            <a href="/product/{{ $product->slug }}" class="group block space-y-6">
                <div class="aspect-[4/5] bg-zinc-50 overflow-hidden relative border border-zinc-100">
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-serif mb-2">{{ $product->name }}</h3>
                    <p class="text-sm text-zinc-500 tracking-widest uppercase">₹{{ number_format($product->price, 2) }}</p>
                </div>
            </a>
        @endforeach
    </div>
</section>