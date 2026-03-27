<flux:modal name="sidebar" class="bg-white! w-4/5 md:w-24!" flyout position="left">
    <div class="space-y-6">            
        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
        <flux:navlist class="pt-10 gap-2">
            <flux:navlist.item href="#">Home</flux:navlist.item>
            <flux:navlist.item href="#">Features</flux:navlist.item>
            <flux:navlist.item href="#">Pricing</flux:navlist.item>
            <flux:navlist.item href="#">About</flux:navlist.item>
        </flux:navlist>            
    </div>
</flux:modal>