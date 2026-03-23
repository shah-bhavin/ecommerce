<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')] 

    public $email = '';
    public $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/account');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }
}; ?>

<div class="max-w-md mx-auto py-32 px-6">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif italic uppercase tracking-tighter">Sign In</h1>
        <p class="text-[10px] text-zinc-400 uppercase tracking-[0.2em] mt-2">Access your Lumiskin Account</p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <flux:input wire:model="email" label="Email" type="email" viewable class="rounded-none h-12 border-zinc-200" />
        
        <div class="space-y-1">
            <flux:input wire:model="password" label="Password" type="password" viewable class="rounded-none h-12 border-zinc-200" />
            <div class="flex justify-end">
                <a href="#" class="text-[9px] uppercase tracking-widest text-zinc-400 hover:text-black underline">Forgot?</a>
            </div>
        </div>

        <flux:button type="submit" class="w-full bg-black text-white h-14 rounded-none uppercase text-xs tracking-[0.3em] hover:bg-zinc-800 transition-colors">
            Login
        </flux:button>
    </form>

    <div class="mt-12 pt-8 border-t border-zinc-100 text-center">
        <p class="text-sm text-zinc-500 font-light mb-4">New to Lumiskin?</p>
        <flux:button href="/register" variant="ghost" class="w-full border border-black rounded-none h-14 uppercase text-xs tracking-widest">
            Create Account
        </flux:button>
    </div>
</div>