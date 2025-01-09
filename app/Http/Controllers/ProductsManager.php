<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;



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
        $products = Products::where('slug', $slug)->first();
        $relatedProducts = Products::where('brand', $products->brand)->where('id', '!=', $products->id)->get();

        return view('product_details', compact('products', 'relatedProducts'));
    }

    function searchProduct(Request $request){
        $search = $request->get('search');
        $products = Products::where('title', 'like', '%'.$search.'%')->paginate(12);
        return view('products', compact('products'));
    }

    

}
