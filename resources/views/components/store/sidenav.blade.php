<div id="sidebar-example" class="fixed top-0 left-0 z-[9999] h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white! w-4/5 md:w-96!" tabindex="-1">
    <div class="flex items-center justify-between cursor-pointer">
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="logo h-[50px]"></a>
    
        <button type="button" data-drawer-hide="sidebar-example" aria-controls="main-sidebar" >
            <x-heroicon-o-x-mark class="w-5 h-5 text-gray-500" />
        </button>
    </div>    

    <div class="py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @foreach($categories as $cat)
                <li><a href=" href="{{ route('shop', ['category' => $cat->slug]) }}" class="flex items-center rounded-lg">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>