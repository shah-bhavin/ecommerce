<?php

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\{Layout, Url};

new class extends Component
{
    #[Layout('layouts.store')]
    #[Url] public $q = '';

    public function with() {
        return [
            'results' => Product::where('name', 'like', "%{$this->q}%")->get()
        ];
    }
};
?>

<div class="max-w-7xl mx-auto px-6 py-20">
    <div class="max-w-xl mx-auto mb-20">
        <flux:input wire:model.live.debounce.300ms="q" placeholder="Search our collections..." class="text-center h-16 text-2xl font-serif" />
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($results as $product)
            {{-- Re-use PLP Card Design --}}
        @endforeach
    </div>
</div>