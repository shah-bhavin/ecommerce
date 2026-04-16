<?php

use App\Concerns\WishListTrait;
use App\Models\{Product, Wishlist, CartItem, Category, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Url};
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]

    #[Url] public $category = '';
    #[Url] public $sort = 'latest';

    use WishListTrait;

    public $viewMode = 'grid';

    public function mount($category = null)
    {
        $this->category = $category;
    }

    public function setCategory($cat)
    {
        return $this->redirect(route('shop', ['category' => $cat]), navigate: true);
    }

    public function with()
    {
        $query = Product::query();
        if ($this->category != '') {
            if ($this->category) $query->where('category', $this->category);
        }

        $query = match ($this->sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        return [
            'products' => $query->get(),
            //'categories' => Product::distinct()->pluck('category'),
            'categories' => Category::get(),
            // 'skin_types' => Product::distinct()->pluck('skin_type'),
            'orders' => Order::where('user_id', auth()->id())->latest()->get()

        ];
    }
};
?>

{{--<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-12 border-b border-zinc-100 pb-12">
        <nav class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 mb-4">
            <a href="/">Home</a> / <span class="text-zinc-900">Shop All</span>
        </nav>
        <h1 class="text-3xl font-serif tracking-tight uppercase">Shop</h1>
    </div>

    <div class="flex flex-col lg:flex-row! gap-12">
        <aside class="w-full md:w-64! space-y-10 shrink-0">
            <div>
                <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] mb-6 border-b border-zinc-100 pb-2">Category</h4>
                <div class="flex flex-col gap-3">
                    <button wire:click="setCategory('')" class="text-left text-xs uppercase tracking-widest {{ $category == '' ? 'text-black font-bold' : 'text-zinc-400' }}">All</button>
@foreach($categories as $cat)
<button wire:click="setCategory('{{ $cat->slug }}')" class="text-left text-xs uppercase tracking-widest {{ $category == $cat ? 'text-black font-bold' : 'text-zinc-400' }}">
    {{ $cat->name }}s
</button>
@endforeach
</div>
</div>


</aside>

<div class="flex-1">
    <div class="flex justify-between items-center mb-10 border-b border-zinc-100 pb-6">
        <div class="flex items-center gap-4">
            <span class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $products->count() }} Products</span>

        </div>

        <select wire:model.live="sort" class="text-[10px] uppercase tracking-widest border-0 focus:ring-0 cursor-pointer bg-transparent">
            <option value="latest">New Arrivals</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
        </select>
    </div>

    @if($viewMode == 'grid')
    <div class="grid grid-cols-1 md:grid-cols-3! gap-x-8 gap-y-16">
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
            <button wire:click="addToBag({{ $product->id }})" class="mt-4 w-full border border-black! py-3 text-[9px] uppercase tracking-[0.2em] opacity-0 group-hover:opacity-100 transition-opacity hover:bg-black hover:text-white">
                Quick Add +
            </button>
        </div>
        @endforeach
    </div>
</div>
</div>
</div>--}}

<div class="min-h-screen bg-[#fffef2]">
    <section class="py-16 px-6 bg-[#f6f5e8] text-center">
        <h1 class="hero-medium mb-4">Our Collection</h1>
        <p class="body-large text-[#666666]">Discover luxury that defines you</p>
    </section>
    <div class="max-w-[1400px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <aside class="hidden lg:block">
                <div class="sticky top-24">
                    <h3 class="heading-3 mb-6">Filter</h3>
                    <div class="mb-8">
                        <h4 class="text-sm font-medium mb-4 tracking-wide" style="font-family: Inter, sans-serif;">CATEGORY</h4>
                        <div class="space-y-3"><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4" type="radio" checked="" name="category"><span class="text-sm text-[#666666] group-hover:text-[#333333] transition-colors" style="font-family: Inter, sans-serif;">All Products (10)</span></label><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4" type="radio" name="category"><span class="text-sm text-[#666666] group-hover:text-[#333333] transition-colors" style="font-family: Inter, sans-serif;">Skincare (5)</span></label><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4" type="radio" name="category"><span class="text-sm text-[#666666] group-hover:text-[#333333] transition-colors" style="font-family: Inter, sans-serif;">Makeup (5)</span></label></div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium mb-4 tracking-wide" style="font-family: Inter, sans-serif;">SORT BY</h4><select class="w-full px-4 py-3 border border-[#bcbbb4] bg-transparent text-[#333333] text-sm focus:outline-none focus:border-[#333333] transition-colors" style="border-radius: 0px; font-family: Inter, sans-serif;">
                            <option value="featured">Featured</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name">Name: A to Z</option>
                        </select>
                    </div>
                </div>
            </aside>
            <div class="lg:hidden col-span-1"><button class="flex items-center gap-2 btn-primary w-full justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel" aria-hidden="true">
                        <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z"></path>
                    </svg>Filter &amp; Sort</button></div>
            <div class="lg:col-span-3">
                <div class="mb-6 flex justify-between items-center">
                    <p class="body-small text-[#666666]">10 products</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8"><a class="group" href="/product/skin-1" data-discover="true">
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
                    </a><a class="group" href="/product/skin-4" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Pure Essence Toner" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.pexels.com/photos/9496253/pexels-photo-9496253.jpeg"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Pure Essence Toner</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">A refined toner that balances and prepares skin for optimal absorption.</p>
                        <p class="body-regular font-medium">£95</p>
                    </a><a class="group" href="/product/skin-5" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Renewal Eye Treatment" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.pexels.com/photos/33365010/pexels-photo-33365010.jpeg"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Renewal Eye Treatment</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Delicate eye cream that diminishes fine lines and restores youthful radiance.</p>
                        <p class="body-regular font-medium">£145</p>
                    </a><a class="group" href="/product/cos-1" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Velvet Matte Lipstick" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1598452963314-b09f397a5c48"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Velvet Matte Lipstick</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Luxuriously smooth matte finish with long-lasting color and comfortable wear.</p>
                        <p class="body-regular font-medium">£48</p>
                    </a><a class="group" href="/product/cos-2" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Luminous Foundation" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1608979048467-6194dabc6a3d"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Luminous Foundation</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Weightless coverage with a radiant finish that perfects and enhances natural beauty.</p>
                        <p class="body-regular font-medium">£78</p>
                    </a><a class="group" href="/product/cos-3" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Golden Hour Highlighter" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.pexels.com/photos/4889711/pexels-photo-4889711.jpeg"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Golden Hour Highlighter</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Champagne-gold illuminator that captures light for an ethereal glow.</p>
                        <p class="body-regular font-medium">£62</p>
                    </a><a class="group" href="/product/cos-4" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Signature Eyeshadow Palette" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.pexels.com/photos/4938498/pexels-photo-4938498.jpeg"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Signature Eyeshadow Palette</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Curated collection of neutral and sophisticated shades for timeless elegance.</p>
                        <p class="body-regular font-medium">£95</p>
                    </a><a class="group" href="/product/cos-5" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift"><img alt="Precision Liquid Eyeliner" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1590156221350-bbf9f89cd368"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">Precision Liquid Eyeliner</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">Ultra-fine brush tip for effortless precision and dramatic definition.</p>
                        <p class="body-regular font-medium">£38</p>
                    </a></div>
            </div>
        </div>
    </div>
</div>