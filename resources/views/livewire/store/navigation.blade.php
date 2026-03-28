<?php
use Livewire\Component;
new class extends Component {}; ?>

<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <div class="hidden md:flex gap-8 text-[10px] uppercase tracking-[0.2em] font-medium">
            <a href="/shop" class="hover:text-zinc-400 transition-colors">Shop All</a>
            <a href="/collections" class="hover:text-zinc-400 transition-colors">Collections</a>
        </div>

        <a href="/" class="text-2xl font-serif italic tracking-tighter">Lumiskin</a>

        <div class="flex items-center gap-6 text-[10px] uppercase tracking-widest">
            @auth
                <a href="/account" class="hidden md:block hover:underline underline-offset-4">Account</a>
            @else
                <a href="/login" class="hover:underline underline-offset-4">Sign In</a>
            @endauth
            <a href="/cart" class="relative group">
                <span>Bag</span>
                <span class="ml-1 text-zinc-400">(0)</span>
            </a>
        </div>
    </div>
</nav>