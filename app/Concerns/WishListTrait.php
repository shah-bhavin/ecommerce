<?php

namespace App\Concerns;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait WishListTrait
{
    public function addToBag($productId, $quantity) {
        $product = Product::with('category')->find($productId);
        $cart = session()->get('cart', []);
        $cartKey = $product->id . '-base';
        

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] + $quantity;
        } else {
            $cart[$cartKey] = [
                'user_id' => Auth::id(),
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'tax' => $product->tax,
                'image' => $product->image,
                'quantity' => $quantity,
                'category_name' => $product->category->name
            ];
        }

        session()->put('cart', $cart);
        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId, 'session_id' => session()->getId()],
            ['quantity' => DB::raw($quantity)]
        );
        
        $this->dispatch('toast', 
            type: 'success', 
            text: 'Product added to cart.'
        );
    }   

    public function toggleWishlist($productId) {
        if (!auth()->check()) return redirect()->route('login');
        
        $exists = Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->first();
        if ($exists) { $exists->delete(); } 
        else { Wishlist::create(['user_id' => auth()->id(), 'product_id' => $productId]); }
        
        //$this->dispatch('toast', text: 'Wishlist updated');
        $this->dispatch('toast', 
            type: 'success', 
            text: 'Wishlist updated'
        );
    }

    public function getCategory() {
        return [
            'categories' => Category::get()
        ];
    }
}
