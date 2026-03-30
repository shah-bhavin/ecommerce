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
}; ?>

<div class="min-h-[80vh] flex items-center justify-center py-20 px-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-16">
            <h1 class="text-3xl font-serif uppercase tracking-widest text-zinc-800">Create Account</h1>
        </div>

        <form wire:submit="register" class="space-y-10">
            <div class="relative z-0 w-full group">
                <input wire:model="name" type="text" id="name" class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('name') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" placeholder=" " />
                <label for="name" class="absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('name') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">Full Name</label>
                @error('name') <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="relative z-0 w-full group">
                <input wire:model="email" type="email" id="email_reg" class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('email') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" placeholder=" " />
                <label for="email_reg" class="absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('email') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">Email Address</label>
                @error('email') <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="relative z-0 w-full group">
                    <input wire:model="password" type="password" id="pass" class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('password') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" placeholder=" " />
                    <label for="pass" class="absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('password') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">Password</label>
                </div>
                <div class="relative z-0 w-full group">
                    <input wire:model="password_confirmation" type="password" id="pass_conf" class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer border-zinc-300 focus:border-black" placeholder=" " />
                    <label for="pass_conf" class="absolute text-xs text-zinc-500 duration-300 transform -translate-y-6 peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest scale-75 top-3 -z-10 origin-[0] peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-black">Confirm</label>
                </div>
            </div>
            @error('password') <p class="mt-[-2rem] text-[10px] text-red-600">{{ $message }}</p> @enderror

            <button type="submit" class="w-full bg-black text-white py-4 text-xs uppercase tracking-[0.4em] hover:bg-zinc-800 transition-all active:scale-[0.98]">
                Create Account
            </button>
        </form>
    </div>
</div>