<div class="text-white text-[10px] py-2 tracking-[0.2em] text-center uppercase font-bold bg-red-950">
    Complimentary Shipping on orders over ₹5,000
</div>

<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-6"> <!-- Add flex and items-center -->
            <a data-drawer-target="sidebar-example" data-drawer-show="sidebar-example" aria-controls="sidebar-example" >
                <x-heroicon-o-bars-3 class="w-5 h-5 text-gray-500" />
            </a>
            <a href="/collection">
                <x-heroicon-o-building-storefront class="w-5 h-5 text-gray-500" />
            </a>
            <a href="/search">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-500" />
            </a>
        </div>
        

        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="h-[50px]"></a>

        <div class="flex items-center gap-6">
            <a href="/search"><x-heroicon-o-heart class="w-5 h-5 text-gray-500" /></a>

            @if(!Auth::check())
                <a href="/login">
                    <x-heroicon-o-user-circle class="w-5 h-5 text-gray-500" />
                </a>
            @else
                <a href="{{ route('account') }}">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-500" />
                </a>
            @endif
            <livewire:store.cart-counter />
        </div>
    </div>
</nav>