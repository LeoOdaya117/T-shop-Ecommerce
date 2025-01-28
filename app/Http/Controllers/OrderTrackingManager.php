<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Products;

class OrderTrackingManager extends Controller
{
    public function orderTracking($orderId)
    {
        // Fetch the order with the shipping address and tracking relation
        $orderInfo = Orders::with( 'shippingAddress') // Define the `shippingAddress` relationship in the model
            ->find($orderId);
    
        // Handle missing order
        if (!$orderInfo) {
            return redirect()->route('user.order.tracking')->with('error', 'Order not found.');
        }
    
        // Decode JSON fields safely
        $productIds = json_decode($orderInfo->product_id, true) ?? [];
        $quantities = json_decode($orderInfo->quantity, true) ?? [];
        $variantIds = json_decode($orderInfo->variant_id, true) ?? [];
    
        // Validate data integrity
        if (!is_array($productIds) || !is_array($quantities) || !is_array($variantIds)) {
            return redirect()->route('user.order.tracking')->with('error', 'Invalid order data.');
        }
    
        $products = Products::with('variants')->whereIn('id', $productIds)->get();

        $ordered_items = [];
        foreach ($products as $index => $product) {
            $quantity = $quantities[$index] ?? 1;
            $variantId = isset($variantIds[$index]) ? (int) $variantIds[$index] : null;

            // Calculate price and subtotal
            $price = $product->price - $product->discount;
            $subtotal = $price * $quantity;

            // Find the variant
            // $variant = $product->variants->firstWhere('id', $variantId);
            $variant  = ProductVariant::find( $variantId);

            $ordered_items[] = [
                'product_name' => $product->title,
                'image' => $product->image,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'variant' => $variant ? [
                    'color' => $variant->color,
                    'size' => $variant->size,
                ] : null,
            ];
        }

        //  dd($orderInfo);
        return view('user.order.order-traking', [
            'order' => $orderInfo,
            'ordered_items' => $ordered_items,
            'shipping_address' => $orderInfo->shippingAddress,
        ]);
    }
    
}
