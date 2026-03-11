<?php

use App\Models\{Address, User};
use Livewire\Component;

new class extends Component
{
    public $addresses;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId, $deletingId;

    // Form Fields
    public $user_id, $fullname, $phone, $house_no, $area, $landmark, $city, $state, $pincode, $type = 'home';

    public function create() {
        $this->reset();
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'user_id' => 'required',
            'fullname' => 'required',
            'phone' => 'required|digits:10',
            'pincode' => 'required|digits:6',
            'city' => 'required',
            'state' => 'required',
        ]);

        $address = Address::updateOrCreate(['id' => $this->editingId], [
            'user_id' => $this->user_id,
            'fullname' => $this->fullname,
            'phone' => '$this->phone',
            'house_no' => $this->house_no,
            'area' => $this->area,
            'landmark' => $this->landmark,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'type' => $this->type,
        ]);

        $this->showModal = false;
        $this->reset();
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $product = Address::find($this->deletingId);  

            $product->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->addresses();
        }
    }

    // public function setAsDefault($id, $userId) {
    //     Address::where('user_id', $userId)->update(['is_default' => 0]);
    //     Address::where('id', $id)->update(['is_default' => 1]);
    //     $this->addresses();
    // }

    public function edit($id) {
        $address = Address::find($id);
        $this->editingId = $id;
        $this->user_id = $address->user_id;
        $this->fullname = $address->fullname;
        $this->city = $address->city;
        $this->showModal = true;
    }

    public function addresses(){
        return Address::all();
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Customer Addresses</flux:heading>
        <flux:button wire:click="create" variant="primary" icon="plus">Add Addresses</flux:button>
    </div>

    <flux:table :paginate="$this->addresses">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <flux:table.column>Customer</flux:table.column>
            <flux:table.column>Address Detail</flux:table.column>
            <flux:table.column>PIN</flux:table.column>
            <flux:table.column>Default</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach(Address::with('user')->get() as $addr)
                <flux:table.row>
                    <flux:table.cell>{{ $addr->user->name }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm font-bold">{{ $addr->fullname }}</div>
                        <div class="text-xs text-zinc-500">{{ $addr->house_no }}, {{ $addr->area }}</div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $addr->pincode }}</flux:table.cell>
                    
                    <flux:table.cell>
                        {!! $addr->is_default == 1 ? '<flux:badge color="lime" size="sm">Yes</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">No</flux:badge>' !!}
                    </flux:table.cell>

                    {{-- <flux:table.cell>
                        <flux:switch wire:click="setAsDefault({{ $addr->id }}, {{ $addr->user_id }})" :checked="$addr->is_default" color="green" />
                    </flux:table.cell> --}}

                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $addr->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                            <flux:button wire:click="confirmDelete({{ $addr->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal wire:model="showModal" flyout>
        <form wire:submit="save" class="space-y-6">
            <flux:heading size="lg" class="mb-4">Customer Address</flux:heading>
            <flux:select wire:model="user_id" label="Assign to User" class="mb-4">
                <option value="">Select User</option>    
                @foreach(User::all() as $user) <option value="{{ $user->id }}">{{ $user->name }}</option> @endforeach
            </flux:select>
            
            <flux:input wire:model="fullname" label="Receiver Name" class="mb-4" />
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <flux:input wire:model="house_no" label="House/Flat No." />
                <flux:input wire:model="pincode" label="Pincode" maxlength="6" />
            </div>
            
            <flux:input wire:model="phone" label="Phone" class="mb-4" />
            <flux:input wire:model="area" label="Area/Street" class="mb-4" />
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <flux:input wire:model="city" label="City" />
                <flux:input wire:model="state" label="State" />
            </div>

            <div class="flex justify-end gap-2">
                <flux:button wire:click="$set('showModal', false)">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Address</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal wire:model="showDeleteModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Are you sure?</flux:heading>
                <flux:subheading>
                    Are you sure you want to delete this category?
                </flux:subheading>
            </div>

            <div class="flex space-x-2">
                <flux:spacer />
                <flux:button wire:click="$set('showDeleteModal', false)" variant="ghost">Cancel</flux:button>
                <flux:button wire:click="delete" variant="danger">Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>