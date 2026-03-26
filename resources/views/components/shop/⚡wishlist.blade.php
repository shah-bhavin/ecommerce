<?php
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $productId;
    public $isWishlisted = false;

    // public function mount($productId) {
    //     $this->productId = $productId;
    //     $this->checkStatus();
    // }

    // public function checkStatus() {
    //     if (Auth::check()) {
    //         $this->isWishlisted = Wishlist::where('user_id', Auth::id())
    //             ->where('product_id', $this->productId)
    //             ->exists();
    //     }
    // }

    // public function toggleWishlist() {
    //     if (!Auth::check()) {
    //         return redirect()->route('login');
    //     }

    //     if ($this->isWishlisted) {
    //         // Remove (Delete)
    //         Wishlist::where('user_id', Auth::id())
    //             ->where('product_id', $this->productId)
    //             ->delete();
    //         $this->isWishlisted = false;
    //     } else {
    //         // Add (Create)
    //         Wishlist::create([
    //             'user_id' => Auth::id(),
    //             'product_id' => $this->productId
    //         ]);
    //         $this->isWishlisted = true;
    //     }

    //     // Dispatch an event to update a wishlist counter elsewhere if needed
    //     $this->dispatch('wishlist-updated');
    // }

    // public function remove($id) {
    //     Wishlist::find($id)->delete();
    // }

    public function with() {
        return ['items' => Wishlist::where('user_id', Auth::id())->with('product')->get()];
    }
};
?>

<div class="max-w-7xl mx-auto px-6 py-20">
    <h1 class="text-4xl font-serif italic mb-12 text-center">Your Wishlist</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @forelse($items as $item)
            <div class="space-y-4">
                <img src="{{ asset('storage/'.$item->product->image) }}" class="aspect-[4/5] object-cover bg-zinc-50">
                <h3 class="text-sm font-serif">{{ $item->product->name }}</h3>
                <button wire:click="remove({{ $item->id }})" class="text-[9px] uppercase underline tracking-widest">Remove</button>
            </div>
        @empty
            <p class="col-span-full text-center text-zinc-400 py-20 italic">No favorites saved yet.</p>
        @endforelse
    </div>
</div>