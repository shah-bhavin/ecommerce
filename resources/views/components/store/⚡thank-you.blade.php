<?php
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;


new class extends Component
{
    #[Layout('layouts.store')]
    public function with() {
        return [
            'featured' => Product::get()
        ];
    }
};
?>

<div class="max-w-2xl mx-auto px-6 py-32 text-center space-y-8">
    <flux:icon.check-circle class="mx-auto text-emerald-600 size-16" />
    <h1 class="text-5xl font-serif italic">Thank You for your Order.</h1>
    <p class="text-zinc-500 font-light leading-relaxed">Your order #LS-9823 has been received and is currently being prepared for shipping.</p>
    <flux:button href="/collection" variant="ghost" class="uppercase text-[10px] tracking-widest border border-black px-12 h-14 rounded-none">Continue Shopping</flux:button>
</div>