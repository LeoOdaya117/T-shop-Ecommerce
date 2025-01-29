<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Orders;
use App\Models\OrderTracking;
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Import Str

class OrderManager extends Controller
{
    public function showCheckout()
    {
        $authManager = new AuthManager();
        $authManager->sessionCheck();
        $addressManager = new AddressManager();
        $user_addresses = $addressManager->show(auth()->user()->id);
        // Define the Philippines and its provinces
        $country = ['id' => 1, 'name' => 'Philippines'];
        $provinces = [
            ['id' => 1, 'name' => 'Ilocos Norte'],
            ['id' => 2, 'name' => 'Ilocos Sur'],
            ['id' => 3, 'name' => 'La Union'],
            ['id' => 4, 'name' => 'Pangasinan'],
            ['id' => 5, 'name' => 'Batanes'],
            ['id' => 6, 'name' => 'Cagayan'],
            ['id' => 7, 'name' => 'Isabela'],
            ['id' => 8, 'name' => 'Nueva Vizcaya'],
            ['id' => 9, 'name' => 'Quirino'],
            ['id' => 10, 'name' => 'Aurora'],
            ['id' => 11, 'name' => 'Bataan'],
            ['id' => 12, 'name' => 'Bulacan'],
            ['id' => 13, 'name' => 'Nueva Ecija'],
            ['id' => 14, 'name' => 'Pampanga'],
            ['id' => 15, 'name' => 'Tarlac'],
            ['id' => 16, 'name' => 'Zambales'],
            ['id' => 17, 'name' => 'Batangas'],
            ['id' => 18, 'name' => 'Cavite'],
            ['id' => 19, 'name' => 'Laguna'],
            ['id' => 20, 'name' => 'Quezon'],
            ['id' => 21, 'name' => 'Rizal'],
            // Add more provinces as needed
        ];
        $cartItems = Cart::with(['variant','product'])
        ->where('user_id', auth()->user()->id)
        ->get();
        
        return view('checkout', compact('cartItems','country', 'provinces', 'user_addresses'));
    }

    public function checkoutPost(Request $request)
    {
        $authManager = new AuthManager();
        $authManager->sessionCheck();

        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'shipping_id' => 'required',
            'payment_method' => 'required',

        ]);

        $cartItems = DB::table("cart")
            ->leftJoin("products", 'cart.product_id', '=', 'products.id')
            ->leftJoin("product_variants", 'cart.variant_id', '=', 'product_variants.id')
            ->select("cart.product_id","cart.variant_id", "cart.quantity", 'products.price', 'products.title', 'product_variants.size', 'product_variants.color')
            ->where("cart.user_id", auth()->user()->id)
            ->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty.');
        }

        $productIds = [];
        $variantsIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $variantsIds[] = $cartItem->variant_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
            
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => $cartItem->title,
                        'description' => 'Color: ' . ucfirst($cartItem->color) . ', Size: ' . strtoupper($cartItem->size),
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $trackingId = strtoupper(Str::random(10)); // e.g., "X7T9GQ2HFA"


        // dd($variantsIds);
        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->product_id = json_encode($productIds);
        $order->variant_id = json_encode($variantsIds);
        $order->quantity = json_encode($quantities);
        $order->total_price = $totalPrice;
        $order->shipping_fee = 70.0;
        $order->shipping_id = $request->shipping_id;
        $order->fname = $request->firstname;
        $order->lname = $request->lastname;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->payment_method = $request->payment_method;
        $order->order_status = "Order Placed";
        $order->payment_status = "Pending";
        $order->tracking_id = $trackingId;
        
        
        

        if ($order->save()) {
            try {
                $stripe = new StripeClient(config("app.STRIPE_KEY"));

                $checkoutSession = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'line_items' => [$lineItems],
                    'mode' => 'payment',
                    'customer_email' => auth()->user()->email,
                    'success_url' => route('payment.success', ['order_id' => $order->id]),
                    'cancel_url' => route('payment.error'),
                    'metadata' => [
                        'order_id' => $order->id,
                    ],
                ]);

                // Update tracking_id in the order
                $orderTracking = DB::table('order_tracking')->insert([
                    'tracking_id' => $trackingId,
                    'order_id' => $order->id,
                    'status' => 'Order Placed',
                    'notes' => 'Order has been placed.',
                    'created_by' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the stock of the products
                foreach ($cartItems as $cartItem) {
                    DB::table('product_variants')
                        ->where('id', $cartItem->variant_id)
                        ->where('product_id', $cartItem->product_id)
                        ->decrement('stock', $cartItem->quantity);
                }

                DB::table('cart')
                    ->where('user_id', auth()->user()->id)
                    ->delete();

                return redirect($checkoutSession->url);
            } catch (\Throwable $th) {
                $order->delete();
                 return redirect()->route('cart.show')->with("error", $th->getMessage());

                // return response()->json([
                //     'status' => 500,
                //     'success' => false,
                //     'message' => $th->getMessage(),
                // ]);
            }
        }

        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'Something went wrong.',
        ]);

            
    }

    function paymentSuccess($order_id)
    {
        session()->flash('success', 'Order Placed Successfully.');
        return view('payment.success', ['order_id' => $order_id]);
    }

    function paymentError()
    {
        return view('payment.error');
    }

    function webhookStripe(Request $request){
        $payload = $request->getContent();
        $signheaders = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET'); // Ensure this is set in your .env file

        try {
            $event = Webhook::constructEvent(
                $payload, $signheaders, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $order_id = $session->metadata->order_id;
            $paymentID = $session->payment_intent;
            $order = Orders::find($order_id);
            
            if ($order) {
                $order->payment_id = $paymentID;
                $order->payment_status = 'Complete';
                $order->payment_date = now();
                $order->save();
            }
        }

        return response()->json(['status' => 'success']); 
    }  

    public function orderHistory()
    {
        $active_orders = Orders::where('user_id', auth()->id())
            ->where('order_status', '!=', 'Delivered')
            ->where('order_status', '!=', 'Cancelled')
            ->orderBy('created_at', 'DESC')
            ->get();

        $past_orders = Orders::where('user_id', auth()->id())
            ->whereIn('order_status', ['Delivered', 'Cancelled'])
            ->orderBy('created_at', 'DESC')
            ->paginate(4);

        // Process orders to include product details
        foreach ($active_orders as $order) {
            $product_ids = json_decode($order->product_id); // Decode product_id array
            $order->products = Products::whereIn('id', $product_ids)->get(); // Fetch related products
        }

        foreach ($past_orders as $order) {
            $product_ids = json_decode($order->product_id);
            $order->products = Products::whereIn('id', $product_ids)->get();
        }


        // dd($active_orders,$past_orders);

        // if($status == 'all'){
        //     $orders = Orders::where('user_id', auth()->user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(6);
        //     return view('user.order.order_history', compact('orders', 'active_orders', 'past_orders'));
        // }
        // else{
        //     $orders = Orders::where('user_id', auth()->user()->id, 'and')
        //     ->where('order_status', $status)
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(6);
        //     return view('user.order.order_history', compact('orders', 'active_orders', 'past_orders'));
        // }

        return view('user.order.order_history', compact('active_orders', 'past_orders'));


    }


    function getSalesAndRevenue()
    {
        //Total number of Customer
        $totalNumberOfCustomer = User::where('is_admin', false)->count();
        // Total orders
        $totalOrders = Orders::where('order_status', 'Delivered')
        ->count();
    
        // Total revenue
        $totalRevenue = Orders::where('payment_status', 'Complete')->sum('total_price');
    
        // Revenue by category
        $revenueByCategory = DB::table('products')
        ->select('category.name as category_name', DB::raw('SUM(products.price * oq.quantity) as revenue'))
        ->join('category', 'products.category', '=', 'category.id') // Join category table
        ->join(DB::raw('(
            SELECT 
                o.id as order_id,
                JSON_UNQUOTE(JSON_EXTRACT(o.product_id, CONCAT("$[", idx, "]"))) as product_id,
                JSON_UNQUOTE(JSON_EXTRACT(o.quantity, CONCAT("$[", idx, "]"))) as quantity
            FROM orders o
            CROSS JOIN (SELECT 0 idx UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) indices
            WHERE JSON_LENGTH(o.product_id) > idx
        ) as oq'), 'products.id', '=', 'oq.product_id')
        ->groupBy('category.name') // Group by category name
        ->get();

    
        $revenueByYear = DB::table('orders')
        ->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_price) as total_revenue'))
        ->groupBy(DB::raw('YEAR(created_at)'))
        ->orderBy('year', 'desc') // Orders the results by year in descending order
        ->get();

             // Prepare data for chart.js
        $year = $revenueByCategory->pluck('year');
        $year_revenue = $revenueByCategory->pluck('total_revenue');
        
        $categories = $revenueByCategory->pluck('category_name');
        $revenues = $revenueByCategory->pluck('revenue');
    
        // Total sales (total items sold across all orders)
        $totalSales = Orders::selectRaw('SUM(JSON_LENGTH(product_id)) as total_sales')->value('total_sales');
        $recentOrder = Orders::orderBy('created_at', 'desc')->take(10)->get();
    
            return response()->json([
                'total_customer' => $totalNumberOfCustomer,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'revenue_by_category' => $revenueByCategory,
                'total_sales' => $totalSales,
                'categories' => $categories,
                'revenues' => $revenues,
                'revenue_by_year' =>  $revenueByYear, 
                
                    
            ]);
    }

    function getRecentOrders(){
        $recentOrders = Orders::where('order_status', 'Order Placed')
        ->orderBy('created_at', 'desc')->take(5)->get();
    

        return $recentOrders;
    }
    

    function index(Request $request){
         // Retrieve filter inputs
         $search = $request->input('search');
         $order_status = $request->input('order_status');
     
         // Build the query
         $orders = Orders::query();
     
         // Apply search filter
         if ($search) {
             $orders->where(function ($query) use ($search) {
                 $query->where('id', 'like', '%' . $search . '%')
                       ->orWhere('fname', 'like', '%' . $search . '%');
             });
         }
  
     
         // Apply status filter
         if ($order_status) {
             $orders->where('order_status', $order_status);
         }
        $orders = $orders->orderBy('created_at', 'Desc')->paginate(10);


        $groupOrders = Orders::select('order_status', DB::raw('COUNT(*) as order_count'))
         ->groupBy('order_status')->get();
        return view('admin.orders.orders', compact('orders','groupOrders'));
    }
    function update(Request $request, $id){
        $order = Orders::findOrFail($id);

        $request->validate([
            'order_status' => 'required|string',
        ]);
        $order->order_status = $request->input('order_status');

        // Set tracking notes based on the order status
        switch ($request->order_status) {
            case 'Processing':
                $tracking_notes = 'Order has been accepted by the seller.';
                break;

            case 'Delivered':
                $tracking_notes = 'Order has been delivered to the customer.';
                break;

            case 'Cancelled':
                $tracking_notes = 'Order has been cancelled by the seller.';
                break;

            case 'Order Placed':
                $tracking_notes = 'Order has been placed.';
                break;

            case 'Shipped':
                $tracking_notes = 'Order has been shipped.';
                break;

            default:
                $tracking_notes = 'Order status has been updated.';
                break;
        }

    
        if($order->save()){
             // Create a new tracking record
            try {
                $orderTracking = new OrderTracking();
                $orderTracking->tracking_id = $order->tracking_id;
                $orderTracking->order_id = $order->id;
                $orderTracking->status = $request->order_status;
                $orderTracking->notes = $tracking_notes;
                $orderTracking->created_by = auth()->user()->id;
                $orderTracking->save();
            } catch (\Throwable $th) {
                return redirect()->intended(route('admin.orders.details', $id))
                ->with("error", $th->getMessage());
            }
            return redirect()->intended(route('admin.orders.details', $id))
                ->with("success", "Order Status Successfully Updated.");
        }
        return redirect()->intended(route('admin.orders.details' , $id))
                ->with("error", "Something went wrong");
    }

    function create(Request $request){
        
    }

    function delete($id){
        $order = Orders::find($id);
        
        if($order){
            $order->delete();
            return response()->json([
                'success' => true,
                'message' => 'Order Successfully deleted.',
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Something went wrong.',
        ]);



    }

    function showOrderDetails($id)
    {
        $orderInfo = Orders::with(['tracking', 'shippingAddress']) // Define the `shippingAddress` relationship in the model
        ->find($id);
        // Handle missing order
        if (!$orderInfo) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found.');
        }
    
        $ordered_items = [];
        $productIds = json_decode($orderInfo->product_id, true) ?? []; // Decode JSON or fallback to an empty array
        $quantities = json_decode($orderInfo->quantity, true) ?? [];   // Decode JSON or fallback to an empty array
        $variantIds = json_decode($orderInfo->variant_id, true) ?? []; // Decode variant_id if stored as JSON
    
        // Ensure the data arrays are valid
        if (!is_array($productIds) || !is_array($quantities) || !is_array($variantIds)) {
            return redirect()->route('admin.orders.index')->with('error', 'Invalid order data.');
        }
    
        $products = Products::with('variants')->whereIn('id', $productIds)->get();
        
        foreach ($products as $index => $product) {
            $quantity = $quantities[$index] ?? 1; // Fallback to 1 if quantity is missing
            $price = $product->price - $product->discount;
            $subtotal = $price * $quantity;
    
            // Find the variant by ID
            $variantId = $variantIds[$index] ?? null; // Get variant ID or null
            // $variant = $product->variants->firstWhere('id', $variantId);
            $variant  = ProductVariant::find($variantId);
            $ordered_items[] = [
                'product_name' => $product->title,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'variant' => $variant ? [
                    'color' => $variant->color,
                    'size' => $variant->size,
                ] : null, // Include variant details or null if not found
            ];
        }
        // dd( $variantIds ,$ordered_items);
        return view('admin.orders.order-details', compact('orderInfo', 'ordered_items'));
    }
    

    function statusUpdate(Request $request){
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_status' => 'required|string|in:Order Placed,Processing,Delivered,Cancelled',
        ]);

        $message = null;
        if($request->order_status == 'Processing'){
            $message = 'Order Accepted successfully';
            $tracking_notes = 'Order has been accepted by the seller.';
        }
        else{
            $message = 'Order Declined successfully';
            $tracking_notes = 'Order has been declined by the seller.';
        }

        $order = Orders::find($request->order_id);

        if(!$order){
            return response()->json([
                'error' => true,
                'message' => 'Order not found.',
            ]);
        }

        try {
            $order->order_status = $request->order_status;
            $order->save();

            // Update tracking_id in the order
            $orderTracking = DB::table('order_tracking')->insert([
                'tracking_id' => $order->tracking_id,
                'order_id' => $order->id,
                'status' => $request->order_status,
                'notes' => $tracking_notes,
                'created_by' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
               
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }

      
        return response()->json([
            'success' => true,
            'message' => $message ,
        ]);
    }


}
