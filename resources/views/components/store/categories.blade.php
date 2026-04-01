@if($categories->isNotEmpty())
<section class="py-8 max-w-7xl mx-auto px-6">
    <div class="flex justify-center items-end mb-16 text-center">
        <h2 class="text-2xl font-serif uppercase text-center">Top Categories</h2>
    </div>

    <div class="grid md:grid-cols-6 gap-4 overflow-hidden">
        @foreach($categories as $category)
            <a href="/category/{{ $category->slug }}" class="group block space-y-6">
                <div class="aspect-[4/5] overflow-hidden relative">
                    <img src="{{ asset('storage/'.$category->image) }}" class="w-full h-full object-cover transition-transform duration-[1.5s] bg-zinc-50 group-hover:scale-110 rounded-xl">
                </div>
                <div class="text-center">
                    <h3 class="font-serif mb-2 uppercase font-light tracking-wide text-base]">{{ $category->name }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif