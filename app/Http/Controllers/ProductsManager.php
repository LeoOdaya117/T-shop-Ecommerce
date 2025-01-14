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

    function showEditPage($id) {
        $productInfo = Products::where('id',$id)
        ->first();
        return view("admin.products.edit-product", compact('productInfo'));
    }

    function deleteProduct($id){
        $product = $productInfo = Products::where('id',$id)
        ->first();
        if($product){
            $product->status = 'inactive';
            $product->save();
            // return 
        }
    }
    public function getProducts(Request $request)
    {
        // Get the search value
        $search = $request->get('search')['value'];

        // Query to get paginated products, applying search if necessary
        $query = Products::query();

        if ($search) {
            // Apply search filter on multiple fields
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('color', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%')
                ->orWhere('brand', 'like', '%' . $search . '%');
        }

        // Get the total records count
        $totalRecords = Products::count();

        // Paginate the results
        $products = $query->skip($request->get('start'))
                        ->take($request->get('length'))
                        ->get();

        // Get the filtered records count
        $filteredRecords = $query->count();

        // Return the data in the format DataTables expects
        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products,
        ]);
    }



    
    
    

    
    


}
