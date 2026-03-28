<div class="text-white text-[10px] py-2 tracking-[0.2em] text-center uppercase font-bold bg-red-950">
    Complimentary Shipping on orders over ₹5,000
</div>

<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-6"> <!-- Add flex and items-center -->
            <flux:modal.trigger name="sidebar">
                <flux:icon.bars-3 />
            </flux:modal.trigger>
            <button data-drawer-target="sidebar-example" data-drawer-show="sidebar-example" aria-controls="sidebar-example" type="button" class="px-5 py-2.5 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm">
                Show Sidebar
            </button>
            <a data-drawer-target="sidebar-example" data-drawer-show="sidebar-example" aria-controls="sidebar-example" >
                <x-heroicon-s-user class="w-5 h-5 text-gray-500" />
            </a>


            <a href="/collection"><flux:icon.building-storefront /></a>
            <a href="/search"><flux:icon.magnifying-glass /></a>
        </div>
        

        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="h-[50px]"></a>

        <div class="flex items-center gap-6">
            <a href="/search"><flux:icon.heart /></a>
            @if(!Auth::check())
                <a href="/login"><flux:icon.user-circle /></a>
            @else
                <a href="{{ route('account') }}"><flux:icon.user /></a>
            @endif
            <livewire:store.cart-counter />
        </div>
    </div>
</nav>