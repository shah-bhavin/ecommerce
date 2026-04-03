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

<a href="/cart" class="relative group text-white hover:text-amber-400">
    <span class="material-symbols-outlined h-5" data-icon="shopping_bag">shopping_bag</span>
    @if($this->getCount() > 0)
        <span class="absolute -top-2 -right-2 bg-black text-white text-[8px] h-4 rounded-full flex items-center justify-center font-bold">
            {{ $this->getCount() }}
        </span>
    @endif
</a>