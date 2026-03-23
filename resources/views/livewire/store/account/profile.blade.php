<?php
use Illuminate\Support\Facades\{Auth, Hash};
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $name, $email, $current_password, $new_password;

    public function mount() {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile() {
        $this->validate(['name' => 'required', 'email' => 'required|email|unique:users,email,'.Auth::id()]);
        Auth::user()->update(['name' => $this->name, 'email' => $this->email]);
        $this->dispatch('toast', text: 'Profile Updated');
    }

    public function updatePassword() {
        $this->validate(['current_password' => 'required|current_password', 'new_password' => 'required|min:8']);
        Auth::user()->update(['password' => Hash::make($this->new_password)]);
        $this->reset(['current_password', 'new_password']);
        $this->dispatch('toast', text: 'Password Changed');
    }
}; ?>

<div class="max-w-4xl mx-auto py-20 px-6">
    <livewire:store.account.navigation />
    <div class="mt-12 grid md:grid-cols-2 gap-16">
        <form wire:submit="updateProfile" class="space-y-6">
            <h3 class="font-serif italic text-xl">General Details</h3>
            <flux:input wire:model="name" label="Name" />
            <flux:input wire:model="email" label="Email" />
            <flux:button type="submit" variant="filled">Save Changes</flux:button>
        </form>

        <form wire:submit="updatePassword" class="space-y-6">
            <h3 class="font-serif italic text-xl">Security</h3>
            <flux:input wire:model="current_password" type="password" label="Current Password" />
            <flux:input wire:model="new_password" type="password" label="New Password" />
            <flux:button type="submit" variant="outline">Update Password</flux:button>
        </form>
    </div>
</div>