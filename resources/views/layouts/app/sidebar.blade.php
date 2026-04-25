<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900"> -->
        <flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />

            </flux:sidebar.header>

            <flux:sidebar.nav>
                
                    <flux:sidebar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                                
                <flux:sidebar.group expandable :heading="__('Marketing & Orders')" class="grid" icon="arrow-trending-up">
                    <!-- <flux:sidebar.item href="{{ route('admin.shipping') }}"  wire:navigate lazy>{{ __('Shipping') }}</flux:sidebar.item> -->
                    <flux:sidebar.item href="{{ route('admin.coupons') }}"  wire:navigate lazy>{{ __('Coupons') }}</flux:sidebar.item>
                    <flux:sidebar.item href="{{ route('admin.orders') }}"  wire:navigate lazy>{{ __('Orders') }}</flux:sidebar.item>
                    <flux:sidebar.item href="{{ route('admin.wishlist') }}"  wire:navigate lazy>{{ __('Product Wishlist') }}</flux:sidebar.item>
                    <flux:sidebar.item href="{{ route('admin.reviews') }}"  wire:navigate lazy>{{ __('Product Reviews') }}</flux:sidebar.item>
                    <flux:sidebar.item href="{{ route('admin.carousel') }}"  wire:navigate lazy>{{ __('Home Carousel') }}</flux:sidebar.item>
                </flux:sidebar.group>
                <flux:sidebar.group expandable :heading="__('Users')" class="grid" icon="user">
                    <flux:sidebar.item href="{{ route('admin.users') }}"  wire:navigate lazy>{{ __('Users') }}</flux:sidebar.item>
                    <flux:sidebar.item href="{{ route('admin.addresses') }}"  wire:navigate lazy>{{ __('User Addresses') }}</flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
            
            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.group expandable :heading="__('Catalogue')" class="grid" icon="squares-plus">
                    <flux:sidebar.item href="{{ route('admin.categories') }}"  wire:navigate lazy>{{ __('Categories') }}</flux:sidebar.item>
                    {{--<flux:sidebar.item href="{{ route('admin.brands') }}"  wire:navigate lazy>{{ __('Brands') }}</flux:sidebar.item>--}}
                    <flux:sidebar.item href="{{ route('admin.products') }}"  wire:navigate lazy>{{ __('Products') }}</flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>           

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar >

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        <x-toast />
    </body>
</html>
