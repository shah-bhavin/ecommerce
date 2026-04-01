<div class="space-y-12 w-full">
    <div class="flex justify-between items-end border-b border-zinc-100 pb-6">
        <h1 class="text-3xl font-serif italic">My Orders</h1>
        <h6 class="text-[10px] text-zinc-400 uppercase tracking-widest">{{ $orders ? 'Total Orders: ' .$orders->count() : 'No Orders Yet...' }} </h6>
    </div>

    <div class="space-y-8">
        @forelse($orders as $order)
            <div class="border border-zinc-100 p-8 space-y-8 hover:shadow-xl hover:shadow-zinc-100 transition-all duration-500">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Order Reference</p>
                        <h3 class="text-lg font-mono">#{{ $order->order_number }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Status</p>
                        <flux:badge variant="outline" size="sm" class="uppercase text-[9px] rounded-none px-4">
                            {{ $order->status }}
                        </flux:badge>
                    </div>
                </div>

                <div class="relative pt-4">
                    <div class="h-[1px] w-full bg-zinc-100 absolute top-1/2 -translate-y-1/2"></div>
                    <div class="flex justify-between relative z-10">
                        @foreach(['Processing', 'Shipped', 'Delivered'] as $step)
                            <div class="bg-white px-2 flex flex-col items-center">
                                <div class="size-2 rounded-full border border-black {{ $order->status == strtolower($step) ? 'bg-black' : 'bg-white' }}"></div>
                                <span class="text-[8px] uppercase tracking-widest mt-2 text-zinc-400">{{ $step }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 flex justify-between items-center border-t border-zinc-50">
                    <div class="flex -space-x-4">
                        @foreach($order->items->take(3) as $item)
                            <img src="{{ asset('storage/'.$item->product->image) }}" class="size-12 rounded-full border-2 border-white object-cover bg-zinc-50">
                        @endforeach
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-zinc-500">Amount Paid</p>
                        <p class="text-lg font-serif">₹{{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center border border-dashed border-zinc-200">
                <p class="text-zinc-400 italic">You haven't placed any orders yet.</p>
            </div>
        @endforelse
    </div>
</div>