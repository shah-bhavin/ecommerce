<?php

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;



new class extends Component
{   
    use App\Concerns\WishListTrait;

    #[Layout('layouts.store')]    
    public function with() {
        return [
            'products' => Product::get(),
            'categories' => Category::get(),
            'carousels' => Carousel::get()
        ];
    }
};
?>

{{--<div>
    <x-store.slider :carousels="$carousels"/>
    <x-store.categories :categories="$categories"/>
    <x-store.featured :products="$products"/>
</div>--}}

<div>
    <x-store.slider :carousels="$carousels"/>
    <x-store.products :products="$products"/>
    <x-store.about />
</div>
    


