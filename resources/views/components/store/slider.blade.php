{{-- Hero Section --}}  

@if($carousels->isNotEmpty())
    <section id="carousel-example" class="relative w-full carousel" data-carousel="static">

        <div class="relative h-[400px] md:h-[700px] overflow-hidden">
            @foreach($carousels as $carousel)
            <div class="hidden duration-700 ease-linear" data-carousel-item="active">
                <img src="{{ asset('storage/' . $carousel->image_path) }}" class="absolute block w-full h-full object-cover">

                <!-- <div class="absolute inset-0 bg-black/40"></div> -->

                <div class="absolute inset-0 flex flex-col justify-center px-8 pl-20 w-1/2 gap-4">
                    <h3 class="mb-4 uppercase">{{ $carousel->title }}</h3>
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
            <flux:icon.chevron-double-left />
        </button>

        <button type="button" class="absolute top-1/2 right-4 z-30 control-button" data-carousel-next>
            <flux:icon.chevron-double-right />
        </button>

    </section>
@endif