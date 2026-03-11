<?php
use App\Models\Order;
use Livewire\Component;

new class extends Component
{
    public $showModal = false;
    public $selectedOrder;
    public $newStatus;

    public function viewOrder($id) {
        $this->selectedOrder = Order::with(['items.product', 'user', 'address'])->find($id);
        $this->newStatus = $this->selectedOrder->status;
        $this->showModal = true;
    }

    public function updateStatus() {
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
            @foreach(Order::with('user')->latest()->get() as $order)
                <flux:table.row>
                    <flux:table.cell class="font-mono text-indigo-600">{{ $order->order_number }}</flux:table.cell>
                    <flux:table.cell>{{ $order->user->name }}</flux:table.cell>
                    <flux:table.cell>₹{{ number_format($order->total_amount, 2) }}</flux:table.cell>
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

    <flux:modal wire:model="showModal" flyout>
        @if($selectedOrder)
            <div class="space-y-6">
                <flux:heading size="lg">Order Details: {{ $selectedOrder->order_number }}</flux:heading>
                
                <div class="grid grid-cols-2 gap-4 text-sm rounded-lg">
                    <div>
                        <p class="text-zinc-500 italic">Shipping to:</p>
                        <p class="font-bold">{{ $selectedOrder->address->fullname }}</p>
                        <p>{{ $selectedOrder->address->house_no }}, {{ $selectedOrder->address->city }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-zinc-500 italic">Payment Status:</p>
                        <p class="font-bold uppercase">{{ $selectedOrder->payment_status }}</p>
                    </div>
                </div>

                <flux:separator />

                <div class="space-y-2">
                    @foreach($selectedOrder->items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span class="font-mono">₹{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</span>
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