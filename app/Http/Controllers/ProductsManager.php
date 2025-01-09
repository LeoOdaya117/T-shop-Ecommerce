<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;



class ProductsManager extends Controller
{
    
    function showProducts(){
        $products = Products::paginate(12);
        return view('products', compact('products'));
    }
    function showProductsByCategory(){
        $productsCategory = Products::where('category', 'Clothing')->paginate(12);  

        return view('home', compact('products'));
    }
    
    function showDetails($slug){
        $products = Products::where('slug', $slug)->first();
        $relatedProducts = Products::where('brand', $products->brand)->where('id', '!=', $products->id)->paginate(6);

        return view('product_details', compact('products', 'relatedProducts'));
    }

    function searchProduct(Request $request){
        $search = $request->get('search');
        $products = Products::where('title', 'like', '%'.$search.'%')->paginate(12);
        return view('products', compact('products'));
    }

    public function index()
    {
        $products = Products::paginate(12);
        $popularProducts = collect(); // Initialize as an empty collection
        $categories = Category::all();
        if (auth()->check()) {
            $cartController = new CartManager();
            $cartController->updateCartTotal();
            
            $popularProducts = $this->getPopularProducts();
        }

        return view('home', compact('products', 'popularProducts', 'categories'));
    }

    private function getPopularProducts()
    {
        // Retrieve all orders
        $orders = Orders::all();

        // Initialize an array to store the aggregated quantities
        $productQuantities = [];

        // Process each order
        foreach ($orders as $order) {
            $productIds = json_decode($order->product_id);
            $quantities = json_decode($order->quantity);

            // Aggregate quantities for each product
            foreach ($productIds as $index => $productId) {
                if (isset($productQuantities[$productId])) {
                    $productQuantities[$productId] += $quantities[$index];
                } else {
                    $productQuantities[$productId] = $quantities[$index];
                }
            }
        }

        // Sort the products by quantity in descending order
        arsort($productQuantities);

        // Get the top 12 product IDs
        $topProductIds = array_slice(array_keys($productQuantities), 0, 12);

        // Fetch the products based on the top product IDs
        $popularProducts = Products::whereIn('id', $topProductIds)->get();

        return $popularProducts;
    }
    

}
