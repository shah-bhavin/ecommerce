<?php
use App\Models\{Order, Wishlist};
use Livewire\Attributes\Layout;

new class extends \Livewire\Component {
    #[Layout('layouts.store')]

    public function with() {
        return [
            'recentOrder' => Order::where('user_id', auth()->id())->latest()->first(),
            'wishlistCount' => Wishlist::where('user_id', auth()->id())->count()
        ];
    }
}; ?>

<div class="grid md:grid-cols-2 gap-12">
    {{-- Recent Order Card --}}
    <div class="bg-zinc-50 p-10 space-y-6">
        <h3 class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-200 pb-2">Recent Order</h3>
        @if($recentOrder)
            <div class="space-y-4">
                <p class="text-xl font-serif tracking-tight">Status: {{ ucfirst($recentOrder->status) }}</p>
                <p class="text-xs text-zinc-500">Order #{{ $recentOrder->id }} placed on {{ $recentOrder->created_at->format('M d, Y') }}</p>
                <flux:button href="/account/orders" variant="ghost" class="uppercase text-[9px] tracking-widest underline p-0">Track Order</flux:button>
            </div>
        @else
            <p class="text-sm text-zinc-400 italic">No recent orders found.</p>
        @endif
    </div>

    {{-- Wishlist Summary --}}
    <div class="border border-zinc-100 p-10 space-y-6">
        <h3 class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-100 pb-2">Your Collection</h3>
        <div class="space-y-4">
            <p class="text-xl font-serif tracking-tight">{{ $wishlistCount }} Items Saved</p>
            <p class="text-xs text-zinc-500">Your curated selection of molecular skincare.</p>
            <flux:button href="/account/wishlist" variant="ghost" class="uppercase text-[9px] tracking-widest underline p-0">View Favorites</flux:button>
        </div>
    </div>
</div>