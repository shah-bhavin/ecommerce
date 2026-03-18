<?php
use App\Models\{Product, Category};
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Ensure this is imported


new class extends Component {

    use WithFileUploads;
    public $products;
    public $existingImage;     
    public $showModal = false;
    public $showDeleteModal = false; 
    public $editingId = null, $deletingId = null;

    // Form Fields
    public $name, $price, $category = 'Cream', $skin_type = 'All', $stock = 0, $image, $description, $meta_title, $meta_description;

    public function mount() {
        $this->loadProducts();
    }

    public function loadProducts() {
        $this->products = Product::latest()->get();
    }

    public function openCreateModal() {
        $this->reset(['name', 'price', 'category', 'skin_type', 'stock', 'image', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id) {
        $product = Product::find($id);
        $this->editingId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->category = $product->category;
        $this->description = $product->description;
        $this->existingImage = $product->image;
        $this->skin_type = $product->skin_type;
        $this->stock = $product->stock;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->showModal = true;
    }

    public function save() {
        $data = $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'category' => 'required',
            'skin_type' => 'required',
            'stock' => 'required|integer',
        ]);

        $product = Product::updateOrCreate(['id' => $this->editingId], 
        [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price ?: null,
            'category' => $this->category,
            'skin_type' => $this->skin_type,
            'stock' => $this->stock,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ]);

        if ($this->image && !is_string($this->image)) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $this->image->store('products', 'public');
            $product->update(['image' => $path]);
        }


        $this->showModal = false;
        $this->dispatch('toast', 
            type: 'success', 
            text: 'Category saved Successfully!'
        );
        $this->loadProducts();
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $product = Product::find($this->deletingId);
        
            // Delete the file first
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->dispatch('toast', 
                type: 'error', 
                text: 'Product Removed Successfully!'
            );
            $this->loadProducts();
        }
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
        <flux:heading size="xl">Skincare Inventory</flux:heading>
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus">Add Product</flux:button>
    </div>

    {{-- Data Table --}}
    <flux:card class="p-0 overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column class="pl-1">Product</flux:table.column>
                <flux:table.column>Category</flux:table.column>
                <flux:table.column>Stock</flux:table.column>
                <flux:table.column>Price</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach($products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell class="font-medium">{{ @$product->name }}</flux:table.cell>
                        <flux:table.cell><flux:badge size="sm" inset="top bottom">{{ $product->category }}</flux:badge></flux:table.cell>
                        <flux:table.cell>{{ $product->stock }} units</flux:table.cell>
                        <flux:table.cell>₹{{ $product->price }}</flux:table.cell>
                        <flux:table.cell>
                            <!-- <flux:button wire:click="edit({{ $product->id }})" variant="ghost" size="sm" icon="pencil-square" />
                            <flux:button wire:click="delete({{ $product->id }})" wire:confirm="Delete this product?" variant="ghost" size="sm" icon="trash" color="danger" /> -->
                            <flux:button.group>
                                <flux:button wire:click="edit({{ $product->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                                <flux:button wire:click="confirmDelete({{ $product->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                            </flux:button.group>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-[500px] space-y-6" flyout>
        <flux:heading size="lg">{{ $editingId ? 'Edit Product' : 'Add New Product' }}</flux:heading>

        <form wire:submit="save" class="space-y-4">
            <flux:input wire:model="name" label="Product Name" />
            
            <flux:textarea wire:model="description" label="Product Description" placeholder="Product Description" />

            
            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="category" label="Category">
                    <option value="Cream">Cream</option>
                    <option value="Lotion">Lotion</option>
                    <option value="Gel">Gel</option>
                </flux:select>
                <flux:select wire:model="skin_type" label="Skin Type">
                    <option value="All">All Types</option>
                    <option value="Oily">Oily</option>
                    <option value="Dry">Dry</option>
                </flux:select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="price" type="number" label="Price (₹)" />
                <flux:input wire:model="stock" type="number" label="Initial Stock" />
            </div>

            <!-- <flux:input wire:model="image" type="file" label="Product Image" /> -->
            <div class="flex items-center gap-4">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}"  class="w-16 h-16 rounded-lg object-cover">
                @elseif ($existingImage)
                    <img src="{{ asset('storage/' . $existingImage) }}" class="w-16 h-16 rounded-lg object-cover" >
                @endif
                
                <flux:input type="file" wire:model="image" label="Product Image" />
            </div>
            <flux:error name="image" />
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
                    Are you sure you want to delete this product?
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