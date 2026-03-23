<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}; ?>

<aside class="w-full md:w-64 space-y-8 shrink-0">
    <div class="border-b border-zinc-100 pb-6">
        <h2 class="text-2xl font-serif italic text-zinc-800">Hello, {{ Auth::user()->name }}</h2>
        <p class="text-[9px] uppercase tracking-[0.2em] text-zinc-400 mt-1">Lumiskin Member</p>
    </div>

    <nav class="flex flex-col gap-2">
        <flux:navlist variant="outline">
            <flux:navlist.item href="/account" :current="request()->is('account')">Dashboard</flux:navlist.item>
            <flux:navlist.item href="/account/orders" :current="request()->is('account/orders*')">Orders & Tracking</flux:navlist.item>
            <flux:navlist.item href="/account/profile" :current="request()->is('account/profile')">Personal Details</flux:navlist.item>
        </flux:navlist>

        <button wire:click="logout" class="mt-8 text-left text-[10px] font-bold uppercase tracking-[0.2em] text-red-800 hover:text-red-600 transition-colors">
            Sign Out —>
        </button>
    </nav>
</aside>