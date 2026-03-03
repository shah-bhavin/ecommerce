<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads; // Import for images

new class extends Component
{
    use WithFileUploads;
    public $categories;
    public $name, $parent_id, $editingId, $deletingId, $description;
    public $is_active = true;   
    public $is_featured = false;
    public $image;             
    public $existingImage;     
    public $showModal = false;
    public $showDeleteModal = false; 

    public function mount() {
        $this->loadCategories();
    }

    public function loadCategories() {
        $this->categories = Category::with('parent')->get();
    }

    public function save() {
        $this->validate(['name' => 'required|min:3', 'image' => 'nullable|image|max:1024']);

        $category = Category::updateOrCreate(['id' => $this->editingId], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'parent_id' => $this->parent_id ?: null,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ]);

        if ($this->image) {
            // Save image path to DB (assuming 'image' column exists)
            $path = $this->image->store('categories', 'public');
            $category->update(['image' => $path]);
        }

        $this->reset(['name', 'parent_id', 'editingId', 'showModal']);
        session()->flash('status', 'Category removed successfully!');
        session()->flash('variant', 'success'); // Change to 'danger' for errors
        $this->loadCategories();
    }

    public function edit($id) {
        $category = Category::find($id);
        $this->editingId = $id;
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
        $this->showModal = true;
    }

    // Step 1: Open the confirmation modal and store the ID
    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    // Step 2: Execute the deletion
    public function delete() {
        if ($this->deletingId) {
            Category::find($this->deletingId)->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->loadCategories();

        }
    }

};
?>

<div>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="xl">Categories</flux:heading>
            <flux:button wire:click="$set('showModal', true)" variant="primary" icon="plus">Add Category</flux:button>
        </div>
        @if (session()->has('status'))
            <flux:callout :variant="session('variant', 'primary')" icon="check-circle" dismissible class="mb-4">
                {{ session('status') }}
            </flux:callout>
        @endif
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Parent</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($categories as $category)
                    <flux:table.row :key="$category->id">
                        <flux:table.cell>{{ $category->name }}</flux:table.cell>
                        <flux:table.cell>{{ $category->parent?->name ?? 'None' }}</flux:table.cell>

                        

                        <flux:table.cell>
                            <flux:button.group>
                                <flux:button wire:click="edit({{ $category->id }})" wire:loading.attr="disabled" size="sm" icon="pencil" />
                                <flux:button wire:click="confirmDelete({{ $category->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                            </flux:button.group>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        <flux:modal wire:model="showModal" class="md:w-96" flyout>
            <form wire:submit="save" class="space-y-4">
                <flux:heading size="lg">{{ $editingId ? 'Edit' : 'Add' }} Category</flux:heading>
                
                <flux:select wire:model="parent_id" label="Parent Category">
                    <option value="">None</option>
                    @foreach($categories->whereNull('parent_id') as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="name" label="Category Name" placeholder="e.g. Ethnic Wear" />
                
                <flux:textarea wire:model="description" label="Category Description" placeholder="Category Description" />

                <div class="flex items-center gap-4">
                    @if ($image)
                        <flux:avatar src="{{ $image->temporaryUrl() }}"  class="w-16 h-16 rounded-lg object-cover">
                    @elseif ($existingImage)
                        <flux:avatar src="{{ asset('storage/' . $existingImage) }}" class="w-16 h-16 rounded-lg object-cover" >
                    @endif
                    
                    <flux:input type="file" wire:model="image" />
                </div>
                <flux:error name="image" />
                

                <div class="flex justify-end space-x-2">
                    <flux:button wire:click="$set('showModal', false)">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">Save</flux:button>
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
</div>