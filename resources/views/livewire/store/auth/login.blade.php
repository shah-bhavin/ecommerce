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
    <div class="min-h-screen grid">
        <div class="flex items-center justify-center px-2 py-2 bg-white">
            <div class="w-full max-w-sm space-y-4">
                <div class="text-center space-y-4">
                    <h1 class="text-3xl font-serif tracking-tight uppercase">Login</h1>
                </div>

                <form wire:submit="login" class="space-y-4">
                    <flux:input wire:model="email" label="Email Address" class="[&_input]:rounded-none! h-12"/>
                    <div class="space-y-1">
                        <flux:input wire:model="password" type="password" label="Password" class="[&_input]:rounded-none! h-12" />

                        <div class="flex justify-end">
                            <a href="#" class="text-[9px] uppercase tracking-widest text-zinc-400 underline italic">Forgot Password?</a>
                        </div>
                    </div>

                    <flux:button type="submit" class="w-full bg-black! text-white! h-8 rounded-none uppercase text-xs tracking-[0.4em] hover:bg-zinc-800 transition-colors">
                        Sign In
                    </flux:button>
                </form>

                <div class="pt-4 border-zinc-100 text-center">
                    <flux:button href="/register" class="w-full border border-black rounded-none h-8 uppercase text-[10px] tracking-widest">
                        Create an Account
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>
