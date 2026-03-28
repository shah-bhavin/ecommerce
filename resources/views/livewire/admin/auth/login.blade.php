<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

// USE THE STARTER KIT LAYOUT
new class extends Component {
    #[Layout('layouts.auth')] 

    public $email = '';
    public $password = '';

    public function login() {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->isAdmin()) {
                session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            }
            
            // If a non-admin tries to log in here
            Auth::logout();
            $this->addError('email', 'This portal is restricted to administrators.');
        } else {
            $this->addError('email', 'Invalid credentials.');
        }
    }
}; ?>

<div class="flex min-h-screen items-center justify-center bg-zinc-50 p-6">
    <div class="w-full max-w-sm space-y-6">
        <div class="text-center">
            {{-- Use Flux Heading for that 'Starter Kit' look --}}
            <flux:heading size="xl">Admin Portal</flux:heading>
            <flux:subheading>Secure back-office access</flux:subheading>
        </div>

        <form wire:submit="login" class="space-y-4">
            <flux:input wire:model="email" label="Email" type="email" required />
            <flux:input wire:model="password" label="Password" type="password" required />
            
            <flux:button type="submit" variant="primary" class="w-full">
                Login to Dashboard
            </flux:button>
        </form>
    </div>
</div>