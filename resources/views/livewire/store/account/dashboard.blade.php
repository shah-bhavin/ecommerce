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

<div>

    {{--<div class="max-w-7xl mx-auto px-6 py-12">
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
    </div>--}}


    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row! gap-12">
            <!-- Left Sidebar -->
            <aside class="w-64">
                <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] mb-6 pb-2">Welcome, {{ $this->user->name }}</h4>
                <nav class="space-y-2">
                    <a href="/account/overview" wire:navigate
                        class="flex items-center justify-between w-full p-2 {{ $view === 'overview' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-user class="w-5 h-5 text-gray-500" />
                            Account Overview
                        </span>
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
                    </a>
                    
                    <a href="/account/wishlist" wire:navigate
                        class="flex items-center justify-between w-full p-2 {{ $view === 'wishlist' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}" icon="heart" icon:trailing="chevron-right">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-heart class="w-5 h-5 text-gray-500" />
                            Wishlist
                        </span>
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
                    </a>
                    
                    <a href="/account/orders" wire:navigate
                        class="flex items-center justify-between w-full p-2 {{ $view === 'orders' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-shopping-bag class="w-5 h-5 text-gray-500" />
                            Orders
                        </span>
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
                    </a>

                    <a href="/account/profile" wire:navigate
                        class="flex items-center justify-between w-full p-2 {{ $view === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-users class="w-5 h-5 text-gray-500" />
                            Profile
                        </span>
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
                    </a>

                    <a href="{{ route('logout') }}" wire:navigate
                        class="curser-pointer flex items-center justify-between w-full p-2">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-users class="w-5 h-5 text-gray-500" />
                            Logout
                        </span>
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
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


</div>
