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
    public function addToBag($productId) {
        $product = Product::find($productId);
        $cart = session()->get('cart', []);
        $cartKey = $product->id . '-base';

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'variant_id' => null,
                'variant_name' => 'Standard'
            ];
        }

        session()->put('cart', $cart);
        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            ['quantity' => DB::raw('quantity + 1')]
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
