<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderManager extends Controller
{
    function showCheckout(){
        
        return view('checkout');
    }

    function checkoutPost(Request $request){
        
        $request->validate([
            'pincode'=>'required',
            'address'=>'required',
            'phone'=>'required',
        ]);

        $cartItems = DB::table("cart")
        ->join("products",'cart.product_id', '=', 'products.id')
        ->select("cart.product_id", "cart.quantity", 
        'products.price', 'products.title')
        ->where("cart.user_id", auth()->user()->id)->get();

        if($cartItems->isEmpty()){
            return redirect('cart.show')->with('error','Cart is empty.');
        }


        $productIds= [];
        $quantities= [];
        $totalPrice= 0;
        $lineItems = [];

        foreach($cartItems as $cartItem){
            $productIds [] = $cartItem->product_id;
            $quantities [] = $cartItem->quantity;
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
        $order->pincode = $request->pincode ;
        $order->address = $request->address ;
        $order->phone = $request->phone ;
        $order->product_id = json_encode($productIds);
        $order->quantity = json_encode($quantities);
        $order->total_price = $totalPrice;
        $order->status ="pending";

        if ($order->save()) {
            try {
                
                // return redirect(route('cart.show'))->with("success", "Order Placed Successfully.");
                $stripe = new \Stripe\StripeClient(config("app.STRIPE_KEY"));

                $checkoutSession = $stripe->checkout->sessions->create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'customer_email' => auth()->user()->email,
                    'success_url' => route('payment.success', ['order_id' => $order->id]),
                    'cancel_url' => route('payment.error'),
                    'metadata' => [
                        'order_id' => $order->id,
                    ],
                ]);

            } catch (\Throwable $th) {
                $order->delete();
                return redirect(route('cart.show'))->with("error", $th->getMessage());
            }

            DB::table('cart')
                ->where('user_id', auth()->user()->id)
                ->delete();
            return redirect($checkoutSession->url);
        }

        return redirect('cart.show')->with('error', 'Something went Wrong.');
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
        $orders = Orders::where('user_id', auth()->user()->id, 'and')
        ->where('status', $status)
        ->paginate(6);
        return view('order_history', compact('orders'));
    }
}
