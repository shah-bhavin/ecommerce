<?php
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $productId;
    public $isWishlisted = false;

    public function mount($productId) {
        $this->productId = $productId;
        $this->checkStatus();
    }

    public function checkStatus() {
        if (Auth::check()) {
            $this->isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->exists();
        }
    }

    public function toggleWishlist() {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isWishlisted) {
            // Remove (Delete)
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->delete();
            $this->isWishlisted = false;
        } else {
            // Add (Create)
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId
            ]);
            $this->isWishlisted = true;
        }

        // Dispatch an event to update a wishlist counter elsewhere if needed
        $this->dispatch('wishlist-updated');
    }
};
?>

<div>
    <flux:button 
        wire:click="toggleWishlist" 
        variant="ghost" 
        size="sm" 
        :icon="$isWishlisted ? 'heart' : 'heart'" 
        :class="$isWishlisted ? 'text-red-500 fill-current' : 'text-zinc-400'"
        wire:loading.attr="disabled"
    >
        {{ $isWishlisted ? 'Saved' : 'Wishlist' }}
    </flux:button>
</div>