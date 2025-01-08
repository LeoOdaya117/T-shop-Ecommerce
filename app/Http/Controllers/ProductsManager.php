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
            $cartController = new CartManager();
            $cartController->updateCartTotal();
        }
        return view('products', compact('products'));
    }

    function showDetails($slug){
        $products = Products::where('slug',$slug)->first();
        return view('product_details', compact('products'));
    }

    

}
