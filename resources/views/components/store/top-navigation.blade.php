{{--<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-3"> <!-- Add flex and items-center -->
            <a data-drawer-target="sidebar-example" data-drawer-show="sidebar-example" aria-controls="sidebar-example" class="cursor-pointer">
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

        <div class="flex items-center gap-3">
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
</nav>--}}


<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 bg-rose-900/90 backdrop-blur-xl flex justify-between items-center px-12 py-4 w-full no-line-rule tonal-shift">
    <div class="text-3xl font-headline tracking-widest text-white uppercase">
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="h-[50px]"></a>
    </div>
    <div class="hidden md:flex items-center space-x-12">
        <a class="text-amber-500 font-bold border-b-2 border-amber-500 pb-1 font-label uppercase text-xs tracking-widest" href="#">COLLECTIONS</a>
        <a class="text-white/80 font-medium uppercase text-xs tracking-widest hover:text-amber-400 transition-all duration-400 ease-in-out" href="#">ABOUT</a>
        <a class="text-white/80 font-medium uppercase text-xs tracking-widest hover:text-amber-400 transition-all duration-400 ease-in-out" href="#">RITUALS</a>
    </div>
    <div class="flex items-center space-x-2">
        <livewire:store.cart-counter />

        <button class="text-white hover:text-amber-400 transition-transform scale-105">
            <span class="material-symbols-outlined" data-icon="person">person</span>
        </button>
    </div>
</nav>