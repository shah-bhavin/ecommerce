<?php

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

new class extends Component
{
    use App\Concerns\WishListTrait;

    #[Layout('layouts.store')]
    public function with()
    {
        return [
            'products' => Product::get(),
            'categories' => Category::get(),
            'carousels' => Carousel::get()
        ];
    }
};
?>

<div class="min-h-screen">
    <section class="relative h-[90vh] min-h-[600px] overflow-hidden bg-[#f6f5e8]">
        <div class="absolute inset-0 transition-opacity duration-1000" style="opacity: 1;"><img alt="Abrari London Hero" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1624819581070-7868475f038c">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
        <div class="absolute inset-0 transition-opacity duration-1000" style="opacity: 1;"><img alt="Abrari London Hero" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1603389722569-c0a0328f42c7">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
        <div class="absolute inset-0 transition-opacity duration-1000" style="opacity: 1;"><img alt="Abrari London Hero" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1770460882029-d19659d9c771">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
        <div class="relative z-10 h-full flex items-center justify-center text-center px-6">
            <div class="max-w-4xl fade-in-up text-white">
                <h1 class="hero-large mb-6">Redefining Beauty with Luxury and Precision</h1>
                <p class="body-large mb-10">Discover the art of refined elegance</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a class="btn-theme" href="/shop" data-discover="true">Shop Now</a>
                    <a class="btn-theme-inverse" href="/shop" data-discover="true">Explore Collection</a></div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-2"><button class="w-2 h-2 rounded-full transition-all bg-white bg-opacity-50"></button><button class="w-2 h-2 rounded-full transition-all bg-white bg-opacity-50"></button><button class="w-2 h-2 rounded-full transition-all bg-white w-8"></button></div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($categories as $category)
                <a class="group relative h-[400px] overflow-hidden hover-lift" href="shop/{{ $category->slug }}" data-discover="true">
                    <img alt="Skincare" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$category->image) }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <h3 class="heading-2 mb-2 text-white">{{ $category->name }}</h3>
                        <p class="body-regular mb-4 text-white opacity-90">{{ Str::limit($category->description, 100) }}</p>
                        <span class="inline-flex items-center gap-2 text-sm font-medium tracking-wide text-white">DISCOVER <x-lucide-arrow-right class="size-4" /></span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8]">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="hero-medium mb-6">A Vision of Timeless Elegance</h2>
                    <p class="body-large text-[#666666] leading-relaxed mb-8">Abrari was born from a simple belief:
                    a woman should never have to choose between ambition and beauty.</p>
                    <p class="body-large text-[#666666] leading-relaxed mb-8">Created by a woman, for women, Abrari knows skincare is more than a ritual.
                    It is a moment to return to yourself. A moment of power before the world asks anything of you.</p>
                    <p class="body-large text-[#666666] leading-relaxed mb-8">Because when a woman feels confident in her own skin, she moves differently.
                    She walks into rooms with certainty.
                    She builds the life she imagines — and never apologizes for wanting more.</p>
                    <a class="btn-secondary inline-block text-sm uppercase" href="{{ route('about') }}" data-discover="true">Learn More About Us</a>
                </div>
                <div class="order-1 lg:order-2"><img alt="Abrari London Brand Story" class="w-full h-[500px] object-cover hover-lift" src="https://images.unsplash.com/photo-1657928198258-1db7e50e2fd9"></div>
            </div>
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-16">
                <h2 class="hero-medium mb-4">Signature Collection</h2>
                <p class="body-large text-[#666666]">Our most coveted formulations</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                @foreach($products->random(5) as $product)
                <a class="group" href="/product/{{ $product->slug }}" data-discover="true">
                    <div class="mb-4 overflow-hidden hover-lift">
                        <img alt="Luminous Facial Serum" class="w-full h-[280px] object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/'.$product->image) }}">
                    </div>
                    <h3 class="heading-3 mb-2 group-hover:text-[#000000] transition-colors">{{ $product->name }}</h3>
                    <p class="body-small text-[#666666] mb-3 line-clamp-2">{{ $product->description }}</p>
                    <p class="body-regular font-medium">₹{{ number_format($product->price, 2) }}</p>
                </a>
                @endforeach
            </div>
            <div class="text-center mt-12"><a class="btn-theme" href="/shop" data-discover="true">View All Products</a></div>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8]">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-16">
                <h2 class="hero-medium mb-4">The Abrari Difference</h2>
                <p class="body-large text-[#666666]">Uncompromising excellence in every detail</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center border border-[#333333] text-2xl font-light" style="font-family: &quot;Cormorant Garamond&quot;, serif;">1</div>
                    <h3 class="heading-3 mb-3">Premium Ingredients</h3>
                    <p class="body-regular text-[#666666]">Sourced from the finest suppliers worldwide, each ingredient is carefully selected for its efficacy and purity.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center border border-[#333333] text-2xl font-light" style="font-family: &quot;Cormorant Garamond&quot;, serif;">2</div>
                    <h3 class="heading-3 mb-3">International Standards</h3>
                    <p class="body-regular text-[#666666]">Formulated in world-class laboratories, meeting rigorous quality and safety standards across Europe and the Middle East.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center border border-[#333333] text-2xl font-light" style="font-family: &quot;Cormorant Garamond&quot;, serif;">3</div>
                    <h3 class="heading-3 mb-3">Modern Sophistication</h3>
                    <p class="body-regular text-[#666666]">Designed for the discerning individual who values both timeless elegance and contemporary innovation.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center border border-[#333333] text-2xl font-light" style="font-family: &quot;Cormorant Garamond&quot;, serif;">4</div>
                    <h3 class="heading-3 mb-3">Luxury Experience</h3>
                    <p class="body-regular text-[#666666]">Every product is a masterpiece of design and performance, delivering an unparalleled beauty ritual.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="hero-medium mb-4">Join Our World</h2>
                <p class="body-large text-[#666666]">@abrarilondon</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4"><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 1" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.pexels.com/photos/6357475/pexels-photo-6357475.jpeg">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 2" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.pexels.com/photos/965990/pexels-photo-965990.jpeg">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 3" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1567169102475-a4a93aa6d71a">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 4" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1603389722569-c0a0328f42c7">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 5" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1622618991227-412b19e4fef9">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a><a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="group relative aspect-square overflow-hidden hover-lift"><img alt="Instagram 6" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1654973433534-1238e06f6b38">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a></div>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8]">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="hero-medium mb-4">Join Our Community</h2>
            <p class="body-large text-[#666666] mb-10">Be the first to discover new launches, exclusive offers, and beauty insights</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto"><input placeholder="Enter your email" required="" class="flex-1 px-6 py-4 border border-[#bcbbb4] bg-transparent text-[#333333] placeholder-[#bcbbb4] focus:outline-none focus:border-[#333333] transition-colors" type="email" value="" style="border-radius: 0px; font-family: Inter, sans-serif; font-size: 14px;"><button type="submit" class="btn-theme">Subscribe</button></form>
        </div>
    </section>
</div>