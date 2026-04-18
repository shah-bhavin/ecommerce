<?php
use App\Models\User;
use Illuminate\Support\Facades\{Hash, Auth};
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $name, $email, $password, $password_confirmation, $phone;

    public function register() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => 'customer',
        ]);

        Auth::login($user);
        return redirect()->to('/account');
    }
};
?>

<div class="min-h-[80vh] flex items-center justify-center py-10 px-6">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <h1 class="hero-medium mb-4">Create Account</h1>
        </div>

        <form wire:submit="register" class="space-y-10">
            <div class="relative z-0 w-full group">
                <label for="name" class="label-theme">FULL NAME</label>
                <input wire:model="name" type="text" id="name" class="input-theme {{ $errors->has('name') ? 'input-error' : 'input-default' }}" placeholder=" " />
                @error('name') 
                    <p class="input-error-text">{{ $message }}</p> 
                @enderror
            </div>

            <div class="relative z-0 w-full group">
                <label for="email" class="label-theme">EMAIL ADDRESS</label>
                <input wire:model="email" type="email" id="email_reg" class="input-theme {{ $errors->has('email') ? 'input-error' : 'input-default' }}" placeholder=" " />
                @error('email') 
                    <p class="input-error-text">{{ $message }}</p> 
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="relative z-0 w-full group">
                    <label for="password" class="label-theme">PASSWORD</label>
                    <input wire:model="password" type="password" id="pass" class="input-theme {{ $errors->has('password') ? 'input-error' : 'input-default' }}" placeholder=" " />
                    @error('password') 
                        <p class="input-error-text">{{ $message }}</p> 
                    @enderror
                </div>
                <div class="relative z-0 w-full group">
                    <label for="pass_conf" class="label-theme">CONFIRM PASSWORD</label>
                    <input wire:model="password_confirmation" type="password" id="pass_conf" class="input-theme {{ $errors->has('password') ? 'input-error' : 'input-default' }}" placeholder=" " />                    
                </div>
            </div>

            <button type="submit" class="w-full btn-theme-inverse">
                Create Account
            </button>
        </form>
    </div>
</div>