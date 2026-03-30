<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $email = '';
    public $password = '';

    public function login() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return Auth::user()->role === 'admin' 
                ? redirect()->intended('/admin/dashboard') 
                : redirect()->intended('/account');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }
}; ?>

<div class="min-h-[80vh] flex items-center justify-center px-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-serif uppercase tracking-widest text-zinc-800">Login</h1>
            <p class="text-[10px] text-zinc-400 uppercase tracking-[0.2em] mt-2">Enter your clinical profile</p>
        </div>

        <form wire:submit="login" class="space-y-10">
            <div class="relative z-0 w-full group">
                <input wire:model="email" type="email" id="email" 
                    class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('email') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" 
                    placeholder=" " />
                <label for="email" class="peer-focus:font-medium absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('email') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">
                    Email Address
                </label>
                @error('email') 
                    <p class="mt-1 text-[10px] text-red-600 font-medium">{{ $message }}</p> 
                @enderror
            </div>

            <div class="relative z-0 w-full group">
                <input wire:model="password" type="password" id="password" 
                    class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('password') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" 
                    placeholder=" " />
                <label for="password" class="peer-focus:font-medium absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('password') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">
                    Password
                </label>
                @error('password') 
                    <p class="mt-1 text-[10px] text-red-600 font-medium">{{ $message }}</p> 
                @enderror
                <div class="flex justify-end mt-2">
                    <a href="/forgot-password" class="text-[9px] uppercase tracking-widest text-zinc-400 hover:text-black transition-colors underline italic">Forgot?</a>
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 text-xs uppercase tracking-[0.4em] hover:bg-zinc-800 transition-all active:scale-[0.98]">
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