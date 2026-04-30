<?php

use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

new class extends Component {
    public $gateways;
    public $editingGateway = null;
    public $form = [
        'is_active' => false,
        'is_test_mode' => true,
        'credentials' => []
    ];
    public $showModal = false;


    public function mount() {
        $this->loadGateways();
    }

    public function loadGateways() {
        $this->gateways = PaymentGateway::orderBy('sort_order')->get();
    }

    public function edit($id) {
        $gateway = PaymentGateway::findOrFail($id);
        $this->editingGateway = $gateway;
        
        $this->form = [
            'is_active' => $gateway->is_active,
            'is_test_mode' => $gateway->is_test_mode,
            'credentials' => $gateway->credentials ?? []
        ];
        
        foreach ($this->form['credentials'] as $key => $value) {
            try {
                $this->form['credentials'][$key] = Crypt::decryptString($value);
            } catch (\Exception $e) { }
        }
        $this->showModal = true;
    }

    public function save() {
        // Encrypt sensitive keys before saving
        $securedCredentials = [];
        foreach ($this->form['credentials'] as $key => $value) {
            $securedCredentials[$key] = Crypt::encryptString($value);
        }

        $this->editingGateway->update([
            'is_active' => $this->form['is_active'],
            'is_test_mode' => $this->form['is_test_mode'],
            'credentials' => $securedCredentials
        ]);

        $this->editingGateway = null;
        $this->loadGateways();
        $this->dispatch('toast', text: 'Gateway settings updated.', type: 'success');
    }
}; ?>

<section class="p-8 max-w-5xl mx-auto">
    <flux:heading size="xl" level="1">Payment Methods</flux:heading>

    <div class="mt-8 space-y-4">
        @foreach($gateways as $gateway)
            <div class="flex items-center justify-between p-6 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl border">
                        <flux:icon.credit-card class="size-6" />
                    </div>
                    <div>
                        <flux:heading size="lg">{{ $gateway->name }}</flux:heading>
                        <div class="flex gap-2 mt-1">
                            <flux:badge :color="$gateway->is_active ? 'green' : 'zinc'" size="sm">
                                {{ $gateway->is_active ? 'Active' : 'Disabled' }}
                            </flux:badge>
                            @if($gateway->slug !== 'cod')
                                <flux:badge :color="$gateway->is_test_mode ? 'orange' : 'blue'" size="sm">
                                    {{ $gateway->is_test_mode ? 'Sandbox' : 'Live' }}
                                </flux:badge>
                            @endif
                        </div>
                    </div>
                </div>

                <flux:button wire:click="edit({{ $gateway->id }})" icon="pencil-square">
                    Configure
                </flux:button>
            </div>
        @endforeach
    </div>

    {{-- Configuration Modal --}}
    <flux:modal wire:model="showModal" class="md:w-200">
        <div class="space-y-6">
            <flux:heading size="lg">Configure {{ $editingGateway?->name }}</flux:heading>

            <div class="space-y-4">
                <flux:field>
                    <flux:label>Status</flux:label>
                    <flux:switch wire:model="form.is_active" label="Enable this payment method" />
                </flux:field>

                @if($editingGateway?->slug !== 'cod')
                    <flux:field>
                        <flux:label>Mode</flux:label>
                        <flux:switch wire:model="form.is_test_mode" label="Sandbox / Test Mode" />
                    </flux:field>

                    {{-- Dynamic Credential Inputs --}}
                    @foreach($form['credentials'] as $key => $value)
                        <flux:input 
                            wire:model="form.credentials.{{ $key }}" 
                            label="{{ str_replace('_', ' ', strtoupper($key)) }}" 
                            type="password"
                            viewable 
                        />
                    @endforeach
                @else
                    <flux:text size="sm">Cash on delivery does not require API credentials.</flux:text>
                @endif
            </div>

            <div class="flex gap-3 mt-8">
                <flux:spacer />
                <flux:button wire:click="$set('editingGateway', null)" variant="ghost">Cancel</flux:button>
                <flux:button wire:click="save" variant="primary">Save Changes</flux:button>
            </div>
        </div>
    </flux:modal>
</section>