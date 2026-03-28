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

    public function mount($category=null)
    {
        $this->category = $category;
    }

    // public function setView($mode) {
    //     $this->viewMode = $mode;
    // }

    public function setCategory($cat){
        return $this->redirect(route('shop', ['category' => $cat]), navigate: true);
    }

    public function with() {
        $query = Product::query();
        if($this->category!=''){
            if ($this->category) $query->where('category', $this->category);
        }

        $query = match($this->sort) {
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

<div class="max-w-7xl mx-auto px-6 py-12">
    {{-- Header & Breadcrumbs --}}
    <div class="mb-12 border-b border-zinc-100 pb-12">
        <nav class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 mb-4">
            <a href="/">Home</a> / <span class="text-zinc-900">Shop All</span>
        </nav>
        <h1 class="text-3xl font-serif tracking-tight uppercase">Shop</h1>
    </div>

    <div class="flex flex-col lg:flex-row! gap-12">
        {{-- Sidebar Filters --}}
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

            {{--<div>
                <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] mb-6 border-b border-zinc-100 pb-2">Skin Concern</h4>
                <div class="flex flex-col gap-3">
                    <button wire:click="$set('skin_type', '')" class="text-left text-xs uppercase tracking-widest {{ $skin_type == '' ? 'text-black font-bold' : 'text-zinc-400' }}">All Concerns</button>
                    @foreach($skin_types as $type)
                        <button wire:click="$set('skin_type', '{{ $type }}')" class="text-left text-xs uppercase tracking-widest {{ $skin_type == $type ? 'text-black font-bold' : 'text-zinc-400' }}">
                            {{ $type }} Skin
                        </button>
                    @endforeach
                </div>
            </div>--}}
        </aside>

        {{-- Product Area --}}
        <div class="flex-1">
            {{-- Toolbar --}}
            <div class="flex justify-between items-center mb-10 border-b border-zinc-100 pb-6">
                <div class="flex items-center gap-4">
                    <span class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $products->count() }} Products</span>
                    <!-- <div class="h-4 w-[1px] bg-zinc-200"></div>
                    <div class="flex gap-2">
                        <button wire:click="setView('grid')" class="{{ $viewMode == 'grid' ? 'text-black' : 'text-zinc-300' }}">
                            <flux:icon.squares-2x2 variant="micro" />
                        </button>
                        <button wire:click="setView('list')" class="{{ $viewMode == 'list' ? 'text-black' : 'text-zinc-300' }}">
                            <flux:icon.bars-3 variant="micro" />
                        </button>
                    </div> -->
                </div>

                <select wire:model.live="sort" class="text-[10px] uppercase tracking-widest border-0 focus:ring-0 cursor-pointer bg-transparent">
                    <option value="latest">New Arrivals</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                </select>
            </div>

            {{-- Grid View --}}
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
            {{-- @else
                <div class="flex flex-col gap-12">
                    @foreach($products as $product)
                        <div class="flex gap-10 items-center border-b border-zinc-50 pb-12 group">
                            <a href="/product/{{ $product->slug }}" class="w-48 aspect-square shrink-0 bg-zinc-50 overflow-hidden">
                                <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </a>
                            <div class="flex-1 space-y-3">
                                <h3 class="text-2xl font-serif">{{ $product->name }}</h3>
                                <p class="text-zinc-500 text-sm font-light max-w-lg line-clamp-2">{{ $product->description }}</p>
                                <div class="flex items-center gap-4 pt-2">
                                    <span class="text-lg font-bold">₹{{ number_format($product->base_price, 2) }}</span>
                                    <flux:button wire:click="addToBag({{ $product->id }})" variant="ghost" class="uppercase text-[9px] tracking-widest underline">Add to Bag</flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            @endif
        </div>
    </div>
</div>