<header class="sticky top-0 z-50 bg-[#fffef2] border-b border-[#bcbbb4]">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-20"><a class="text-2xl font-light tracking-wide" href="/" data-discover="true" style="font-family: &quot;Cormorant Garamond&quot;, serif;">ABRARI LONDON</a>
            <nav class="hidden lg:flex items-center gap-10">
                <a href="{{ route('home') }}" class="text-sm font-medium tracking-wide transition-all relative text-[#333333]" href="/" data-discover="true" style="font-family: Inter, sans-serif;">HOME<span class="absolute bottom-[-8px] left-0 w-full h-[1px] bg-[#333333]"></span></a>
                <a href="{{ route('shop') }}" class="text-sm font-medium tracking-wide transition-all relative text-[#666666] hover:text-[#333333]" href="/shop" data-discover="true" style="font-family: Inter, sans-serif;">SHOP</a>
                <a href="{{ route('about') }}" class="text-sm font-medium tracking-wide transition-all relative text-[#666666] hover:text-[#333333]" href="/about" data-discover="true" style="font-family: Inter, sans-serif;">ABOUT</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium tracking-wide transition-all relative text-[#666666] hover:text-[#333333]" href="/contact" data-discover="true" style="font-family: Inter, sans-serif;">CONTACT</a>
            </nav>
            <div class="flex items-center gap-6">
                <a href="{{ route('login') }}" class="hidden lg:block text-[#333333] hover:text-[#000000] transition-colors">
                    <x-lucide-user  width="20" height="20" />
                </a>
            
                <a href="{{ route('cart') }}" class="hidden lg:block text-[#333333] hover:text-[#000000] transition-colors">
                    <x-lucide-shopping-bag  width="20" height="20" />
                </a>
            </div>
        </div>
    </div>
</header>