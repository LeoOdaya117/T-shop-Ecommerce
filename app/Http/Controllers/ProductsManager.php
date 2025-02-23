<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Category;
use App\Models\Reviews;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTable;
use Illuminate\Support\Facades\Auth;

class ProductsManager extends Controller
{
    

    function showProducts(Request $request) {
        $query = Products::with('reviews')->where('status', 'active');
    
        // Handle search
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('descrption', 'like', "%{$searchTerm}%");
            });
        }
        // Apply category filter
        if ($request->has('category')) {
            $query->whereIn('category', $request->category);
        }
    
        // Apply brand filter
        if ($request->has('brand')) {
            $query->whereIn('brand', $request->brand);
        }
    
        // Apply size filter through variants
        if ($request->has('size')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size', $request->size);
            });
        }
    
        // Apply price range filter 
        if ($request->has('price_range')) {
            foreach ($request->price_range as $range) {
                [$min, $max] = explode('-', $range);
                $query->whereBetween('price', [(int) $min, (int) $max]);
            }
        }
    
        // Paginate the results
        $products = $query->paginate(12);
    
        // Fetch categories and brands
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
    
        // Return the view
        return view('products', compact('products', 'categories', 'brands'));
    }
    
    function showProductsByCategory( $categoryId){
        $categoryId =(int) $categoryId;
        $products = Products::with('reviews')->where('category', $categoryId)
        ->where('status', 'active')
        ->paginate(12); 
        $categories = Category::select('name')->where('id', $categoryId)->get();
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
        return view('products', compact('products', 'categories','brands'));
    }
    
    function showDetails($slug){
        $products = Products::with(['variants','brands'])->where('slug', $slug)->first();
        $relatedProducts = Products::with('reviews')->where('brand', $products->brand)
            ->where('id', '!=', $products->id)
            ->where('status', 'active')
            ->paginate(10);
        $categories = Category::select('name')->where('id', $products->category)->get();
        $variants = $products->variants; // Access variants 
        $wishlistItems = Wishlist::where('user_id', Auth::id())->pluck('variant_id')->toArray();
        $reviews = Reviews::with('user')
        ->where('product_id', $products->id)->get();
        $ratings = [];
        $totalReviews = Reviews::where('product_id', $products->id)->count();
        $averageRating = $totalReviews > 0 ? Reviews::where('product_id', $products->id)->avg('rating') : 0;

        for ($i = 5; $i >= 1; $i--) {
            $ratings[$i] = [
                'count' => Reviews::where('product_id', $products->id)->where('rating', $i)->count(),
                'percentage' => $totalReviews > 0 ? (Reviews::where('product_id', $products->id)->where('rating', $i)->count() / $totalReviews) * 100 : 0
            ];
        }

        $reviewSummary = [
            'total_reviews' => $totalReviews,
            'average_rating' => number_format($averageRating, 1),
            'ratings' => $ratings
        ];
   
        return view('product_details', compact('products', 'wishlistItems', 'relatedProducts', 'categories', 'variants','reviews','reviewSummary'));
    }

    function searchProduct(Request $request){
        
        $search = $request->get('search');

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();

        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();

        $products = Products::with('reviews')->where('title', 'like', '%'.$search.'%')
        ->where('status', 'active')
        ->paginate(20);
        return view('products', compact('products', 'categories','brands'));
    }

    public function index()
    {
        
        $products = Products::with('reviews')->where('status', 'active')
        ->paginate(8);
        $popularProducts = collect(); // Initialize as an empty collection

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->getCategory();

        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();

        $cartItemCount = 0;
        $popularProducts = $this->getPopularProducts();
        $new_arrival = $this->getNewArrival();
       
        if (auth()->check()) {
            $cartController = new CartManager();
            $cartController->updateCartTotal();
            $cartItemCount = $cartController->updateCartTotal();

            
        }

        return view('home', compact('products', 'new_arrival', 'popularProducts', 'categories', 'cartItemCount', 'brands'));
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
        $popularProducts = Products::with('reviews')->where('status', 'active')
        ->whereIn('id', $topProductIds)->paginate(10);

        return $popularProducts;
    }

    private function getNewArrival(){
        $new_arrival = Products::with('reviews')
        ->where('status', 'active')
        ->where('created_at', '>=', Carbon::now()->startOfWeek()) // Start of the week
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();

    return $new_arrival;
    }
    
    public function loadMoreProducts(Request $request)
    {
        $skip = (int) $request->skip;
        $take = 8; // Number of products to load per request
        $products = Products::with('reviews')->where('status', 'active')->skip($skip)->take($take)->get();
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
        $brandManager = new BrandController();
        $brands = $brandManager->getBrands();
        
        // Retrieve filter inputs
        $search = $request->input('search');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status') ?? 'active';
    
        // Build the query
        $query = DB::table('products')
            ->leftJoin('category', 'products.category', '=', 'category.id')
            ->leftJoin('brand', 'products.brand', '=', 'brand.id')
            ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.title',
                'products.descrption', // Using the actual database column name
                'products.status',
                'category.name as category_name',
                'brand.name as brand_name',
                'products.price', // Price is in products table
                DB::raw('SUM(product_variants.stock) as total_stock'), // Aggregating stock
                DB::raw('MIN(product_variants.stock) as lowest_stock') // Getting the lowest stock in variants
            )
            ->groupBy(
                'products.id', 'products.title', 'products.descrption', 'products.status', 'category.name', 'brand.name', 'products.price'
            );
    
        // Apply filters
        if ($search) {
            $query->where('products.title', 'like', '%' . $search . '%');
        }
        if ($category) {
            $query->where('products.category', $category);
        }
        if ($minPrice || $maxPrice) {
            $query->havingBetween('products.price', [
                $minPrice ?? 0,
                $maxPrice ?? PHP_INT_MAX
            ]);
        }
        if ($status) {
            $query->where('products.status', '=', $status);
        }
    
        // Apply sorting and paginate
        $products = $query->orderBy(DB::raw('MIN(product_variants.stock)'), 'ASC')->paginate(10); // Sorting by lowest stock
        
        return view('admin.products.manage-products', compact('products', 'categories', 'brands'));
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
            'image' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'category' => 'nullable|exists:category,id',
            'brand' => 'nullable|exists:brand,id',
            // 'size' => 'required|string',
            // 'color' => 'required|string',
            'status' => 'nullable|in:active,inactive',

        ]);

        $product = new Products();
        $product->title = $request->input('title');
        $product->descrption = $request->input('description');
        $product->slug = $request->input('slug');
        $product->image = $request->input('image'); 
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->brand = $request->input('brand');
        // $product->size = $request->input('size');
        // $product->color = $request->input('color');
        // $product->stock = 0;  
        $product->discount = $request->input('discount');
        $product->status = $request->input('status');

        if($product->save()){
            return response()->json(['success' => 'Product created successfully.']);
        }

        return response()->json(['error' => 'Scomething went wrong.']);
         
    }


    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
            'category' => 'nullable|exists:category,id',
            'brand' => 'nullable|exists:brand,id',
            'status' => 'nullable|in:active,inactive',
        ]);
    
        $updateData = [];
        if (isset($request->category)) {
            $updateData['category'] = $request->category;
        }
        if (isset($request->brand))  {
            $updateData['brand'] = $request->brand;
        }
        if (isset($request->status)) {
            $updateData['status'] = $request->status;
        }
    
        try {
            Products::whereIn('id', $request->ids)
                ->update($updateData);
    
            return response()->json([
                'success' => true,
                'message' => 'Products updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating products: ' . $e->getMessage(),
            ]);
        }
    }
    

    
    
    

    
    


}
