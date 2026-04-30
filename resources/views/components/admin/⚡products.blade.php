<?php
use App\Models\{Product, Category};
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Ensure this is imported


new class extends Component {

    use WithFileUploads;
    public $products;
    public $categories;
    public $existingImage;     
    public $showModal = false;
    public $showDeleteModal = false; 
    public $editingId = null, $deletingId = null;

    // Form Fields
    public $name, $price, $tax, $size, $category_id, $key_ingredients, $skin_type = 'All', $stock = 0, $image, $description, $meta_title, $meta_description;

    public function mount() {
        $this->loadProducts();
    }

    public function loadProducts() {
        $this->categories = Category::latest()->get();
        $this->products = Product::with('category')->latest()->get();
    }

    public function openCreateModal() {
        $this->reset(['name', 'price','tax', 'category_id','size','key_ingredients','description', 'skin_type', 'stock', 'image', 'editingId', 'meta_title','meta_description']);
        $this->showModal = true;
    }

    public function edit($id) {
        $product = Product::find($id);
        $this->editingId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->tax = $product->tax;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->existingImage = $product->image;
        $this->size = $product->size;
        $this->key_ingredients = $product->key_ingredients;
        $this->stock = $product->stock;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->showModal = true;
    }

    public function save() {
        $data = $this->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'category_id' => 'required',
            'size' => 'required',
            'stock' => 'required|integer',
        ]);

        $product = Product::updateOrCreate(['id' => $this->editingId], 
        [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price ?: null,
            'tax' => $this->tax ?: null,
            'category_id' => $this->category_id,
            'size' => $this->size,
            'key_ingredients' => $this->key_ingredients,
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
    <flux:table>
        <flux:table.columns sticky>
            <flux:table.column class="pl-1">Product</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Stock</flux:table.column>
            <flux:table.column>Price</flux:table.column>
            <flux:table.column>Tax</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($products as $product)
                <flux:table.row :key="$product->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="lg" src="{{ asset('storage/' . $product->image) }}" />
                        {{ $product->name }}
                    </flux:table.cell>
                    
                    <flux:table.cell><flux:badge size="sm" inset="top bottom">{{ $product->category->name }}</flux:badge></flux:table.cell>
                    <flux:table.cell>{{ $product->stock }} units</flux:table.cell>
                    <flux:table.cell>₹{{ $product->price }}</flux:table.cell>
                    <flux:table.cell>₹{{ $product->tax }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $product->id }})" wire:loading.attr="disabled" size="sm" icon="pencil-square" />
                            <flux:button wire:click="confirmDelete({{ $product->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    {{-- Create/Edit Modal --}}
    <flux:modal wire:model="showModal" class="md:w-[500px] space-y-6" flyout>
        <flux:heading size="lg">{{ $editingId ? 'Edit Product' : 'Add New Product' }}</flux:heading>

        <form wire:submit="save" class="space-y-4">
            <flux:input wire:model="name" label="Product Name" />
            
            <flux:textarea wire:model="description" label="Product Description" placeholder="Product Description" />
            
            <flux:select wire:model="category_id" label="Category">
                <option value="">Select a category...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </flux:select>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="price" type="number" label="Price (₹)" />
                <flux:input wire:model="tax" type="number" label="Tax (%)" />
            </div>
            <flux:input wire:model="stock" type="number" label="Initial Stock" />

            <flux:input wire:model="size" label="Product Size" />
            
            <flux:textarea wire:model="key_ingredients" label="Key Ingredients" placeholder="Key Ingredients" />


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
                <flux:button wire:click="$set('showModal', false)" class="cursor-pointer">Cancel</flux:button>
                <flux:button type="submit" variant="primary" class="cursor-pointer">Save</flux:button>
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