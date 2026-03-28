<?php
use Livewire\Component;

new class extends Component {
    public $email = '';

    public function subscribe() {
        $this->validate(['email' => 'required|email']);
        // Logic here
        $this->reset('email');
    }
}; ?>

<footer class="bg-white border-t border-zinc-100 pt-20 pb-10 mt-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 lg:grid-cols-4 gap-12">
        <div class="col-span-1 md:col-span-2 space-y-6">
            <h2 class="text-2xl font-serif italic italic">Lumiskin</h2>
            <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 max-w-xs leading-relaxed">
                Molecular clinical solutions for high-performance skincare.
            </p>
        </div>

        <div>
            <h3 class="text-[10px] font-bold uppercase tracking-widest mb-6">Concierge</h3>
            <ul class="text-xs space-y-4 text-zinc-500 font-light">
                <li><a href="#" class="hover:text-black transition-colors">Shipping</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Returns</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-[10px] font-bold uppercase tracking-widest mb-6">Social</h3>
            <ul class="text-xs space-y-4 text-zinc-500 font-light">
                <li><a href="#" class="hover:text-black transition-colors">Instagram</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Journal</a></li>
            </ul>
        </div>
    </div>
</footer>