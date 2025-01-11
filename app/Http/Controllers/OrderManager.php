<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderManager extends Controller
{
    public function showCheckout()
    {
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

        return view('checkout', compact('country', 'provinces'));
    }

    public function checkoutPost(Request $request)
    {
        $request->validate([
            'pincode' => 'required',
            'address' => 'required',
            'phone' => 'required',

        ]);

        $cartItems = DB::table("cart")
            ->join("products", 'cart.product_id', '=', 'products.id')
            ->select("cart.product_id", "cart.quantity", 'products.price', 'products.title')
            ->where("cart.user_id", auth()->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty.');
        }

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => $cartItem->title,
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->pincode = $request->pincode;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->product_id = json_encode($productIds);
        $order->quantity = json_encode($quantities);
        $order->total_price = $totalPrice;
        $order->status = "pending";
        $order->address2 = $request->address2;
        $order->state = $request->province;
        $order->city = "none";
        $order->country = $request->country;
        $order->fname = $request->firstname;
        $order->lname = $request->lastname;
        $order->email = $request->email;

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

                DB::table('cart')
                    ->where('user_id', auth()->user()->id)
                    ->delete();

                return redirect($checkoutSession->url);
            } catch (\Throwable $th) {
                $order->delete();
                return redirect()->route('cart.show')->with("error", $th->getMessage());
            }
        }

        return redirect()->route('cart.show')->with('error', 'Something went wrong.');
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
                $order->status = 'completed';
                $order->save();
            }
        }

        return response()->json(['status' => 'success']); 
    }  

    public function orderHistory($status)
    {
        if($status == 'all'){
            $orders = Orders::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            return view('order_history', compact('orders'));
        }
        else{
            $orders = Orders::where('user_id', auth()->user()->id, 'and')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            return view('order_history', compact('orders'));
        }

    }

}
