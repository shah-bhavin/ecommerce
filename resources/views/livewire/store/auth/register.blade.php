<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $name, $email, $password, $password_confirmation;

    public function register() {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        return redirect()->to('/account');
    }
}; ?>

<div class="max-w-xl mx-auto py-24 px-6">
    <div class="text-center mb-12 space-y-4">
        <h1 class="text-4xl font-serif italic">Create Account</h1>
        <p class="text-zinc-400 text-[10px] uppercase tracking-widest">Join for clinical updates and order tracking</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <flux:input wire:model="name" label="Full Name" class="rounded-none h-12" />
        <flux:input wire:model="email" type="email" label="Email Address" class="rounded-none h-12" />
        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="password" type="password" label="Password" class="rounded-none h-12" />
            <flux:input wire:model="password_confirmation" type="password" label="Confirm" class="rounded-none h-12" />
        </div>
        <flux:button type="submit" class="w-full bg-black text-white h-14 rounded-none uppercase text-xs tracking-widest">Register</flux:button>
    </form>
</div>