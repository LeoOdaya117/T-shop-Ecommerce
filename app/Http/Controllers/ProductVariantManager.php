<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
class ProductVariantManager extends Controller
{
    
    public function getVariantData($variant_id, $product_id){
        $variant_current_stock = ProductVariant::where('id', $variant_id)
            ->where('product_id', $product_id)
            ->first();
        return [
            'size' => $variant_current_stock->size,
            'color' => $variant_current_stock->color,
            'stock' => $variant_current_stock->stock, // Return the stock value directly
        ];
    }

}
