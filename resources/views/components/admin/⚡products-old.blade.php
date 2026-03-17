<?php

use App\Models\{Product, Category, Brand, ProductVariant};
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Ensure this is imported

new class extends Component {
    use WithFileUploads;

    public $products;

    public $editingId, $deletingId;

    public $name, $category_id, $brand_id, $slug, $description, $base_image, $base_price,$gst_percentage, $status;

    public $is_active = true;   
    public $is_featured = false;

    public $existingImage;
    public $showModal = false;
    public $showDeleteModal = false;

    // Dynamic Variants Array
    public $variants = [];

    public function mount() {
        $this->addVariant(); // Start with one empty variant row
    }

    public function addVariant() {
        $this->variants[] = ['size' => '', 'color' => '', 'sku' => '', 'variant_image' => '', 'stock' => 0, 'price_modifier' => 0];
    }

    public function removeVariant($index) {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function openCreateModal() {
        $this->reset(['name', 'category_id', 'brand_id', 'description', 'base_price', 'base_image', 'editingId']);
        $this->variants = [];
        $this->addVariant();
        $this->showModal = true;
    }

    public function edit($id) {
        $this->reset(['base_image']);
        $product = Product::with('variants')->findOrFail($id);
        
        $this->editingId = $id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->description = $product->description;
        $this->base_price = $product->base_price;
        $this->gst_percentage = $product->gst_percentage;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->existingImage = $product->base_image;       

        $this->variants = $product->variants->toArray();
        $this->showModal = true;
    }

    public function save() {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required',
            'base_price' => 'required|numeric',
            'variants.*.sku' => 'required|distinct',
            'variants.*.stock_quantity' => 'required|numeric',
        ]);

        $product = Product::updateOrCreate(['id' => $this->editingId], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'base_price' => $this->base_price,
        ]);

        

        if ($this->base_image) {
            if ($product->base_image) {
                Storage::disk('public')->delete($product->base_image);
            }
            $path = $this->base_image->store('products/'.$product->id, 'public');
            $product->update(['base_image' => $path]);
        }

        $product->variants()->delete();
            foreach ($this->variants as $index => $v) {
                $variantPath = $v['variant_image'] ?? null;

                if (isset($v['new_image']) && $v['new_image'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    if ($variantPath) Storage::disk('public')->delete($variantPath);
                    $variantPath = $v['new_image']->store('variants/'.$product->id, 'public');
                }

                $product->variants()->updateOrCreate(
                    ['sku' => $v['sku']], 
                    [
                        'size' => $v['size'],
                        'color' => $v['color'],
                        'stock_quantity' => $v['stock_quantity'],
                        'price_modifier' => $v['price_modifier'],
                        'variant_image' => $variantPath,
                    ]
                );
            }

        $this->showModal = false;
        session()->flash('message', 'Product & Variants Saved!');
    }

    public function confirmDelete($id) {
        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete() {
        if ($this->deletingId) {
            $product = Product::find($this->deletingId);
        
            // Delete the file first
            if ($product->base_image) {
                Storage::disk('public')->delete($product->base_image);
            }

            $product->delete();
            $this->reset('deletingId', 'showDeleteModal');
            $this->products();
        }
    }

    public function products(){
        return Product::all();
    }
    
};
?>

<div>
    <div class="flex justify-between mb-6">
        <flux:heading size="xl">Product Catalog</flux:heading>
        <flux:button wire:click="openCreateModal" variant="primary">Add Product</flux:button>
    </div>

    <div class="flex gap-2 mb-4">
        <flux:input icon:trailing="magnifying-glass" placeholder="Search Product..." wire:model.live="search" />
    </div>
    
    @if (session()->has('status'))
        <flux:callout :variant="session('variant', 'primary')" icon="check-circle" dismissible class="mb-4">
            {{ session('status') }}
        </flux:callout>
    @endif

    <flux:table :paginate="$this->products">
        <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Featured</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Parent</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->products() as $product)
                <flux:table.row :key="$product->id">
                    <!-- <flux:table.cell>{{ $product->name }}</flux:table.cell> -->
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="lg" src="{{ asset('storage/' . $product->base_image) }}" />
                        {{ $product->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {!! $product->is_featured == 1 ? '<flux:badge color="lime" size="sm">Yes</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">No</flux:badge>' !!}
                    </flux:table.cell>
                    <flux:table.cell>
                        {!! $product->is_active == 1 ? '<flux:badge color="lime" size="sm">Active</flux:badge>' : 
                        '<flux:badge color="zinc" size="sm">Inactive</flux:badge>' !!}
                    </flux:table.cell>
                    <flux:table.cell>{{ $product->parent?->name ?? 'None' }}</flux:table.cell>   
                    <flux:table.cell>
                        <flux:button.group>
                            <flux:button wire:click="edit({{ $product->id }})" wire:loading.attr="disabled" size="sm" icon="pencil" />
                            <flux:button wire:click="confirmDelete({{ $product->id }})" wire:loading.attr="disabled" size="sm" variant="danger" icon="trash" />                                
                        </flux:button.group>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


    <flux:modal wire:model="showModal" class="md:w-200" flyout>
        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:card class="space-y-4">
                    <flux:heading size="lg">Product Details</flux:heading>
                    <flux:input wire:model="name" label="Product Name (e.g., Charcoal Face Gel)" />
                    
                    <flux:select wire:model="skin_type" label="Recommended Skin Type">
                        <option value="all">All Skin Types</option>
                        <option value="oily">Oily / Acne Prone</option>
                        <option value="dry">Dry / Dehydrated</option>
                        <option value="sensitive">Sensitive</option>
                    </flux:select>

                    <flux:textarea wire:model="ingredients" label="Ingredients List (INCI)" rows="3" />
                    <flux:textarea wire:model="how_to_use" label="Application Instructions" rows="2" />
                </flux:card>

                <flux:card class="space-y-4">
                    <div class="flex justify-between items-center">
                        <flux:heading size="lg">Size Variants</flux:heading>
                        <flux:button wire:click="addVariant" size="sm" icon="plus">Add Size</flux:button>
                    </div>

                    @foreach($variants as $index => $v)
                        <div class="p-4 border rounded-xl space-y-3" wire:key="var-{{ $index }}">
                            <div class="flex gap-3">
                                <flux:input wire:model="variants.{{ $index }}.volume" label="Volume (e.g. 50ml)" placeholder="100ml" />
                                <flux:input wire:model="variants.{{ $index }}.sku" label="SKU" />
                            </div>
                            <div class="flex gap-3">
                                <flux:input wire:model="variants.{{ $index }}.price_modifier" type="number" label="Price (₹)" />
                                <flux:input wire:model="variants.{{ $index }}.stock_quantity" type="number" label="Stock" />
                                <flux:button wire:click="removeVariant({{ $index }})" icon="trash" variant="ghost" color="danger" class="mt-6" />
                            </div>
                        </div>
                    @endforeach
                </flux:card>
            </div>
        </form>
    </flux:modal>

    <flux:modal wire:model="showDeleteModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Are you sure?</flux:heading>
                <flux:subheading>
                    Are you sure you want to delete this Product?
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