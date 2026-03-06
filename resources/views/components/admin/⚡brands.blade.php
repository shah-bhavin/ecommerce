<?php
use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads; // Import for images
use Illuminate\Support\Facades\Storage; // Ensure this is imported

new class extends Component
{
    use WithFileUploads;

    public $brands;
    public $name, $description, $meta_title, $meta_description;
    public $editingId, $deletingId;

    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $search = '';

    public $is_active = true;   

    public $logo;          
    public $existingLogo;     
    public $showModal = false;
    public $showDeleteModal = false; 

    public function brands() {
        return Brand::query()
        ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->paginate(25);
    }

    public function create() {
        $this->resetForm();
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
        $brand = Brand::find($id);
        if($brand->is_active == 0){$is_active = false;}elseif($brand->is_active == 1){$is_active = true;};

        $this->editingId = $id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->is_active = $is_active;
        $this->existingLogo = $brand->logo;
        $this->meta_title = $brand->meta_title;
        $this->meta_description = $brand->meta_description;        
        $this->showModal = true;
    }

    public function save() {
        $this->validate(['name' => 'required|min:3', 'logo' => 'nullable|image|max:1024']);

        $brand = Brand::updateOrCreate(['id' => $this->editingId], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_active' => $this->is_active,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ]);

        if ($this->logo) {
            // Delete the file first
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $path = $this->logo->store('brands', 'public');
            $brand->update(['logo' => $path]);
        }

        $this->resetForm();
        session()->flash('status', 'Brand Updated successfully!');
        session()->flash('variant', 'success'); 
        $this->brands();
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $brand = Brand::find($this->deletingId);
        
            // Delete the file first
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $brand->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->categories();
        }
    }

    private function resetForm(){
         $this->reset(['name', 'description', 'logo', 'is_active',  'editingId','meta_title','meta_description', 'showModal']);
    }

};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Brands</flux:heading>
        <flux:button wire:click="create" variant="primary" icon="plus">Add Brands</flux:button>
    </div>

    <div class="flex gap-2 mb-4">
        <flux:input icon:trailing="magnifying-glass" placeholder="Search Brands..." wire:model.live="search" />
    </div>
    
    @if (session()->has('status'))
        <flux:callout :variant="session('variant', 'primary')" icon="check-circle" dismissible class="mb-4">
            {{ session('status') }}
        </flux:callout>
    @endif

    <flux:table :paginate="$this->brands">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->brands() as $brand)
                <flux:table.row :key="$brand->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="lg" src="{{ asset('storage/' . $brand->logo) }}" />
                        {{ $brand->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {!! $brand->is_active == 1 ? '<flux:badge color="lime" size="sm">Active</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">Inactive</flux:badge>' !!}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $brand->id }})" wire:loading.attr="disabled" size="sm" icon="pencil" />
                            <flux:button wire:click="confirmDelete({{ $brand->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal wire:model="showModal" class="md:w-200" flyout>
        <form wire:submit="save" class="space-y-4">
            <flux:heading size="lg">{{ $editingId ? 'Edit' : 'Add' }} Brands</flux:heading>

            <flux:input wire:model="name" label="Brand Name" placeholder="e.g. Ethnic Wear" autofocus/>
            
            <flux:textarea wire:model="description" label="Brand Description" placeholder="Brand Description" />

            <div class="flex items-center gap-4">
                @if ($logo)
                    <img src="{{ $logo->temporaryUrl() }}"  class="w-16 h-16 rounded-lg object-cover">
                @elseif ($existingLogo)
                    <img src="{{ asset('storage/' . $existingLogo) }}" class="w-16 h-16 rounded-lg object-cover" >
                @endif
                
                <flux:input type="file" wire:model="logo" />
            </div>
            <flux:error name="logo" />

            <div class="grid grid-cols-2 gap-4 pt-2">
                <flux:field variant="inline">
                    <flux:label>Active Status</flux:label>
                    <flux:description>Visible on store</flux:description>
                    <flux:switch wire:model="is_active" color="green" />
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