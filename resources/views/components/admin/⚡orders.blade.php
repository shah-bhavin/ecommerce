<?php

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Defer; 

new class extends Component
{
    public $showModal = false;
    public $selectedOrder;
    public $newStatus;

    public function mount()
    {

    }

    #[Computed] // 👈 Mark as computed
    public function orders()
    {
        return Order::with(['items.product', 'user', 'address'])->get();
    }
    public function viewOrder($id)
    {
        $this->selectedOrder = Order::with(['user'])->find($id);
        $this->newStatus = $this->selectedOrder->status;
        $this->showModal = true;
    }

    public function updateStatus()
    {
        $this->selectedOrder->update(['status' => $this->newStatus]);
        $this->showModal = false;
        session()->flash('message', 'Order status updated to ' . $this->newStatus);
    }
};
?>

<div>
    <flux:heading size="xl" class="mb-6">Order Management</flux:heading>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Order #</flux:table.column>
            <flux:table.column>Customer</flux:table.column>
            <flux:table.column>Total</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->orders as $order)
            <flux:table.row>
                <flux:table.cell class="font-mono text-indigo-600">{{ $order->order_number }}</flux:table.cell>
                <flux:table.cell>{{ $order->user->name }}</flux:table.cell>
                <flux:table.cell>₹{{ number_format($order->total, 2) }}</flux:table.cell>
                <flux:table.cell>
                    <flux:badge size="sm" :color="match($order->status){
                            'pending' => 'yellow',
                            'delivered' => 'green',
                            'cancelled' => 'red',
                            default => 'zinc'
                        }">{{ strtoupper($order->status) }}</flux:badge>
                </flux:table.cell>
                <flux:table.cell>
                    <flux:button wire:click="viewOrder({{ $order->id }})" variant="ghost" size="sm" icon="eye" />
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal class="w-screen" wire:model="showModal" flyout>
        @if($selectedOrder)
        <div class="space-y-6">
            <div class="flex flex-wrap items-center gap-x-4">
                <flux:text size="xs">Order Date: {{ $selectedOrder->created_at->format('jS F Y') }}</flux:text>
                <flux:separator vertical class="h-4" />
                <flux:text size="xs">Order Number: {{ $selectedOrder->order_number }}</flux:text>
            </div>

            <div class="grid grid-cols-3 gap-x-4 mb-12">
                <flux:card size="sm">
                    <p class="text-zinc-500">Shipping to:</p>
                    <p class="font-bold">{{ $selectedOrder->address->fullname }}</p>
                    <p class="text-sm">{{ $selectedOrder->address->phone }}</p>
                    <p class="text-sm">
                        {{ $selectedOrder->address->house_no }}, {{ $selectedOrder->address->area }}, {{ $selectedOrder->address->landmark }}, {{ $selectedOrder->address->city }}, {{ $selectedOrder->address->pincode }}
                    </p>
                </flux:card>
                <flux:card size="sm">
                    <p class="text-zinc-500">Payment Status:</p>
                    <p class="text-sm">{{ $selectedOrder->payment_status }}</p>
                </flux:card>
                <flux:card size="sm">
                    <flux:text size="sm" font="semibold" class="mb-3">Order Summary</flux:text>

                    <div class="space-y-2 space-x-2">
                        <!-- Subtotal -->
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Item(s) Subtotal:</span>
                            <span class="font-medium">{{ $selectedOrder->subtotal }}</span>
                        </div>

                        <!-- Shipping -->
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Shipping:</span>
                            <span class="font-medium">{{ $selectedOrder->shipping_charges }}</span>
                        </div>

                        <!-- Discount -->
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Discount:</span>
                            <span class="font-medium text-green-600">-{{ $selectedOrder->discount_amount }}</span>
                        </div>

                        <!-- Divider -->
                        <flux:separator class="my-2" />

                        <!-- Total -->
                        <div class="flex justify-between text-base font-bold">
                            <span>Total:</span>
                            <span>{{ $selectedOrder->total }}</span>
                        </div>
                    </div>
                </flux:card>

            </div>

            <flux:separator />

            <div class="space-y-2">
                @foreach($selectedOrder->items as $item)
                <div class="flex justify-between items-center text-sm">
                    <span>{{ $item->product->name }} ({{ $item->price }}x{{ $item->quantity }})</span>
                    <span class="font-mono">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
            </div>

            <div class="flex items-end gap-4 border-t pt-4">
                <flux:select wire:model="newStatus" label="Change Order Status" class="flex-1">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </flux:select>
                <flux:button wire:click="updateStatus" variant="primary">Update</flux:button>
            </div>
        </div>
        @endif
    </flux:modal>
</div>