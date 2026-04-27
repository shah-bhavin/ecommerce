<?php
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ShippingRule;

new class extends Component
{
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;

    public $label, $threshold, $fee, $priority = 0, $is_active = true;

    public function openCreateModal() {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id) {
        $rule = ShippingRule::findOrFail($id);
        $this->editingId = $id;
        $this->label = $rule->label;
        $this->threshold = $rule->threshold;
        $this->fee = $rule->fee;
        $this->priority = $rule->priority;
        $this->is_active = $rule->is_active;
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'label' => 'required|string',
            'threshold' => 'required|numeric',
            'fee' => 'required|numeric',
        ]);

        ShippingRule::updateOrCreate(['id' => $this->editingId], [
            'label' => $this->label,
            'threshold' => $this->threshold,
            'fee' => $this->fee,
            'priority' => $this->priority,
            'is_active' => $this->is_active,
        ]);

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete($id) {
        $this->editingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        ShippingRule::find($this->editingId)->delete();
        $this->showDeleteModal = false;
    }

    private function resetForm() {
        $this->reset(['label', 'threshold', 'fee', 'priority', 'is_active', 'editingId']);
    }

    public function with() {
        return [
            'rules' => ShippingRule::orderBy('threshold', 'asc')->get()
        ];
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Shipping Logistics</flux:heading>
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus">Add Shipping</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Rule Label</flux:table.column>
            <flux:table.column>Order Threshold</flux:table.column>
            <flux:table.column>Applied Fee</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($rules as $rule)
                <flux:table.row :key="$rule->id">
                    <flux:table.cell>{{ $rule->label }}</flux:table.cell>
                    <flux:table.cell>Up to ₹{{ number_format($rule->threshold, 2) }}</flux:table.cell>
                    <flux:table.cell>₹{{ number_format($rule->fee, 2) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :color="$rule->is_active ? 'zinc' : 'red'" inset="top bottom">
                            {{ $rule->is_active ? 'Active' : 'Disabled' }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $rule->id }})" size="sm" icon="pencil-square" wire:loading.attr="disabled"/>
                            <flux:button wire:click="confirmDelete({{ $rule->id }})"  wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal wire:model="showModal" class="md:w-[500px] space-y-6" flyout>
        <flux:heading size="lg">{{ $editingId ? 'Refine Tier' : 'New Logistics Tier' }}</flux:heading>

        <form wire:submit="save" class="space-y-6">
            <flux:input wire:model="label" label="Tier Label" placeholder="e.g. Standard Delivery" />
            
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="threshold" type="number" label="Threshold (₹)" placeholder="500" />
                <flux:input wire:model="fee" type="number" label="Fee (₹)" placeholder="50" />
            </div>

            <flux:checkbox wire:model="is_active" label="Enable this tier" />

            <div class="flex justify-end gap-2 pt-4">
                <flux:button wire:click="$set('showModal', false)">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Logistics</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal wire:model="showDeleteModal" class="md:w-96">
        <div class="space-y-6">
            <flux:heading size="lg">Remove Logistics Tier?</flux:heading>
            <flux:subheading>
                    Are you sure you want to delete this Tier?
                </flux:subheading>
            <div class="flex justify-end space-x-2">
                <flux:button wire:click="$set('showDeleteModal', false)" variant="ghost">Cancel</flux:button>
                <flux:button wire:click="delete" variant="danger">Remove</flux:button>
            </div>
        </div>
    </flux:modal>
</div>