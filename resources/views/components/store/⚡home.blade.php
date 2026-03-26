<?php
use App\Models\Carousel;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;



new class extends Component
{
    #[Layout('layouts.store')]
    public function with() {
        return [
            'featured' => Product::get(),
            'carousels' => Carousel::get()
        ];
    }
};
?>

<div>
    <x-store.slider :carousels="$carousels"/>
    <x-store.featured :featured="$featured"/>
</div>