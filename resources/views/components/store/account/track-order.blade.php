<?php
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public Order $order;

    public function mount($id) {
        $this->order = Order::where('user_id', Auth::id())->findOrFail($id);
    }
}; ?>

<div class="max-w-3xl mx-auto py-20 px-6">
    <div class="text-center mb-12">
        <p class="text-[10px] uppercase tracking-widest text-zinc-400">Tracking Order</p>
        <h1 class="text-4xl font-serif italic">#{{ $order->id }}</h1>
    </div>

    {{-- Progress Visual --}}
    <div class="relative h-2 bg-zinc-100 rounded-full mb-20">
        @php 
            $progress = match($order->status) {
                'pending' => '10%',
                'processing' => '40%',
                'shipped' => '75%',
                'delivered' => '100%',
                default => '0%'
            };
        @endphp
        <div class="absolute h-full bg-black transition-all duration-1000" style="width: {{ $progress }}"></div>
        
        <div class="absolute -top-10 left-0 text-[9px] uppercase tracking-widest">Ordered</div>
        <div class="absolute -top-10 right-0 text-[9px] uppercase tracking-widest">Delivered</div>
    </div>

    <div class="space-y-6">
        @foreach($order->items as $item)
            <div class="flex justify-between items-center py-4 border-b border-zinc-50">
                <span class="text-sm">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                <span class="font-bold">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
            </div>
        @endforeach
    </div>
</div>