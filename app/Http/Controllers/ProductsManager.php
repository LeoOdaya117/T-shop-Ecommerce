<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Session;



class ProductsManager extends Controller
{
    function index(){
        $products = Products::paginate(12);
        if (auth()->check()) {
            $this->updateCartTotal();
        }
        return view('products', compact('products'));
    }

    function showDetails($slug){
        $products = Products::where('slug',$slug)->first();
        return view('product_details', compact('products'));
    }

    public function addToCart($id, $quantity)
    {
        // Check if the product already exists in the user's cart
        $cart = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            // If the product exists in the cart, update the quantity
            $cart->quantity += $quantity; // Increase the quantity by the selected amount
            $cart->save();
            

            return response()->json(['success' => 'Product quantity has been updated in the cart.']);
        } else {
            // If the product does not exist, add it to the cart
            $cart = new Cart();
            $cart->user_id = auth()->user()->id; // Getting the User ID in the AUTH
            $cart->product_id = $id;
            $cart->quantity = $quantity;

            if ($cart->save()) {
                return response()->json(['success' => 'Product has been added to the cart.']);
            }
        }

        if (auth()->check()) {
            $this->updateCartTotal();
        }

        return response()->json(['error' => 'Something went wrong']);
    }

    function showCart(){
        
        $cartItems = DB::table("cart")
        ->join("products",'cart.product_id', '=', 'products.id')
        ->select("cart.product_id", "cart.quantity", 'products.title', 'products.price', 'products.image', 'products.slug')
        ->where("cart.user_id", auth()->user()->id)->get();

        $cartTotal = $cartItems->count(); // Count the distinct items in the cart
        Session::put( Session::put('cartTotal', $cartTotal));
        // Return view with cart items and cart total
        return view('cart', compact('cartItems', 'cartTotal'));
    }

    function updateCartTotal()
    {
        // Calculate the total number of distinct items in the cart for the authenticated user
        $cartTotal = DB::table('cart')
            ->where('user_id', auth()->user()->id)
            ->count(); // Count distinct cart items

        // Store the cart total in the session
        Session::put('cartTotal', $cartTotal);
        
    }

}
