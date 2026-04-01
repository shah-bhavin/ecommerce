<?php
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.store')]

    public $email = '';
    public $status = '';

    public function sendResetLink() {
        $this->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = __($status);
        } else {
            $this->addError('email', __($status));
        }
    }
};
?>

<div class="min-h-[80vh] flex items-center justify-center px-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-12 space-y-4">
            <h1 class="text-3xl font-serif uppercase tracking-widest">Reset Access</h1>
            <p class="text-[10px] text-zinc-400 uppercase tracking-[0.2em] leading-relaxed">Enter your email to receive recovery instructions.</p>
        </div>

        @if ($status)
            <div class="p-4 mb-8 text-[10px] uppercase tracking-widest text-green-800 bg-green-50 border border-green-100 text-center">
                {{ $status }}
            </div>
        @else
            <form wire:submit="sendResetLink" class="space-y-10">
                <div class="relative z-0 w-full group">
                    <input wire:model="email" type="email" id="email_forgot" class="block py-2.5 px-2 w-full text-sm text-zinc-900 bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer {{ $errors->has('email') ? 'border-red-600 focus:border-red-600' : 'border-zinc-300 focus:border-black' }}" placeholder=" " />
                    <label for="email_forgot" class="peer-focus:font-medium absolute text-xs duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest {{ $errors->has('email') ? 'text-red-600' : 'text-zinc-500 peer-focus:text-black' }}">Email Address</label>
                    @error('email') <p class="mt-1 text-[10px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 text-xs tracking-[0.4em] hover:bg-zinc-800 transition-all">
                    Send Link
                </button>
            </form>
        @endif

        <div class="mt-12 text-center">
            <a href="/login" class="text-[9px] uppercase tracking-[0.3em] text-zinc-400 hover:text-black transition-colors underline">Return to Login</a>
        </div>
    </div>
</div>