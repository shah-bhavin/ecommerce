<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function getCount() {
        return array_sum(array_column(session()->get('cart', []), 'quantity'));
    }
};
?>
<span class="absolute -top-1.5 -right-2 bg-black text-white text-[9px] size-4 rounded-full flex items-center justify-center font-bold shadow-sm border border-white transition-all transform scale-110">
    @if($this->getCount() > 0)
        {{ $this->getCount() }}
    @endif
</span>
