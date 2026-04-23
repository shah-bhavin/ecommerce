<?php

use App\Models\{Order, Wishlist};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
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
};
?>

<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row! gap-12">
        <!-- Left Sidebar -->
        <aside class="w-64">
            <h4 class="text-[12px] font-bold uppercase tracking-[0.2em] mb-6 pb-2">Welcome, {{ $this->user->name }}</h4>
            <nav class="space-y-2">
                <a href="/account/overview" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <x-lucide-home class="w-4 h-4 text-gray-500" />
                        Account Overview
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>
                
                <a href="/account/wishlist" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'wishlist' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}" icon="heart" icon:trailing="chevron-right">
                    <span class="flex items-center gap-2">
                        <x-lucide-heart class="w-4 h-4 text-gray-500" />
                        Wishlist
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>
                
                <a href="/account/orders" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'orders' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <x-lucide-shopping-bag class="w-4 h-4 text-gray-500" />
                        Orders
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>

                <a href="/account/profile" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2">
                        <x-lucide-users class="w-4 h-4 text-gray-500" />
                        Profile
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>

                <a href="{{ route('logout') }}" wire:navigate
                    class="curser-pointer flex items-center justify-between w-full p-2">
                    <span class="flex items-center gap-2">
                        <x-lucide-square-arrow-right-exit class="w-4 h-4 text-gray-500" />
                        Logout
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>
            </nav>
        </aside>

        <!-- Right Content Area -->
        <main class="flex-1">                
            @if($view === 'overview')
            <x-store.account.overview :orderscount="$orderscount" :user="$user"/>
            @elseif($view === 'wishlist')
                <x-store.account.wishlist :wishlists="$wishlists" :wishlistCount="$wishlistCount"/>
            @elseif($view === 'orders')
                <x-store.account.orders :orders="$orders"/>
            @elseif($view === 'profile')
                <x-store.account.profile />
            @endif
        </main>
    </div>
</div>
