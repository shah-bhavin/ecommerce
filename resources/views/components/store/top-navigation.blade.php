<div class="text-white text-[10px] py-2 tracking-[0.2em] text-center uppercase font-bold top-advertisement">
    Complimentary Shipping on orders over ₹5,000
</div>

<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <div class="flex items-center gap-6"> <!-- Add flex and items-center -->
            <flux:modal.trigger name="sidebar">
                <flux:icon.bars-3 />
            </flux:modal.trigger>
            <a href="/shop"><flux:icon.building-storefront /></a>
            <a href="/search"><flux:icon.magnifying-glass /></a>
        </div>
        

        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>

        <div class="flex items-center gap-6">
            <a href="/search"><flux:icon.heart /></a>
            <a href="/search"><flux:icon.user-circle /></a>
            <livewire:store.cart-counter />
        </div>
    </div>
</nav>