{{--<footer class="pt-20 pb-10 bg-black">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-16 mb-20">
            <div class="lg:col-span-5 space-y-8">
                <h2 class="text-3xl font-serif tracking-tight text-white">Abrari Collection</h2>
                <p class="text-xs uppercase tracking-[0.2em] text-white leading-relaxed max-w-sm">
                    Subscribe to receive clinical skincare updates, exclusive invitations, and 10% off your first molecular order.
                </p>
                
                <form wire:submit="subscribe" class="relative max-w-md">
                    <input 
                        wire:model="email"
                        type="email" 
                        placeholder="EMAIL ADDRESS" 
                        class="w-full border-b border-zinc-300 py-3 text-[10px] tracking-[0.2em] focus:outline-none focus:border-black transition-colors bg-transparent rounded-none text-white"
                    >
                    <button type="submit" class="absolute right-0 bottom-3 text-[10px] font-bold tracking-[0.2em] uppercase hover:text-zinc-400 transition-colors text-white">
                        Join —>
                    </button>
                </form>
            </div>

            <div class="lg:col-span-7 grid grid-cols-2 md:grid-cols-3 gap-12">
                <div class="space-y-6">
                    <h3 class="text-[10px] font-bold uppercase text-white tracking-[0.2em]">The Collections</h3>
                    <ul class="space-y-3 text-xs text-zinc-500 font-light tracking-wide">
                        <li><a href="/shop/reparative" class="hover:text-black transition-colors">Reparative</a></li>
                        <li><a href="/shop/intensive" class="hover:text-black transition-colors">Intensive</a></li>
                        <li><a href="/shop/treatment" class="hover:text-black transition-colors">Treatment</a></li>
                        <li><a href="/shop/clarity" class="hover:text-black transition-colors">Clarity</a></li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-white">Concierge</h3>
                    <ul class="space-y-3 text-xs text-zinc-500 font-light tracking-wide">
                        <li><a href="/shipping" class="hover:text-black transition-colors">Shipping & Returns</a></li>
                        <li><a href="/faq" class="hover:text-black transition-colors">Frequently Asked Questions</a></li>
                        <li><a href="/contact" class="hover:text-black transition-colors">Contact Us</a></li>
                        <li><a href="/account" class="hover:text-black transition-colors">My Account</a></li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-white">Explore</h3>
                    <ul class="space-y-3 text-xs text-zinc-500 font-light tracking-wide">
                        <li><a href="/about" class="hover:text-black transition-colors">The Science</a></li>
                        <li><a href="/blog" class="hover:text-black transition-colors">Clinical Journal</a></li>
                        <li><a href="/stockists" class="hover:text-black transition-colors">Our Stockists</a></li>
                        <li><a href="/privacy" class="hover:text-black transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pt-10 border-t border-zinc-50 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-[9px] uppercase tracking-[0.3em] text-white text-center md:text-right">
                © {{ date('Y') }} LUMISKIN CLINICAL SOLUTIONS. ALL RIGHTS RESERVED.
            </div>
        </div>
    </div>
</footer>--}}


<!-- Footer -->
<footer class="bg-rose-950 flex flex-col items-center justify-center py-20 px-8 w-full border-t border-white/5 tonal-shift">
    <div class="text-xl font-headline text-amber-500 mb-12 tracking-widest uppercase">
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="h-[50px]"></a>
    </div>
    <div class="flex flex-wrap justify-center gap-12 mb-16">
        <a class="font-label text-xs uppercase tracking-[0.2em] text-white/40 hover:text-amber-500 transition-colors duration-400" href="#">PRIVACY</a>
        <a class="font-label text-xs uppercase tracking-[0.2em] text-white/40 hover:text-amber-500 transition-colors duration-400" href="#">TERMS</a>
        <a class="font-label text-xs uppercase tracking-[0.2em] text-white/40 hover:text-amber-500 transition-colors duration-400" href="#">SHIPPING</a>
        <a class="font-label text-xs uppercase tracking-[0.2em] text-white/40 hover:text-amber-500 transition-colors duration-400" href="#">CONTACT</a>
    </div>
    <div class="flex gap-8 mb-16">
        <span class="material-symbols-outlined text-white/20 hover:text-amber-500 cursor-pointer transition-colors" data-icon="language">language</span>
        <span class="material-symbols-outlined text-white/20 hover:text-amber-500 cursor-pointer transition-colors" data-icon="share">share</span>
        <span class="material-symbols-outlined text-white/20 hover:text-amber-500 cursor-pointer transition-colors" data-icon="favorite">favorite</span>
    </div>
    <p class="font-label text-xs uppercase tracking-[0.2em] text-white/30 text-center">
        © 2024 RADIANT MONOLITH. ALL RIGHTS RESERVED.
    </p>
</footer>