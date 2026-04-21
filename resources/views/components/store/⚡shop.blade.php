<?php

use App\Models\{Product, Wishlist, CartItem, Category, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Url};
use Livewire\Component;
use App\Concerns\WishListTrait;

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
            'categories' => Category::withCount('products')->get(),
            // 'skin_types' => Product::distinct()->pluck('skin_type'),
            'orders' => Order::where('user_id', auth()->id())->latest()->get(),
            'totalCount' => Product::count(),

        ];
    }
};
?>


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
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input class="w-4 h-4" type="radio" checked="" name="category">
                                <span class="text-sm text-[#666666] group-hover:text-[#333333] transition-colors" style="font-family: Inter, sans-serif;">All Products ({{ @$totalCount }})</span>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input class="w-4 h-4" type="radio" name="category">
                                <span class="text-sm text-[#666666] group-hover:text-[#333333] transition-colors" style="font-family: Inter, sans-serif;">{{ @$category->name }} ({{ @$category->products_count }})</span>
                            </label>
                            @endforeach
                        </div>
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
            <div  x-data="{ open: @entangle('showFilters') }" class="lg:hidden col-span-1">
                <button  @click="open = !open" class="flex items-center gap-2 btn-primary w-full justify-center btn-theme">
                    <x-lucide-funnel class="size-4" />Filter &amp; Sort
                </button>
                <div x-show="open" x-transition class="mt-6 p-6 bg-[#f6f5e8] border border-[#bcbbb4]">
                    <h4 class="text-sm font-medium mb-4 tracking-wide">CATEGORY</h4>
                    <div class="space-y-3 mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input class="w-4 h-4" type="radio" checked="" name="category-mobile">
                            <span class="text-sm">>All Products ({{ @$totalCount }})</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input class="w-4 h-4" type="radio" name="category-mobile">
                            <span class="text-sm">{{ @$category->name }} ({{ @$category->products_count }})</span>
                        </label>
                        @endforeach
                    </div>
                    <h4 class="text-sm font-medium mb-4 tracking-wide">SORT BY</h4>
                    <select class="w-full px-4 py-3 border border-[#bcbbb4] bg-transparent text-sm" style="border-radius: 0px;">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name">Name: A to Z</option>
                    </select>
                </div>
            </div>
            <div class="lg:col-span-3">
                <div class="mb-6 flex justify-between items-center">
                    <p class="body-small text-[#666666]">10 products</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($products as $product)
                    <a class="group" href="/product/{{ $product->slug }}" data-discover="true">
                        <div class="mb-4 overflow-hidden hover-lift">
                            <img alt="{{ $product->name }}" class="w-full h-[320px] object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$product->image) }}"></div>
                        <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">{{ $product->name }}</h3>
                        <p class="body-small text-[#666666] mb-3 line-clamp-2">{{ $product->description }}</p>
                        <p class="body-regular font-medium">₹{{ number_format($product->price, 2) }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>




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