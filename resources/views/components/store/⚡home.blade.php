<?php
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;



new class extends Component
{
    #[Layout('layouts.store')]
    public function with() {
        return [
            'featured' => Product::get()
        ];
    }
};
?>

<div>
    {{-- Hero Section --}}
    <section class="relative h-[85vh] bg-zinc-100 flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full grid lg:grid-cols-2 gap-12">
            <div class="space-y-8 self-center">
                <h1 class="text-7xl font-serif leading-[0.9] tracking-tighter">Clinical <br>Precision.</h1>
                <p class="text-lg text-zinc-600 max-w-md font-light leading-relaxed">Experience the future of skincare with our surgically-inspired molecular formulas.</p>
                <flux:button href="/shop" variant="primary" size="sm" class="rounded-none px-12 h-14 bg-black text-white">Discover More</flux:button>
            </div>
        </div>
        {{-- Hero Image Background --}}
        <div class="absolute inset-y-0 right-0 w-1/2 hidden lg:block bg-[url('https://images.unsplash.com/photo-1556229010-6c3f2c9ca5f8?auto=format&fit=crop&q=80')] bg-cover bg-center"></div>
    </section>

    {{-- Featured Products --}}
    <section class="py-32 max-w-7xl mx-auto px-6">
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
</div>