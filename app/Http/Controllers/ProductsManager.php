<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;

use DataTable;

class ProductsManager extends Controller
{
    
    function showProducts(){
        $products = Products::paginate(12);
        return view('products', compact('products'));
    }
    function showProductsByCategory( $categoryId){
        $categoryId =(int) $categoryId;
        $products = Products::where('category', $categoryId)->paginate(12); 
        $categories = Category::select('name')->where('id', $categoryId)->get();

        return view('products', compact('products', 'categories'));
    }
    
    function showDetails($slug){
        $products = Products::where('slug', $slug)->first();
        $relatedProducts = Products::where('brand', $products->brand)->where('id', '!=', $products->id)->paginate(6);
        $categories = Category::select('name')->where('id', $products->category)->get();
        return view('product_details', compact('products', 'relatedProducts', 'categories'));
    }

    function searchProduct(Request $request){
        $search = $request->get('search');
        $products = Products::where('title', 'like', '%'.$search.'%')->paginate(20);
        return view('products', compact('products'));
    }

    public function index()
    {
        
        $products = Products::paginate(8);
        $popularProducts = collect(); // Initialize as an empty collection
        $categories = Category::all();
        $cartItemCount = 0;
        $popularProducts = $this->getPopularProducts();
        if (auth()->check()) {
            $cartController = new CartManager();
            $cartController->updateCartTotal();
            $cartItemCount = $cartController->updateCartTotal();

            
        }

        return view('home', compact('products', 'popularProducts', 'categories', 'cartItemCount'));
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
    
    public function loadMoreProducts(Request $request)
    {
        $skip = (int) $request->skip;
        $take = 8; // Number of products to load per request
        $products = Products::skip($skip)->take($take)->get();
        $totalProducts = Products::count();

        $hasMore = ($skip + $take) < $totalProducts;

        return response()->json([
            'html' => view('partials.product-cards', compact('products'))->render(),
            'hasMore' => $hasMore
        ]);
    }

    function updateProducts($id, $quantity){
        $product = Products::where('id', $id)->first()->update(['stocks' => $quantity]);
        if ($product) {
            return response()->json(['success' => 'Product updated successfully']);
        }
        return response()->json(['error' => 'Something went wrong']);
    }

    public function getProducts(Request $request)
    {
        $categories = Category::all();
    
        // Retrieve filter inputs
        $search = $request->input('search');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status') ?? 'active';
    
        // Build the query
        $products = Products::query();
    
        // Apply search filter
        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
    
        // Apply category filter
        if ($category) {
            $products->where('category', $category);
        }
    
        // Apply price range filter
        if ($minPrice || $maxPrice) {
            $products->whereBetween('price', [
                $minPrice ?? 0, // Default to 0 if no min price is provided
                $maxPrice ?? PHP_INT_MAX // Default to maximum value if no max price is provided
            ]);
        }
    
        // Apply status filter
        if ($status) {
            $products->where('status', $status);
        }
    
        // Fetch paginated results
        $products = $products->paginate(10);
    
        return view('admin.products.manage-products', compact('products', 'categories'));
    }
    

    

    
    


    function showEditPage($id) {
        $productInfo = Products::where('id',$id)
        ->first();
        $categories = Category::all();
        return view("admin.products.edit-product", compact('productInfo','categories'));
    }
    function updateProductData(Request $request, $id){

        $request->validate([
            'price' => 'required|numeric|min:0',
            
        ]);
        
        $product = Products::findOrFail($id);

        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->sku = $request->input('sku');
        $product->category = $request->input('category');
        $product->brand = $request->input('brand');
        $product->color = $request->input('color');
        $product->size = $request->input('size');
        $product->price = $request->input('price');
        $product->descrption = $request->input('description');
        $product->image = $request->input('image');
        $product->status = $request->input('status');

        if($product->save()){
            return redirect()->route('admin.edit.product', $id)->with('success', 'Product Updated Successfully.');
        }

        return redirect()->route('admin.products')->with('error', 'Something went wrong.');

    }

    function setInactiveProduct($id){
        $product  = Products::where('id',$id)
        ->first();
        if($product){
            $product->status = 'inactive';
            $product->save();
            return response()->json(['success' => true, 'tr'=>'tr_'.$id], 200);
        }
        return response()->json(['success' => false], 404);
    }

    function showCreatePage(){
        $categories = Category::all();
        return view('admin.products.create-product',compact('categories'));
    }

    
    
    

    
    


}
