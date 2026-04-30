<?php

namespace App\Concerns;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

trait WishListTrait
{
    public $count = 0;
    
    public function addToBag($productId, $quantity) {
        $product = Product::with('category')->find($productId);
        $cart = session()->get('cart', []);
        $cartKey = $product->id . '-base';
        

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'user_id' => Auth::id(),
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'tax' => $product->tax,
                'image' => $product->image,
                'quantity' => $quantity,
                'category_name' => $product->category->name ?? 'Uncategorized'
            ];
        }

        session()->put('cart', $cart);

        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId, 'session_id' => session()->getId()],
            ['quantity' => $cart[$cartKey]['quantity']] // Use the updated total quantity
        );
        
        // Correct: Double quotes allow the variable to be evaluated
        $this->dispatch('toast', type: 'success', text: "{$product->name} added to cart.");


        // 2. Trigger the Cart Counter to refresh in the top-navigation
        $this->dispatch('cart-updated')->to('store.cart-counter'); 
            }   

    public function toggleWishlist($productId) {
        if (!auth()->check()) {
            return $this->dispatch('toast', type: 'error', text: 'Please login to manage wishlist.');
        }
        
        $exists = Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->first();

    if ($exists) { 
            $exists->delete();
            $message = 'Removed from wishlist';
        } else { 
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $productId]); 
            $message = 'Added to wishlist';
        }
        
        // Trigger Toast and Refresh UI[cite: 9, 10]
        $this->dispatch('toast', type: 'success', text: $message);
        
        // This tells the UI to update the "Heart" icon color immediately
        $this->dispatch('wishlist-updated');
    }

}
