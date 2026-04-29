<div class="space-y-10">
    <!-- 1. Saved Addresses List -->
    <section class="space-y-4">
        <h3 class="text-brand-dark font-bold text-lg uppercase tracking-tight border-b border-zinc-100 pb-2">Saved Addresses</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($addresses as $address)
                <div class="flex justify-between items-start p-5 border border-zinc-100 rounded-lg bg-zinc-50/30 hover:border-zinc-200 transition-colors">
                    <div class="font-inter space-y-1">
                        <!-- Address Type Badge -->
                        <span class="inline-block px-2 py-0.5 bg-zinc-200 text-brand-dark text-[9px] font-bold uppercase tracking-wider rounded mb-1">
                            {{ $address->type ?? 'Home' }}
                        </span>
                        
                        <p class="text-sm font-bold uppercase text-brand-dark leading-tight">{{ $address->fullname }}</p>
                        <p class="text-xs text-brand-muted font-medium">{{ $address->phone }}</p>
                        
                        <div class="text-xs text-brand-muted leading-relaxed pt-1">
                            <p>{{ $address->getFullAddressAttribute() }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-3">
                        <button wire:click="editAddress({{ $address->id }})" 
                            class="p-2 text-brand-dark hover:bg-white rounded-md border border-transparent hover:border-zinc-200 transition-all cursor-pointer shadow-sm">
                            <x-lucide-edit class="size-4" />
                        </button>
                        
                        <button wire:click="confirmDelete({{ $address->id }})" 
                            class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all cursor-pointer">
                            <x-lucide-trash-2 class="size-4" />
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center border border-dashed border-zinc-200 rounded-lg">
                    <p class="text-sm text-brand-muted italic">No addresses found.</p>
                </div>
            @endforelse
        </div>

    </section>

    <!-- 2. Dynamic Form (Add/Edit) -->
    <form wire:submit="saveAddress" class="space-y-5 bg-zinc-50/50 p-6 rounded-lg border border-zinc-100">
        <div class="flex justify-between items-center border-b border-zinc-100 pb-2 mb-4">
            <h3 class="text-brand-dark font-bold text-lg uppercase tracking-tight">{{ $isEditing ? 'Edit Address' : 'Add New Address' }}</h3>
            @if($isEditing)
                <button type="button" wire:click="resetAddressForm" class="text-[10px] font-bold uppercase text-brand-muted hover:text-brand-dark">Cancel</button>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div class="relative md:col-span-2">
                <label class="label-theme">Full Name</label>
                <input wire:model="fullname"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="Sophia Al-Maktoum" type="text" />
                    @error('fullname')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label wire:model="phone" class="label-theme">Phone</label>
                <input wire:model="phone"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="99999 99999" type="tel" />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label wire:model="house_no" class="label-theme">House No</label>
                <input wire:model="house_no"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="A-7" type="text" />
                    @error('house_no')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label wire:model="area" class="label-theme">Area</label>
                <input wire:model="area"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="Downtown" type="text" />
                    @error('area')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label class="label-theme">Landmark</label>
                <input wire:model="landmark"
                    class="input-underlined"
                    placeholder="Downtown Boulevard, Villa 42" type="text" />
                    @error('landmark')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>                    
            <div class="relative">
                <label class="label-theme">Postal Code</label>
                <input wire:model="pincode"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="00000" type="text" />
                    @error('pincode')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label class="label-theme">City</label>
                <input wire:model="city"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm placeholder:text-outline"
                    placeholder="Dubai" type="text" />
                    @error('city')
                        <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
            </div>
            <div class="relative">
                <label class="label-theme"> Type </label>
                <select wire:model="type"
                    class="w-full bg-transparent border-0 border-b border-outline-variant focus:ring-0 focus:border-secondary transition-colors py-2 px-1 text-sm appearance-none cursor-pointer">
                    <option value="" disabled selected>Select Type</option>
                    <option value="Home">Home</option>
                    <option value="Office">Office</option>
                    <option value="Other">Other</option>
                </select>
                
                @error('type')
                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative">
                <label class="block text-[10px] uppercase tracking-widest text-on-surface-variant mb-3 ml-1">
                    Set as Default?
                </label>
                <div class="flex items-center gap-6 px-1">
                    <label class="flex items-center cursor-pointer text-sm">
                        <input type="radio" wire:model="is_default" value="1" 
                            class="w-4 h-4 border-outline-variant text-secondary focus:ring-secondary focus:ring-offset-0 bg-transparent transition-colors">
                        <span class="ml-2 text-on-surface">Yes</span>
                    </label>

                    <label class="flex items-center cursor-pointer text-sm">
                        <input type="radio" wire:model="is_default" value="0" 
                            class="w-4 h-4 border-outline-variant text-secondary focus:ring-secondary focus:ring-offset-0 bg-transparent transition-colors">
                        <span class="ml-2 text-on-surface">No</span>
                    </label>
                </div>

                @error('is_default')
                    <p class="mt-2 text-sm text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="w-full btn-theme">
            {{ $isEditing ? 'Update Address' : 'Save Address' }}
        </button>
    </form>
</div>

@if($confirmingDelete)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <!-- Backdrop with Blur -->
    <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm" wire:click="$set('confirmingDelete', false)"></div>

    <!-- Modal Content -->
    <div class="relative bg-white w-full max-w-sm p-8 rounded-xl shadow-2xl border border-zinc-100 font-inter animate-in fade-in zoom-in duration-200">
        <div class="flex flex-col items-center text-center">
            <div class="bg-red-50 p-3 rounded-full mb-4">
                <x-lucide-alert-triangle class="size-6 text-red-600" />
            </div>
            
            <h3 class="text-brand-dark font-bold text-lg uppercase tracking-tight">Delete Address?</h3>
            <p class="text-brand-muted text-sm mt-2">This action cannot be undone. Are you sure you want to remove this address?</p>
            
            <div class="flex gap-3 w-full mt-8">
                <button wire:click="$set('confirmingDelete', false)" 
                    class="btn-theme">
                    Cancel
                </button>
                <button wire:click="deleteAddress" 
                    class="btn-theme-inverse cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endif
