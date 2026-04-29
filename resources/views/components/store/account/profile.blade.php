<div class="w-full font-inter">
    <div class="grid md:grid-cols-2 gap-12">
        <form wire:submit="updatePassword" class="space-y-5">
            <h3 class="text-brand-dark font-bold text-lg uppercase tracking-tight border-b border-zinc-100 pb-2">Security</h3>
            
            <div class="space-y-1">
                <label class="label-theme" for="current_password">Current Password</label>
                <input wire:model="current_password" type="password" 
                    class="input-theme {{ $errors->has('current_password') ? 'input-error' : 'input-default' }}" />
                @error('current_password') 
                    <p class="input-error-text">{{ $message }}</p> 
                @enderror
            </div>

            <div class="space-y-1">
                <label class="label-theme">New Password</label>
                <input wire:model="new_password" type="password" 
                    class="input-theme {{ $errors->has('new_password') ? 'input-error' : 'input-default' }}" />
                @error('new_password') 
                    <p class="input-error-text">{{ $message }}</p> 
                @enderror
            </div>

            <button type="submit" 
                class="w-full btn-theme">
                Update Password
            </button>
        </form>
    </div>
</div>
