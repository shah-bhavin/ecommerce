<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LUMISKIN | Molecular Skincare' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="bg-white text-zinc-900 antialiased font-sans">
    <div class="bg-black text-white text-[10px] py-2 tracking-[0.2em] text-center uppercase font-bold">
        Complimentary Shipping on orders over ₹5,000
    </div>

    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-zinc-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex gap-8 text-[11px] font-bold uppercase tracking-widest hidden lg:flex">
                <a href="/shop" class="hover:text-zinc-500 transition-colors">Shop All</a>
            </div>

            <a href="/" class="text-3xl font-serif tracking-tighter font-bold uppercase">LUMISKIN</a>

            <div class="flex items-center gap-6">
                <flux:button href="/search" variant="ghost" icon="magnifying-glass" />
                <livewire:store.cart-counter />
            </div>
        </div>
    </nav>

    <main>{{ $slot }}</main>

    <x-toast />
    @fluxScripts
</body>
</html>