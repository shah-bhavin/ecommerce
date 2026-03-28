<?php
use App\Models\{Order, Wishlist};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

new class extends \Livewire\Component {
    public $user;
    public $url;
    public $view = 'overview'; // Default view

    public function mount($url=null){
        $this->user = Auth::user();
        $this->url = $url;
    }

    public function setCategory($type){
        $this->view = $type;
    }

    #[Layout('layouts.store')]
    public function with() {
        $user = auth()->user();

        // Fetch the base collections once
        $orders = Order::where('user_id', $user->id)->latest()->get();
        $wishlists = Wishlist::with('product')->where('user_id', $user->id)->get();

        return [
            'orders'        => $orders,
            'orderscount'   => $orders->count(),
            'recentOrder'   => $orders->first(), // already sorted by latest()
            'wishlists'     => $wishlists,
            'wishlistCount' => $wishlists->count(),
        ];

    }
}; ?>


<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row! gap-12">
        <aside class="w-full md:w-64! space-y-10 shrink-0">
            <div>
                <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] mb-6 border-b border-zinc-100 pb-2">Welcome, {{ $this->user->name }}</h4>
                <div class="flex flex-col gap-24">                
                    <!-- Inside your sidebar (Flux UI) -->
                    <flux:navlist class="flex flex-col gap-4">
                        <flux:navlist.item href="/account/overview" wire:navigate :current="$view === 'overview'" icon="user" icon:trailing="chevron-right"> Account Overview</flux:navlist.item>                        

                        <flux:navlist.item href="/account/wishlist" wire:navigate :current="$view === 'wishlist'" icon="heart" icon:trailing="chevron-right">Wishlist</flux:navlist.item>

                        <flux:navlist.item href="/account/orders" wire:navigate :current="$view ==='orders'" icon="shopping-bag" icon:trailing="chevron-right">Orders</flux:navlist.item>

                        <flux:navlist.item href="/account/profile" wire:navigate :current="$view === 'profile'" icon="user" icon:trailing="chevron-right"> Profile</flux:navlist.item>

                        <flux:navlist.item href="{{ route('logout') }}" wire:navigate :current="$view === 'logout'" icon="user" icon:trailing="chevron-right"> Logout</flux:navlist.item>
                    </flux:navlist>

                </div>
            </div>        
        </aside>
        @if($view === 'overview')
            <x-store.account.overview :orderscount="$orderscount" :user="$user"/>
        @elseif($view === 'wishlist')
            <x-store.account.wishlist :wishlists="$wishlists" :wishlistCount="$wishlistCount"/>
        @elseif($view === 'orders')
            <x-store.account.orders :orders="$orders"/>
        @elseif($view === 'profile')
            <x-store.account.profile />
        @endif       
    </div>
</div>