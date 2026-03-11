<?php
use App\Models\Coupon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

new class extends Component
{
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId, $deletingId, $code, $type = 'fixed', $value, $min_order_amount = 0, $expiry_date, $is_active = true;

    public function create() {
        $this->reset();
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'code' => 'required|unique:coupons,code,' . $this->editingId,
            'value' => 'required|numeric',
            'type' => 'required',
        ]);

        Coupon::updateOrCreate(['id' => $this->editingId], [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'min_order_amount' => $this->min_order_amount,
            'expiry_date' => $this->expiry_date,
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;
        $this->reset();
    }

    public function edit($id) {
        $coupon = Coupon::find($id);
        $this->editingId = $id;
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->expiry_date = $coupon->expiry_date;
        $this->showModal = true;
    }

    public function coupons(){
        return Coupon::query()->paginate(25);
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $coupon = Coupon::find($this->deletingId);
        
            // Delete the file first
            if ($coupon->image) {
                Storage::disk('public')->delete($coupon->image);
            }

            $coupon->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->categories();
        }
    }
};
?>

<div lazy>
    <div class="flex justify-between items-center mb-6 gap-6">
        <flux:heading size="xl">Coupons</flux:heading>
        <flux:button wire:click="create" variant="primary" icon="plus">Create Coupon</flux:button>
    </div>

    <flux:table :paginate="$this->coupons()">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <flux:table.column>Code</flux:table.column>
            <flux:table.column>Discount</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->coupons() as $coupon)
                <flux:table.row>
                    <flux:table.cell class="font-bold">{{ $coupon->code }}</flux:table.cell>
                    <flux:table.cell>{{ $coupon->type == 'percent' ? $coupon->value.'%' : '₹'.$coupon->value }}</flux:table.cell>
                    
                    <flux:table.cell>
                        {!! $coupon->is_active == 1 ? '<flux:badge color="lime" size="sm">Active</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">Inactive</flux:badge>' !!}
                    </flux:table.cell>
                    
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $coupon->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                            <flux:button wire:click="confirmDelete({{ $coupon->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal wire:model="showModal" flyout>
        <form wire:submit="save" class="space-y-4">
            <flux:input wire:model="code" label="Promo Code" placeholder="FASHION50" />
            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="type" label="Type">
                    <option value="fixed">Fixed (₹)</option>
                    <option value="percent">Percentage (%)</option>
                </flux:select>
                <flux:input wire:model="value" type="number" label="Value" />
            </div>
            <flux:input wire:model="expiry_date" type="date" label="Expiry Date" />
            <flux:button type="submit" variant="primary">Save Coupon</flux:button>
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