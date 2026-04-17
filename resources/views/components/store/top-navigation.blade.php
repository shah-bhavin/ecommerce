@php
// Define your menu items in an array: 'Label' => 'Route Name'
$navItems = [
'HOME' => 'home',
'SHOP' => 'shop',
'ABOUT' => 'about',
'CONTACT' => 'contact'
];
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50 bg-[#fffef2] border-b border-[#bcbbb4]">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-20">
            <a class="text-2xl font-light tracking-wide" href="/" style="font-family: 'Cormorant Garamond', serif;">ABRARI LONDON</a>

            <nav class="hidden lg:flex items-center gap-10">
                @foreach($navItems as $label => $routeName)
                <a href="{{ route($routeName) }}"
                    class="nav-anchor relative"
                    style="font-family: Inter, sans-serif;">
                    {{ $label }}
                    @if(request()->routeIs($routeName))
                    <span class="absolute bottom-[-8px] left-0 w-full h-[1px] bg-[#333333]"></span>
                    @endif
                </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-6">
                <a href="{{ route('login') }}" class="hidden lg:block text-[#333333] hover:text-[#000000] transition-colors">
                    <x-lucide-user width="20" height="20" />
                </a>
                <a href="{{ route('cart') }}" class="hidden lg:block text-[#333333] hover:text-[#000000] transition-colors">
                    <x-lucide-shopping-bag width="20" height="20" />
                </a>
                <button @click="open = !open" href="{{ route('cart') }}" class="lg:hidden text-[#333333] hover:text-[#000000] transition-colors">
                    <template x-if="open">
                        <x-lucide-x width="20" height="20" />
                    </template>
                    <template x-if="!open">
                        <x-lucide-menu width="20" height="20" />
                    </template>
                </button>
            </div>
        </div>
    </div>
    <div x-show="open" x-transition @click.outside="open = false" class="lg:hidden bg-[#fffef2] border-t border-[#bcbbb4]">
        <nav class="flex flex-col px-6 py-6 gap-4"><a class="text-sm font-medium tracking-wide text-[#333333] py-2" href="/" data-discover="true" style="font-family: Inter, sans-serif;">HOME</a><a class="text-sm font-medium tracking-wide text-[#333333] py-2" href="/shop" data-discover="true" style="font-family: Inter, sans-serif;">SHOP</a><a class="text-sm font-medium tracking-wide text-[#333333] py-2" href="/about" data-discover="true" style="font-family: Inter, sans-serif;">ABOUT</a><a class="text-sm font-medium tracking-wide text-[#333333] py-2" href="/contact" data-discover="true" style="font-family: Inter, sans-serif;">CONTACT</a>
            <div class="flex gap-6 pt-4 border-t border-[#bcbbb4]"><button class="text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" aria-hidden="true">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg></button><button class="text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag" aria-hidden="true">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                        <path d="M3 6h18"></path>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg></button></div>
        </nav>
    </div>
</header>