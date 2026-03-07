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

<div class="p-6">
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
            <flux:heading size="lg">Product Details</flux:heading>
            
            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="category_id" label="Category">
                    @foreach(Category::all() as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                </flux:select>
                <flux:select wire:model="brand_id" label="Brand">
                    @foreach(Brand::all() as $brand) <option value="{{ $brand->id }}">{{ $brand->name }}</option> @endforeach
                </flux:select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="name" label="Product Name" colspan="2"/>
                <div>
                    <div class="flex items-center gap-4">
                        @if ($base_image  instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                            <img src="{{ $base_image->temporaryUrl() }}"  class="w-16 h-16 rounded-lg object-cover">
                        @elseif ($existingImage)
                            <img src="{{ asset('storage/' . $existingImage) }}" class="w-16 h-16 rounded-lg object-cover" >
                        @endif
                        
                        <flux:input type="file" wire:model="base_image" label="Product Image" />
                    </div>
                    <flux:error name="image" colspan="2"/>
                </div>                
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="base_price" type="number" label="Base Price (₹)" />
                <flux:input wire:model="gst_percentage" type="number" label="GST Percentage" />
            </div>

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
            
            <flux:textarea wire:model="description" label="Category Description" placeholder="Category Description" />
            <flux:separator text="Product Variants (Size/Color)" />

            <div class="space-y-3">
                @foreach($variants as $index => $v)
                    <div class="flex items-end gap-2 p-3 rounded-lg border" wire:key="var-{{ $index }}">
                        <div class="relative w-16 h-16 border rounded-lg overflow-hidden bg-zinc-100 flex-shrink-0">
                            @if (isset($v['new_image']))
                                <img src="{{ $v['new_image']->temporaryUrl() }}" class="object-cover w-full h-full">
                            @elseif (isset($v['variant_image']) && $v['variant_image'])
                                <img src="{{ asset('storage/'.$v['variant_image']) }}" class="object-cover w-full h-full">
                            @else
                                <flux:icon.photo class="m-auto text-zinc-400 mt-4" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <flux:input type="file" wire:model="variants.{{ $index }}.new_image" size="sm" />
                            <flux:error name="variants.{{ $index }}.new_image" />
                        </div>                        
                        <flux:input wire:model="variants.{{ $index }}.sku" label="SKU" placeholder="SKU" />
                        <flux:input wire:model="variants.{{ $index }}.size" label="Size" placeholder="XL" />
                        <flux:input wire:model="variants.{{ $index }}.color" label="Color" placeholder="Red" />
                        <flux:input wire:model="variants.{{ $index }}.stock_quantity" type="number" label="Stock" />
                        <flux:input wire:model="variants.{{ $index }}.price_modifier" type="number" label="+/- Price" />
                        
                        <flux:button wire:click="removeVariant({{ $index }})" variant="ghost" icon="trash" color="danger" />
                    </div>
                @endforeach
                <flux:button wire:click="addVariant" variant="ghost" size="sm" icon="plus">Add Another Variant</flux:button>
            </div>

            <div class="flex justify-end gap-2">
                <flux:button wire:click="$set('showModal', false)">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Product</flux:button>
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