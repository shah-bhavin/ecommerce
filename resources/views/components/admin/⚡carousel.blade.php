<?php
use App\Models\Carousel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $carousels;
    public $title, $subtitle, $link, $image, $sort_order = 0, $is_active = true;
    public $editingId, $deletingId = null;
    public $showModal, $showDeleteModal = false;

    public function mount() {
        $this->loadCarousels();
    }

    public function loadCarousels() {
        $this->carousels = Carousel::orderBy('sort_order')->get();
    }

    public function openCreate() {
        $this->reset(['title', 'subtitle', 'link', 'image', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id) {
        $carousel = Carousel::find($id);
        $this->editingId = $id;
        $this->title = $carousel->title;
        $this->subtitle = $carousel->subtitle;
        $this->link = $carousel->link;
        $this->sort_order = $carousel->sort_order;
        $this->is_active = $carousel->is_active;
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'image' => $this->editingId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'link' => $this->link,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('carousels', 'public');
        }

        if ($this->editingId) {
            Carousel::find($this->editingId)->update($data);
        } else {
            Carousel::create($data);
        }

        $this->showModal = false;
        $this->loadCarousels();
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $carousel = Carousel::find($this->deletingId);
            Storage::disk('public')->delete($carousel->image_path);
            $carousel->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->dispatch('toast', 
                type: 'error', 
                text: 'Carousel Deleted Successfully!'
            );
            $this->loadCarousels();
        }
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Carousel Management</flux:heading>
        <flux:button wire:click="openCreate" variant="primary" icon="plus">Add New Slide</flux:button>
    </div>
    

    <div class="mt-6">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Preview</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Order</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($carousels as $carousel)
                    <flux:table.row :key="$carousel->id">
                        <flux:table.cell>
                            <img src="{{ asset('storage/' . $carousel->image_path) }}" class="w-20 h-12 object-cover rounded border border-zinc-200">
                        </flux:table.cell>
                        <flux:table.cell class="font-medium">{{ $carousel->title ?? 'Untitled' }}</flux:table.cell>
                        <flux:table.cell>{{ $carousel->sort_order }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :variant="$carousel->is_active ? 'success' : 'neutral'" size="sm">
                                {{ $carousel->is_active ? 'Active' : 'Hidden' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button.group>
                                <flux:button wire:click="edit({{ $carousel->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                                <flux:button wire:click="confirmDelete({{ $carousel->id }})" size="sm" variant="danger" icon="trash" />
                            </flux:button.group>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    {{-- Form Modal --}}
    <flux:modal wire:model="showModal" class="md:w-[500px]" flyout>
        <div class="space-y-6">
            <flux:heading size="lg">{{ $editingId ? 'Edit Slide' : 'Create New Slide' }}</flux:heading>

            <form wire:submit="save" class="space-y-4">
                <flux:input wire:model="title" label="Main Title" />
                <flux:input wire:model="subtitle" label="Subtitle" />
                <flux:input wire:model="link" label="Button Link (URL)" />
                <flux:input wire:model="sort_order" type="number" label="Sort Order" />
                
                <flux:field>
                    <flux:label>Slide Image (1920x800 recommended)</flux:label>
                    <input type="file" wire:model="image" class="block w-full text-sm text-zinc-500 border border-zinc-200 p-2 rounded-lg">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-4 h-32 w-full object-cover rounded">
                    @endif
                </flux:field>

                <flux:checkbox wire:model="is_active" label="Set as active" />

                <div class="flex gap-2 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Save Carousel</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal wire:model="showDeleteModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Are you sure?</flux:heading>
                <flux:subheading>
                    Are you sure you want to delete this Carousel?
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