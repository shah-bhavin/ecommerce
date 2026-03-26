<?php

use Livewire\Component;

new class extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function getCount() {
        return array_sum(array_column(session()->get('cart', []), 'quantity'));
    }
};
?>

<a href="/cart" class="relative group">
    <flux:icon.shopping-cart class="group-hover:text-zinc-500 transition-colors" />
    @if($this->getCount() > 0)
        <span class="absolute -top-2 -right-2 bg-black text-white text-[8px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
            {{ $this->getCount() }}
        </span>
    @endif
</a>