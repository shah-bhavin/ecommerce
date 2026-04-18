<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]

    public $email = '';
    public $password = '';

    public function login() {
        
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['role'] = 'customer';

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->intended('/account');
        }

        $this->dispatch('toast', 
            type: 'error', 
            text: 'These credentials do not match our records.'
        );
    }
};
?>

<div class="min-h-[80vh] flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <h1 class="hero-medium mb-4">Login</h1>
        </div>

        <form wire:submit="login" class="space-y-10">
            <div class="relative z-0 w-full group">
                <label for="email" class="label-theme">EMAIL ADDRESS</label>
                <input wire:model="email" type="email" id="email" 
                    class="input-theme {{ $errors->has('email') ? 'input-error' : 'input-default' }}" 
                    placeholder=" " />
                
                @error('email') 
                    <p class="mt-1 text-[12px] text-red-600 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <div class="relative z-0 w-full group">
                <label for="password" class="label-theme">PASSWORD</label>
                <input wire:model="password" type="password" id="password" 
                    class="input-theme {{ $errors->has('password') ? 'input-error' : 'input-default' }}" 
                    placeholder=" " />                
                @error('password') 
                    <p class="mt-1 text-[12px] text-red-600 font-medium">{{ $message }}</p> 
                @enderror
                <div class="flex justify-end mt-2">
                    <a href="/forgot-password" class="text-[9px] uppercase tracking-widest text-zinc-400 hover:text-black transition-colors underline italic">Forgot?</a>
                </div>
            </div>

            <button type="submit" class="w-full btn-theme-inverse">
                Sign In
            </button>
        </form>

        <div class="mt-12 pt-1 border-t border-zinc-100 text-center">
            <a href="/register" class="text-[10px] font-bold uppercase tracking-[0.2em] border-b border-black pb-1 hover:text-zinc-500 hover:border-zinc-500 transition-all">
                Create An Account
            </a>
        </div>
    </div>
</div>