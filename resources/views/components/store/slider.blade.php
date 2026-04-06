{{-- Hero Section --}}  

    {{--<section id="carousel-example" class="relative w-full carousel" data-carousel="static">

        <div class="relative h-[200px] md:h-[350px] overflow-hidden">
            @foreach($carousels as $carousel)
            <div class="hidden duration-700 ease-linear" data-carousel-item="active">
                <img src="{{ asset('storage/' . $carousel->image_path) }}" class="absolute block w-full h-full object-cover">
                <div class="absolute inset-0 flex flex-col justify-center px-16 w-1/2 gap-4">
                    <h3 class="mb-2 text-[17px] md:text-[24px] uppercase font-semibold">{{ $carousel->title }}</h3>
                    <p>{{ $carousel->subtitle }}</p>
                    <a href="{{ $carousel->link }}" class="carousel-button self-start">Shop Now</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- 🔹 LINE INDICATORS (CUSTOM) -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 w-[60%]">
            
            @foreach($carousels as $carousel)
            <button type="button" class="flex-1 h-[3px] bg-white/40"
                data-carousel-slide-to="{{ $loop->index }}"></button>
                
            @endforeach
        </div>


        <!-- 🔹 Controls -->
        <button type="button" data-carousel-prev class="absolute top-1/2 left-4 z-30 control-button">
            <x-heroicon-o-chevron-left class="w-5 h-5 text-gray-500" />
        </button>

        <button type="button" class="absolute top-1/2 right-4 z-30 control-button" data-carousel-next>
            <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-500" />
        </button>

    </section>--}}

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
                    <a
                    type="button"
                    class="inline-block px-10 py-5 bg-linear-to-br from-primary to-primary-container text-white font-label tracking-widest uppercase text-xs hover:opacity-90 transition-all duration-400 border-none outline-none cursor-pointer">
                    Explore Collection
                    </a>
                    <a class="px-10 py-5 border border-white/30 text-white font-label tracking-widest uppercase text-xs backdrop-blur-sm hover:bg-white hover:text-primary transition-all duration-400">
                        Our Ritual
                    </a>
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