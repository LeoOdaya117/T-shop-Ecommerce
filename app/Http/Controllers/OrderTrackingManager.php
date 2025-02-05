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
    $orderInfo = Orders::with(['shippingAddress', 'shippingOption'])->find($orderId);
    
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

    $ordered_items = [];
    foreach ($productIds as $index => $productId) {
        // Fetch product individually to maintain duplicates
        $product = Products::with('variants')->find($productId);
        if (!$product) continue; // Skip if product is not found

        $quantity = $quantities[$index] ?? 1;
        $variantId = isset($variantIds[$index]) ? (int) $variantIds[$index] : null;

        // Calculate price and subtotal
        $price = $product->price - $product->discount;
        $subtotal = $price * $quantity;

        // Find the variant
        $variant = ProductVariant::find($variantId);

        $ordered_items[] = [
            'product_name' => $product->title,
            'image' => $product->image,
            'slug' => $product->slug,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'variant' => $variant ? [
                'color' => $variant->color,
                'size' => $variant->size,
            ] : null,
        ];
    }

    return view('user.order.order-traking', [
        'order' => $orderInfo,
        'ordered_items' => $ordered_items,
        'shipping_address' => $orderInfo->shippingAddress,
    ]);
}

}
