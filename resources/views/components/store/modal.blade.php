{{-- <flux:modal name="sidebar" class="bg-white! w-4/5 md:w-24!" flyout position="left">
    <div class="space-y-6">            
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
            <flux:navlist class="w-64 mt-10">
            @foreach($categories as $cat)
                <flux:navlist.item href="{{ route('shop', ['category' => $cat->slug]) }}">{{ $cat->name }}</flux:navlist.item>
            @endforeach        
            </flux:navlist>
    </div>
</flux:modal> --}}

<div id="sidebar-example" class="fixed top-0 left-0 z-[9999] h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white! w-4/5 md:w-96!" tabindex="-1">
    <h5 class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
    <button type="button" data-drawer-hide="sidebar-example" aria-controls="main-sidebar" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://w3.org">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            <li><a href="#" class="flex items-center p-2 rounded-lg">Dashboard</a></li>
            <li><a href="#" class="flex items-center p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a></li>
        </ul>
    </div>
</div>