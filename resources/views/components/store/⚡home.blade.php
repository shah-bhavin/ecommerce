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
    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center overflow-hidden pt-20">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover" data-alt="High-fashion editorial portrait of a woman with radiant skin in soft golden hour Dubai desert light, warm tones and luxury aesthetic" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ7NIg4tILQQSePd7qGi8IBTs90PLqd5Etgb511Yzv1mYtWnTZLh1zoAYEIBM1f_FlOlwonKh4caz60yfqFnUvBMJ_V4pD9hOI7CacYmu0tuzQdvpCvn4tHtT-hFjOF-YQJSbn-r9mUbUGib12cJoPDScShQKEdcZNQGPlE7Xf5llaZzCdYKCZwflt9722WPWCyFT3wL8oHHxU07lKTx7hGNjSJmNL8BDltpks3rE8F2k1dOt_-3KMuQOLGH7EVHTBnUI6JOZugVPD" />
            <div class="absolute inset-0 bg-linear-to-r from-primary/40 to-transparent"></div>
        </div>
        <div class="container mx-auto px-12 relative z-10">
            <div class="max-w-2xl">
                <span class="block text-secondary font-label uppercase tracking-[0.3em] mb-6 text-sm">Dubai's Signature Glow</span>
                <h1 class="text-white font-headline text-7xl md:text-8xl leading-tight tracking-tight editorial-text-shadow mb-8">
                    The Monolith <br />of Purity.
                </h1>
                <p class="text-white/90 text-lg md:text-xl font-light mb-12 max-w-lg leading-relaxed">
                    Sculpted by the desert, refined by science. Discover a ritual that transcends traditional skincare.
                </p>
                <div class="flex gap-6">
                    <button class="px-10 py-5 bg-linear-to-br from-primary to-primary-container text-white font-label tracking-widest uppercase text-xs hover:opacity-90 transition-all duration-400">
                        Explore Collection
                    </button>
                    <button class="px-10 py-5 border border-white/30 text-white font-label tracking-widest uppercase text-xs backdrop-blur-sm hover:bg-white hover:text-primary transition-all duration-400">
                        Our Ritual
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- Trust Badges -->
    <section class="bg-surface-container-low py-12">
        <div class="container mx-auto px-12 flex flex-wrap justify-center gap-16 md:gap-32">
            <div class="flex items-center gap-4 group">
                <span class="material-symbols-outlined text-secondary text-4xl" data-icon="location_on">location_on</span>
                <span class="font-label text-xs tracking-[0.2em] uppercase text-on-surface-variant group-hover:text-secondary transition-colors">Made in Dubai</span>
            </div>
            <div class="flex items-center gap-4 group">
                <span class="material-symbols-outlined text-secondary text-4xl" data-icon="eco">eco</span>
                <span class="font-label text-xs tracking-[0.2em] uppercase text-on-surface-variant group-hover:text-secondary transition-colors">Organic Ingredients</span>
            </div>
            <div class="flex items-center gap-4 group">
                <span class="material-symbols-outlined text-secondary text-4xl" data-icon="auto_awesome">auto_awesome</span>
                <span class="font-label text-xs tracking-[0.2em] uppercase text-on-surface-variant group-hover:text-secondary transition-colors">Clinical Efficacy</span>
            </div>
        </div>
    </section>
    <!-- Product Grid (Asymmetric) -->
    <section class="py-32 container mx-auto px-12">
        <div class="flex flex-col md:flex-row items-end justify-between mb-20 gap-8">
            <div class="max-w-xl">
                <h2 class="text-primary font-headline text-5xl mb-6">Desert Essentials</h2>
                <p class="text-on-surface-variant leading-relaxed">Formulated for the extreme climate of the Emirates, our signature line balances hydration and protection with uncompromising luxury.</p>
            </div>
            <a class="font-label text-xs uppercase tracking-[0.2em] text-secondary border-b border-secondary pb-1" href="#">View All Products</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
            <!-- Product 1: Sunscreen -->
            <div class="md:col-span-7 group">
                <div class="relative overflow-hidden aspect-[4/5] bg-surface-container-highest mb-8">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Luxury sunscreen bottle on a marble pedestal, dramatic shadows, warm desert aesthetic, high-end packaging design" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAoSPZfgA8xjoe_kMOJW1A6eQb03XUQQpOfoq7yGBvpTMhePcfOEOANs90EyJMOsR-C_WmBxMdt9JEDfM3LDjwG74_L8mqCa7SsqmAnRvUk8hI2VReFJPj9ms_gBST-8qf1OT4qxor_TA433qM6HTnJP39eZXZuMZC9TphdPpG_W1k0anE4b0vnOcHQ2RCTwXy6AGo_xm1HvB8czFtr7Iu04HxlNJtfeV4Weiz_azXIjzPcsBW83klhw_wOfGEm8sEAgl4YvFhz32Fi" />
                    <div class="absolute bottom-6 right-6">
                        <button class="bg-white/90 backdrop-blur p-4 shadow-xl hover:bg-primary hover:text-white transition-colors duration-400">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline text-2xl text-on-surface mb-2 italic">Solar Sanctuary SPF 50</h3>
                        <p class="font-label text-xs text-on-surface-variant uppercase tracking-widest">Hydrating Shield</p>
                    </div>
                    <span class="font-headline text-xl text-primary">AED 245</span>
                </div>
            </div>
            <!-- Product 2: Facewash -->
            <div class="md:col-span-5 md:mt-24 group">
                <div class="relative overflow-hidden aspect-[4/5] bg-surface-container-highest mb-8">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Elegant face wash glass bottle with golden pump, placed near splashing water and desert stones, soft morning light" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2bfaEh5I6QnJMNOwsry1wqmyDMNB-jw9_0r-sJgYrSsQMItRDk9nMjkbh4IMXqQkYizs_fAPyGdc75tIKPmzwoBJUX9MwGJF1ny3D5J8GG-FKduTYS8b9md-kieygvUZJSitJOlcrCWiWI1BRDPQoNVXwpQxGbmh2HGN8Q5JD7VFO_nbMFWyqy0WHDVkJaJwLspLcyUDJjVdgKGYI-TU7F_urf-n6yUepDAiYOY8A0hJt9SIRGEj0boODKFNhm3R-Fj_7QynjVC89" />
                    <div class="absolute bottom-6 right-6">
                        <button class="bg-white/90 backdrop-blur p-4 shadow-xl hover:bg-primary hover:text-white transition-colors duration-400">
                            <span class="material-symbols-outlined" data-icon="add">add</span>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline text-2xl text-on-surface mb-2 italic">Dune Purifier</h3>
                        <p class="font-label text-xs text-on-surface-variant uppercase tracking-widest">Gentle Cleansing Silk</p>
                    </div>
                    <span class="font-headline text-xl text-primary">AED 180</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Ritual / Story Section -->
    <section class="py-32 bg-surface-container-low overflow-hidden">
        <div class="container mx-auto px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="relative">
                    <div class="aspect-[3/4] overflow-hidden relative z-10">
                        <img class="w-full h-full object-cover" data-alt="Hands applying luxury cream to skin, macro shot, warm lighting, focus on texture and radiance, gold jewelry accents" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVsx9hVriGd4CeGXDKT4y3HnIH5GAJO7arEsBz_Jr4s0dkvqMNvYcZqDJjplEkz6aDeWkAE-eQS7eIJ1hXAW0qU3n6JrWPW82z3784NI3Hnc9PVpWYEQDclgKOPU9hhmVcC-gemp8Fx4pDDIsFxuepUpMG8OdH1-eBSHrwDEZhij3_ELsiaqkh4NQtsUyDumZx38hm0XscWXXuaN7HkE8GPY3SNgqS8AtdZxT9-zvMdJJPXR0aDMl1v4XFip2xIgRF2IjMasYDdz6P" />
                    </div>
                    <div class="absolute -bottom-12 -right-12 w-64 h-80 bg-primary/10 -z-10"></div>
                    <div class="absolute top-12 -left-12 w-48 h-48 border border-secondary/20 -z-10"></div>
                </div>
                <div class="max-w-lg">
                    <span class="font-label text-xs uppercase tracking-[0.4em] text-secondary mb-8 block">The Philosophy</span>
                    <h2 class="font-headline text-5xl md:text-6xl text-primary mb-10 leading-tight">The Ritual of Radiant Light.</h2>
                    <div class="space-y-6 text-on-surface-variant leading-relaxed text-lg font-light">
                        <p>Radiant was born under the eternal sun of Dubai, where light is both a challenge and an inspiration. Our ritual is not merely about application; it is an architectural approach to skin health.</p>
                        <p>By blending rare botanical extracts with modern molecular delivery systems, we create a sanctuary for your skin. Every drop is a testament to the resilience of the desert rose and the opulence of the Arabian spirit.</p>
                    </div>
                    <div class="mt-12">
                        <a class="inline-flex items-center gap-4 group" href="#">
                            <span class="w-12 h-[1px] bg-secondary group-hover:w-20 transition-all duration-500"></span>
                            <span class="font-label text-xs uppercase tracking-[0.2em] text-secondary">Read Our Story</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
    


