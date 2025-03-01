<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartManager extends Controller
{
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'required|exists:product_variants,id'
        ]);
        // Check if the product already exists in the user's cart
        $cart = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $request->productId)
                    ->where('variant_id', $request->variant_id)
                    ->first();

        if ($cart) {
            // If the product exists in the cart, update the quantity
            $cart->quantity += $request->quantity; // Increase the quantity by the selected amount
            $cart->save();
            

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Item updated in the cart.'
            ]);
        } else {
            // If the product does not exist, add it to the cart
            $cart = new Cart();
            $cart->user_id = auth()->user()->id; // Getting the User ID in the AUTH
            $cart->product_id = $request->productId;
            $cart->variant_id = $request->variant_id;
            $cart->quantity = $request->quantity;

            if ($cart->save()) {
                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => 'Added to the cart.'
                ]);
               
            }
        }

        if (auth()->check()) {
            $this->updateCartTotal();
            $cartItemCount = CartManager::updateCartTotal(); // Logic to compute the new count
    
            session(['cartItemCount' => $cartItemCount]); // Update session
        }
        if ($cart->save()) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Something went wrong'
            ]);
           
        }
      
    }


    function showCart(){
        $authManager = new AuthManager();
        $authManager->sessionCheck();
    
        
        // $cartItems = DB::table("cart")
        // ->join("products",'cart.product_id', '=', 'products.id')
        // ->select("cart.product_id", "cart.quantity", 'products.title', 'cart.id','products.price', 'products.image', 'products.slug','products.discount')
        // ->where("cart.user_id", auth()->user()->id)->get();

        $cartItems = Cart::with(['variant','product'])
        ->where('user_id', auth()->user()->id)
        ->get();
        // dd($cartItems);
        $cartTotal = $cartItems->count(); // Count the distinct items in the cart
        Session::put( Session::put('cartTotal', $cartTotal));
        // Return view with cart items and cart total
        return view('cart', compact('cartItems', 'cartTotal'));
    }

    public function updateCartTotal()
    {
        // Calculate the total number of distinct items in the cart for the authenticated user
        if(Auth::check()){
            $userId = auth()->user()->id;
            $cartTotal = Cart::where('user_id', $userId)->count();
            $wishlistCount = Wishlist::where('user_id', $userId)->count();
       
            return response()->json([
                'cartTotal' => $cartTotal,
                'wishlistTotal' => $wishlistCount
            ]);
            
        }else{
            return response()->json([
                'cartTotal' => 0,
                'wishlistTotal' => 0
            ]);
        }
        
        // Session::put('cartTotal', $cartTotal);
     
        
    }

    public function deleteFromCart($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($cart) {
            $cart->delete();
            return response()->json(['success' => 'Product has been removed from the cart.']);
        } else {
            return response()->json(['error' => 'Product not found in the cart.'], 404);
        }
    }

    function updateQuantity($id, $quantity){
        if(!Auth::check()){
            return response()->json(['error' => 'You need to be logged in to update the cart.'], 401);
        }
        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($cart) {
            $cart->quantity = $quantity;
            $cart->save();
            return response()->json(['success' => 'Product quantity has been updated.']);
        } else {
            return response()->json(['error' => 'Product not found in the cart.'], 404);
        }
    }
}
