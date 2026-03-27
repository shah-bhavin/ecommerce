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

<div class="max-w-xl mx-auto py-12 px-6">
    <div class="text-center mb-16 space-y-2">
        <h1 class="text-3xl font-serif tracking-tight uppercase">Create Account</h1>
    </div>

    <form wire:submit="register" class="space-y-2">
        <flux:input wire:model="name" label="Full Name" placeholder="Jane Doe" class="[&_input]:rounded-none! h-12" />
        <flux:input wire:model="phone" type="phone" label="Contact Number" placeholder="+91 99999 99999" class="[&_input]:rounded-none! h-12" />

        <flux:input wire:model="email" type="email" label="Email Address" placeholder="Jane@Doe.com" class="[&_input]:rounded-none! h-12" />
        
        <flux:input wire:model="password" type="password" label="Password" class="[&_input]:rounded-none! h-12 border-stone-900" />

        <flux:button type="submit" class="w-full bg-black! text-white! h-8 rounded-none uppercase text-xs tracking-[0.3em]">
            Create Account
        </flux:button>
        <div class="pt-4 border-zinc-100 text-center">
            <flux:button href="/login" class="w-full border border-black rounded-none h-8 uppercase text-[10px] tracking-widest">
                Login
            </flux:button>
        </div>
    </form>
</div>