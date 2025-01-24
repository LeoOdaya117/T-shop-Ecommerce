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

    function create(Request $request){
        $request->validate([
            'product_Id' => 'required|exists:products,id',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);

       try {
            $variant = new ProductVariant();
            $variant->product_id = $request->product_Id;
            $variant->color = $request->color;
            $variant->size = $request->size;
            $variant->stock = $request->quantity;
            $variant->save();
       } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
       }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Product Variant created successfully',
            'id' => $variant->id,
            'product_id' => $variant->product_id,
            'color' => $variant->color,
            'size' => $variant->size,
            'stock' => $variant->stock,
        ]);
    }

    function update(Request $request){
        
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'color' => 'required|string',
            'size' => 'required|string',
        ]);

        $variant = ProductVariant::find($request->variant_id);
        $variant->color = $request->color;
        $variant->size = $request->size;
        $variant->save();

        $variant_data = $this->getVariantData($request->variant_id, $variant->product_id);
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Product Variant updated successfully',
            'variant_id' => $request->variant_id,
            'new_color' => $variant_data['color'],
            'new_size' => $variant_data['size'],
        ]);
    }

    function destroy($id){
        $variant = ProductVariant::find($id);
        if($variant){
            $variant->delete();
            return response()->json(data: [
                'success' => true,
                'message' => 'Product Variant deleted successfully',
                'variant_id' => $id,
            ]);
        }
        return response()->json(['success' => false], 404);
    }

}
