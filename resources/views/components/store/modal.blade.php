<flux:modal name="sidebar" class="bg-white! w-4/5 md:w-24!" flyout position="left">
    <div class="space-y-6">            
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
            <flux:navlist class="w-64 mt-10">
            @foreach($categories as $cat)
                <flux:navlist.item href="{{ route('shop', ['category' => $cat->slug]) }}">{{ $cat->name }}</flux:navlist.item>
            @endforeach        
            </flux:navlist>
    </div>
</flux:modal>