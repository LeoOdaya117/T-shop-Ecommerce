<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Products;

class OrderTrackingManager extends Controller
{
    public function orderTracking($orderId)
    {
        $orderInfo = Orders::find($orderId);
    
        // Handle missing order
        if (!$orderInfo) {
            return redirect()->route('user.order.order-traking')->with('error', 'Order not found.');
        }
    
        $ordered_items = [];
        $productIds = json_decode($orderInfo->product_id, true) ?? []; // Decode JSON or fallback to an empty array
        $quantities = json_decode($orderInfo->quantity, true) ?? [];   // Decode JSON or fallback to an empty array
        $variantIds = json_decode($orderInfo->variant_id, true) ?? []; // Decode variant_id if stored as JSON
    
        // Ensure the data arrays are valid
        if (!is_array($productIds) || !is_array($quantities) || !is_array($variantIds)) {
            return redirect()->route('user.order.order-traking')->with('error', 'Invalid order data.');
        }
    
        $products = Products::with('variants')->whereIn('id', $productIds)->get();
        
        foreach ($products as $index => $product) {
            $quantity = $quantities[$index] ?? 1; // Fallback to 1 if quantity is missing
            $price = $product->price - $product->discount;
            $subtotal = $price * $quantity;
    
            // Find the variant by ID
            $variantId = $variantIds[$index] ?? null; // Get variant ID or null
            $variant = $product->variants->firstWhere('id', $variantId);
    
            $ordered_items[] = [
                'product_name' => $product->title,
                'image' => $product->image,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'variant' => $variant ? [
                    'color' => $variant->color,
                    'size' => $variant->size,
                ] : null, // Include variant details or null if not found
            ];
        }

        $order = Orders::with('tracking')->findOrFail($orderId); // Assuming you have a tracking relation or table
        return view('user.order.order-traking', [
            'order' => $order,
            'ordered_items' => $ordered_items,
        ]);
       
    }
}
