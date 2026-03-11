<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads; // Import for images
use Illuminate\Support\Facades\Storage; // Ensure this is imported

new class extends Component
{
    use WithFileUploads;

    public $categories;
    public $name, $parent_id, $description, $meta_title, $meta_description;
    public $editingId, $deletingId;

    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $search = '';

    public $is_active = true;   
    public $is_featured = false;
    public $image;             
    public $existingImage;     
    public $showModal = false;
    public $showDeleteModal = false; 

    

    public function categories() {
        return Category::query()->with(['parent'])
        ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->paginate(25);
    }

    public function create() {
        $this->reset();
        $this->showModal = true;
    }

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function edit($id) {
        $category = Category::find($id);
        if($category->is_active == 0){$is_active = false;}elseif($category->is_active == 1){$is_active = true;};
        if($category->is_featured == 0){$is_featured = false;}elseif($category->is_featured == 1){$is_featured = true;};

        $this->editingId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;        
        $this->is_active = $is_active;
        $this->is_featured = $is_featured;
        $this->existingImage = $category->image;
        $this->meta_title = $category->meta_title;
        $this->meta_description = $category->meta_description;        
        $this->showModal = true;
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
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ]);

        if ($this->image) {
            // Delete the file first
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $path = $this->image->store('categories', 'public');
            $category->update(['image' => $path]);
        }

        $this->reset();
        session()->flash('status', 'Category Updated successfully!');
        session()->flash('variant', 'success'); 
        $this->categories();
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $category = Category::find($this->deletingId);
        
            // Delete the file first
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->categories();
        }
    }

    private function resetForm(){
        $this->reset(['name', 'description', 'parent_id', 'image', 'is_active', 'is_featured', 'editingId','meta_title','meta_description', 'showModal']);
    }

}

?>


<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Categories</flux:heading>
        <flux:button wire:click="create" variant="primary" icon="plus">Add Category</flux:button>
    </div>

    <div class="flex gap-2 mb-4">
        <flux:input icon:trailing="magnifying-glass" placeholder="Search Category..." wire:model.live="search" />
    </div>
    
    @if (session()->has('status'))
        <flux:callout :variant="session('variant', 'primary')" icon="check-circle" dismissible class="mb-4">
            {{ session('status') }}
        </flux:callout>
    @endif

    <flux:table :paginate="$this->categories()">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column>Featured</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Parent</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->categories() as $category)
                <flux:table.row :key="$category->id">
                    <!-- <flux:table.cell>{{ $category->name }}</flux:table.cell> -->
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="lg" src="{{ asset('storage/' . $category->image) }}" />
                        {{ $category->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {!! $category->is_featured == 1 ? '<flux:badge color="lime" size="sm">Yes</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">No</flux:badge>' !!}
                    </flux:table.cell>
                    <flux:table.cell>
                        {!! $category->is_active == 1 ? '<flux:badge color="lime" size="sm">Active</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">Inactive</flux:badge>' !!}
                    </flux:table.cell>
                    <flux:table.cell>{{ $category->parent?->name ?? 'None' }}</flux:table.cell>   
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $category->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                            <flux:button wire:click="confirmDelete({{ $category->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal wire:model="showModal" class="md:w-200" flyout>
        <form wire:submit="save" class="space-y-4">
            <flux:heading size="lg">{{ $editingId ? 'Edit' : 'Add' }} Category</flux:heading>
            
            <flux:select wire:model="parent_id" label="Parent Category">
                <option value="">None</option>
                @foreach($this->categories()->whereNull('parent_id') as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model="name" label="Category Name" placeholder="e.g. Ethnic Wear" autofocus/>
            
            <flux:textarea wire:model="description" label="Category Description" placeholder="Category Description" />

            <div class="flex items-center gap-4">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"  class="w-16 h-16 rounded-lg object-cover">
                @elseif ($existingImage)
                    <img src="{{ asset('storage/' . $existingImage) }}" class="w-16 h-16 rounded-lg object-cover" >
                @endif
                
                <flux:input type="file" wire:model="image" />
            </div>
            <flux:error name="image" />

            <div class="grid grid-cols-2 gap-4 pt-2">
                <flux:field variant="inline">
                    <flux:label>Active Status</flux:label>
                    <flux:description>Visible on store</flux:description>
                    <flux:switch wire:model="is_active" color="green" />
                </flux:field>

                <flux:field variant="inline">
                    <flux:label>Featured</flux:label>
                    <flux:description>Show on homepage</flux:description>
                    <flux:switch wire:model="is_featured" color="indigo" />
                </flux:field>
            </div>

            <flux:separator />
            <flux:input wire:model="meta_title" label="Meta Title" placeholder="e.g. Meta Title" />
            
            <flux:textarea wire:model="meta_description" label="Meta Description" placeholder="Meta Description" />


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
