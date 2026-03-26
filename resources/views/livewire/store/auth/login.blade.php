<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')] // Force it to use your luxury layout

    public $email = '';
    public $password = '';

    public function login() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            
            // Redirect based on role
            return Auth::user()->isAdmin() 
                ? redirect()->intended('/dashboard') 
                : redirect()->intended('/account');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }
}; ?>

<div class="min-h-screen grid">
    <div class="flex items-center justify-center px-12 py-12 bg-white">
        <div class="w-full max-w-sm space-y-4">
            <div class="text-center space-y-4">
                <h1 class="text-4xl font-serif italic tracking-tight">Login</h1>
                <p class="text-[10px] text-zinc-400 uppercase tracking-widest">Sign in to your Lumiskin account</p>
            </div>

            <form wire:submit="login" class="space-y-4">
                <flux:input wire:model="email" label="Email Address" class="input"/>
                <div class="space-y-1">
                    <flux:input wire:model="password" type="password" label="Password" class="input" />
                    <div class="flex justify-end">
                        <a href="#" class="text-[9px] uppercase tracking-widest text-zinc-400 underline italic">Forgot Password?</a>
                    </div>
                </div>

                <flux:button type="submit" class="w-full bg-black text-white h-16 rounded-none uppercase text-xs tracking-[0.4em] hover:bg-zinc-800 transition-colors">
                    Sign In
                </flux:button>
            </form>

            <div class="pt-12 border-t border-zinc-100 text-center">
                <p class="text-xs text-zinc-500 font-light mb-6">New to the collective?</p>
                <flux:button href="/register" variant="ghost" class="w-full border border-black rounded-none h-14 uppercase text-[10px] tracking-widest">
                    Create an Account
                </flux:button>
            </div>
        </div>
    </div>
</div>