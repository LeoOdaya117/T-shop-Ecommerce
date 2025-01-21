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
    
    function showProducts(Request $request){
        

        $products = Products::where('status', 'active')
        ->paginate(12);
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();

        return view('products', compact('products','categories','brands'));
    }
    function showProductsByCategory( $categoryId){
        $categoryId =(int) $categoryId;
        $products = Products::where('category', $categoryId)
        ->where('status', 'active')
        ->paginate(12); 
        $categories = Category::select('name')->where('id', $categoryId)->get();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
        return view('products', compact('products', 'categories','brands'));
    }
    
    function showDetails($slug){
        $products = Products::where('slug', $slug)->first();
        $relatedProducts = Products::where('brand', $products->brand)
            ->where('id', '!=', $products->id)
            ->where('status', 'active')
            ->paginate(10);
        $categories = Category::select('name')->where('id', $products->category)->get();
        return view('product_details', compact('products', 'relatedProducts', 'categories'));
    }

    function searchProduct(Request $request){
        
        $search = $request->get('search');

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();

        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();

        $products = Products::where('title', 'like', '%'.$search.'%')
        ->where('status', 'active')
        ->paginate(20);
        return view('products', compact('products', 'categories','brands'));
    }

    public function index()
    {
        
        $products = Products::where('status', 'active')
        ->paginate(8);
        $popularProducts = collect(); // Initialize as an empty collection

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();

        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();

        $cartItemCount = 0;
        $popularProducts = $this->getPopularProducts();
        if (auth()->check()) {
            $cartController = new CartManager();
            $cartController->updateCartTotal();
            $cartItemCount = $cartController->updateCartTotal();

            
        }

        return view('home', compact('products', 'popularProducts', 'categories', 'cartItemCount', 'brands'));
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
        $popularProducts = Products::where('status', 'active')
        ->whereIn('id', $topProductIds)->get();

        return $popularProducts;
    }
    
    public function loadMoreProducts(Request $request)
    {
        $skip = (int) $request->skip;
        $take = 8; // Number of products to load per request
        $products = Products::where('status', 'active')->skip($skip)->take($take)->get();
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
    $categoryManager = new CategoryManager();
    $categories = $categoryManager->getCategory();

    // Retrieve filter inputs
    $search = $request->input('search');
    $category = $request->input('category');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $status = $request->input('status') ?? 'active';

    // Build the raw SQL query
    $query = DB::table('products')
        ->leftJoin('category', 'products.category', '=', 'category.id')
        ->leftJoin('brand', 'products.brand', '=', 'brand.id')
        ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
        ->select(
            'products.*',
            'category.name as category_name',
            'brand.name as brand_name',
            'product_variants.stock as stock',
            
            
        );

    // Apply filters
    if ($search) {
        $query->where(function ($query) use ($search) {
            $query->where('products.title', 'like', '%' . $search . '%')
                 ;
        });
    }

    // Apply category filter
    if ($category) {
        $query->where('products.category', $category);
    }

    // Apply price range filter
    if ($minPrice || $maxPrice) {
        $query->whereBetween('product_variants.price', [
            $minPrice ?? 0,
            $maxPrice ?? PHP_INT_MAX
        ]);
    }

    // Apply status filter
    if ($status) {
        $query->where('products.status', '=', $status);
    }

    // Apply sorting and paginate
    $products = $query->orderBy('stock', 'ASC')->paginate(10);
    // dd($products)->toArray();
    return view('admin.products.manage-products', compact('products', 'categories'));
}

    
    

    


    function showEditPage($id) {
        $productInfo = Products::where('id',$id)
        ->first();
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
        return view("admin.products.edit-product", compact('productInfo','categories','brands'));
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'category' => 'required|integer',
            'brand' => 'required|string',
            'image' => 'string',
            'status' => 'required|string',
            // 'variant_price.*' => 'required|numeric',
            // 'variant_stock.*' => 'required|integer',
            // 'variant_color.*' => 'required|string',
            // 'variant_size.*' => 'required|string',
        ]);

        $product = Products::findOrFail($id);
        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->image = $request->input('image');
        $product->descrption = $request->input('description');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->category = $request->input('category');
        $product->brand = $request->input('brand');
        $product->status = $request->input('status');


        if ($product->save()) {
            return response()->json(['success' => 'Product updated successfully.']);
        }else{
            return response()->json(['error' => 'Something went wrong.']);
        }
        // // Update variants
        // foreach ($request->input('variant_price') as $index => $price) {
        //     $variant = $product->variants()->where('id', $index)->first();
        //     if ($variant) {
        //         $variant->update([
        //             'price' => $price,
        //             'stock' => $request->input('variant_stock')[$index],
        //             'color' => $request->input('variant_color')[$index],
        //             'size' => $request->input('variant_size')[$index],
        //         ]);
        //     }
        // }
        // return redirect()->route('admin.edit.product', $id)->with('success', 'Product and variants updated successfully.');
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
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
        return view('admin.products.create-product',compact('categories','brands'));
    }

    function create(Request $request){
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'category' => 'required|integer',
            'brand' => 'required|string',
            'size' => 'required|string',
            'color' => 'required|string',
            'status' => 'required|string',

        ]);

        $product = new Products();
        $product->title = $request->input('title');
        $product->descrption = $request->input('description');
        $product->slug = $request->input('slug');
        $product->image = $request->input('image'); 
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->brand = $request->input('brand');
        $product->size = $request->input('size');
        $product->color = $request->input('color');
        $product->stock = 0;  
        $product->discount = $request->input('discount');
        $product->status = $request->input('status');

        if($product->save()){
            return response()->json(['success' => 'Product created successfully.']);
        }

        return response()->json(['error' => 'Scomething went wrong.']);
         
    }


    

    
    
    

    
    


}
