<div class="space-y-12 w-full">
    <div class="flex justify-between items-baseline border-b border-zinc-300 py-3">
        <h3 class="text-lg uppercase font-bold text-brand-dark font-inter">Details</h3>
        <h6 class="text-sm text-brand-muted font-inter">
            {{ $orders ? 'Total Orders: ' .$orders->count() : 'No Orders Yet...' }}
        </h6>
    </div>


    <div class="space-y-8">
        @forelse($orders as $order)
            

            <div class="group bg-white border border-zinc-200 rounded-lg p-6 space-y-6 hover:shadow-md transition-all duration-300">

                <!-- Top Section -->
                <div class="flex justify-between items-start">

                    <!-- Left -->
                    <div class="space-y-1">
                        <h2 class="text-sm font-semibold text-zinc-800">
                            #{{ $order->order_number }}
                        </h2>

                        <!-- Status -->
                        <span class="inline-flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 rounded-full 
                            {{ $order->status == 'delivered' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $order->status == 'processing' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $order->status == 'pending' ? 'bg-zinc-100 text-zinc-500' : '' }}">
                            
                            <span class="size-1.5 rounded-full bg-current"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-1">
                        <a href="{{ route('invoice.view', $order->order_number) }}" 
                        target="_blank"
                        class="p-1.5 rounded-md border border-zinc-200 hover:bg-zinc-50 transition">
                            <x-lucide-eye class="size-3.5 text-zinc-600"/>
                        </a>

                        <button wire:click="downloadInvoice('{{ $order->order_number }}')" 
                            class="p-1.5 rounded-md border border-zinc-200 hover:bg-zinc-50 transition cursor-pointer">
                            <x-lucide-file-down class="size-3.5 text-zinc-600"/>
                        </button>
                    </div>
                </div>

                <!-- Progress -->
                <div class="space-y-2">
                    <div class="flex justify-between text-[9px] uppercase tracking-widest text-zinc-400">
                        <span>Processing</span>
                        <span>Shipped</span>
                        <span>Delivered</span>
                    </div>

                    <div class="relative h-[3px] bg-zinc-200 rounded-full overflow-hidden">
                        @php
                            $progress = match($order->status) {
                                'processing' => '33%',
                                'shipped' => '66%',
                                'delivered' => '100%',
                                default => '10%',
                            };
                        @endphp

                        <div class="h-full bg-brand-dark transition-all duration-500" style="width: {{ $progress }}"></div>
                    </div>
                </div>

                <!-- Bottom -->
                <div class="flex justify-between items-center pt-3 border-t border-zinc-100">

                    <!-- Items -->
                    <div class="flex -space-x-2">
                        @foreach($order->items->take(3) as $item)
                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                class="size-8 rounded-full border-2 border-white object-cover">
                        @endforeach
                    </div>

                    <!-- Amount -->
                    <div class="text-right">
                        <p class="text-[9px] uppercase tracking-widest text-zinc-400">Amount</p>
                        <p class="text-sm font-semibold text-zinc-800">
                            ₹{{ number_format($order->total, 2) }}
                        </p>
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