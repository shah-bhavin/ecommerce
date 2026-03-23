<?php
use App\Models\User;
use Illuminate\Support\Facades\{Hash, Auth};
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $name, $email, $password, $password_confirmation;

    public function register() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'customer', // Always default to customer
        ]);

        Auth::login($user);
        return redirect()->to('/account');
    }
}; ?>

<div class="max-w-xl mx-auto py-32 px-6">
    <div class="text-center mb-16 space-y-4">
        <h1 class="text-5xl font-serif italic tracking-tight">Join Us</h1>
        <p class="text-zinc-400 text-[10px] uppercase tracking-[0.2em]">Unlock clinical rewards & seamless ordering</p>
    </div>

    <form wire:submit="register" class="space-y-8">
        <flux:input wire:model="name" label="Full Name" placeholder="Jane Doe" class="rounded-none h-12" />
        <flux:input wire:model="email" type="email" label="Email Address" class="rounded-none h-12" />
        
        <div class="grid grid-cols-2 gap-6">
            <flux:input wire:model="password" type="password" label="Password" class="rounded-none h-12" />
            <flux:input wire:model="password_confirmation" type="password" label="Confirm" class="rounded-none h-12" />
        </div>

        <flux:button type="submit" class="w-full bg-black text-white h-16 rounded-none uppercase text-xs tracking-[0.3em]">
            Create Account
        </flux:button>
    </form>
</div>