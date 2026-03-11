<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="p-6">
    <flux:heading size="xl" class="mb-6">Most Wishlisted Products</flux:heading>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Product</flux:table.column>
            <flux:table.column>Total Saves</flux:table.column>
            <flux:table.column>Price</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @php
                $popular = App\Models\Product::withCount('wishlists')
                    ->orderBy('wishlists_count', 'desc')
                    ->take(10)
                    ->get();
            @endphp

            @foreach($popular as $product)
                <flux:table.row>
                    <flux:table.cell>{{ $product->name }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="red" size="sm" inset="top bottom">
                            {{ $product->wishlists_count }} Hearts
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>₹{{ number_format($product->base_price) }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>