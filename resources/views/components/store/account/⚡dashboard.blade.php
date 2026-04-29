<?php

use App\Models\{Order, Wishlist, Address};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Concerns\WishListTrait;
use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    public $user;
    public $url;
    public $view = 'overview'; // Default view
    public $current_password;
    public $new_password;
    use WishListTrait;

    // Address Properties
    public $house_no, $area, $landmark, $pincode, $type, $is_default, $address_id, $fullname, $phone, $street, $city;
    public $isEditing = false;

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
        $addresses = Address::where('user_id', $user->id)->latest()->get();
        $wishlists = Wishlist::with('product')->where('user_id', $user->id)->get();

        return [
            'orders'        => $orders,
            'addresses'        => $addresses,
            'orderscount'   => $orders->count(),
            'recentOrder'   => $orders->first(), // already sorted by latest()
            'wishlists'     => $wishlists,
            'wishlistCount' => $wishlists->count(),
        ];

    }

    public function updatePassword() {
        $this->validate([
            'current_password' => 'required|current_password', 
            'new_password' => 'required|min:8'
        ]);

        Auth::user()->update(['password' => Hash::make($this->new_password)]);
        $this->reset(['current_password', 'new_password']);
        $this->dispatch('toast', 
            type: 'success', 
            text: 'Password Changed'
        );
    }

    //addresses
    public $confirmingDelete = false;
    public $addressToDelete = null;

    public function confirmDelete($id) {
        $this->addressToDelete = $id;
        $this->confirmingDelete = true;
    }
    public function deleteAddress() {
        Address::where('user_id', auth()->id())->findOrFail($this->addressToDelete)->delete();
        $this->confirmingDelete = false;
        $this->addressToDelete = null;
        $this->dispatch('toast', type: 'success', text: 'Address removed');
    }
    public function saveAddress() {
        $data = $this->validate([
            'fullname' => 'required|string',
            'phone' => 'required',
            'city' => 'required',
            'house_no' => 'required',
            'type' => 'required',
            'area' => 'required',
            'landmark' => '',
            'pincode' => 'required',
            'is_default' => 'required',
        ]);

        if ($this->isEditing) {
            Address::where('user_id', Auth::id())->findOrFail($this->address_id)->update($data);
            $text = 'Address updated';
        } else {
            Address::create(array_merge($data, ['user_id' => Auth::id()]));
            $text = 'Address added';
        }

        $this->resetAddressForm();
        $this->dispatch('toast', type: 'success', text: $text);
    }

    public function editAddress($id) {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);
        $this->address_id = $address->id;
        $this->fullname = $address->fullname;
        $this->phone = $address->phone;
        $this->house_no = $address->house_no;
        $this->area = $address->area;
        $this->landmark = $address->landmark;
        $this->pincode = $address->pincode;
        $this->type = $address->type;
        $this->is_default = $address->is_default;
        $this->city = $address->city;
        $this->isEditing = true;
    }

    public function resetAddressForm() {
        $this->reset(['house_no', 'area', 'landmark', 'pincode', 'type', 'is_default', 'fullname', 'phone', 'street', 'city', 'address_id', 'isEditing']);
    }

    public function downloadInvoice($orderId)
    {
        $order = Order::with(['user', 'items', 'address'])->where('order_number', $orderId)->firstOrFail();

        // Security: Ensure users can only download their own invoices
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "invoice-{$order->order_number}.pdf");
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
                    <span class="flex items-center gap-2 body-text">
                        <x-lucide-home class="w-4 h-4 text-gray-500" />
                        Account Overview
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>
                
                <a href="/account/orders" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'orders' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2 body-text">
                        <x-lucide-shopping-bag class="w-4 h-4 text-gray-500" />
                        Order History
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>

                <a href="/account/addresses" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'addresses' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2 body-text">
                        <x-lucide-map-pin-house class="w-4 h-4 text-gray-500" />
                        Adress
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>

                <a href="/account/wishlist" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'wishlist' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}" icon="heart" icon:trailing="chevron-right">
                    <span class="flex items-center gap-2 body-text">
                        <x-lucide-heart class="w-4 h-4 text-gray-500" />
                        Wishlist
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>   
                

                <a href="/account/profile" wire:navigate
                    class="flex items-center justify-between w-full p-2 {{ $view === 'profile' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                    <span class="flex items-center gap-2 body-text">
                        <x-lucide-users class="w-4 h-4 text-gray-500" />
                        Profile
                    </span>
                    <x-lucide-chevron-right class="w-4 h-4 text-gray-500" />
                </a>

                <a href="{{ route('logout') }}" wire:navigate
                    class="curser-pointer flex items-center justify-between w-full p-2">
                    <span class="flex items-center gap-2 body-text">
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
            @elseif($view === 'orders')
                <x-store.account.orders :orders="$orders"/>
            @elseif($view === 'addresses')
                <x-store.account.addresses :addresses="$addresses" :isEditing="$isEditing" :confirmingDelete="$confirmingDelete"/>
            @elseif($view === 'wishlist')
                <x-store.account.wishlist :wishlists="$wishlists" :wishlistCount="$wishlistCount"/>            
            @elseif($view === 'profile')
                <x-store.account.profile />
            @endif
        </main>
    </div>
</div>
