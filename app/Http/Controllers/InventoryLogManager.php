<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\InventoryLog;
use App\Models\ProductVariant;
use Illuminate\Http\Request;


class InventoryLogManager extends Controller
{
    function index(Request $request){

        $search = $request->input('search');
        $changeType = $request->input('change_type');

        
        $inventoryLogs = InventoryLog::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.inventory.inventory-logs', compact('inventoryLogs'));
    }

    function store(Request $request){

        //VALIDATE REQUEST 
        $request->validate([
            'product_id' => 'required|exists:products,id',
    
            'change_type' => 'required|in:add,subtract',
            'quantity_changed' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);
        

       
        // UPDATE PRODUCT VARIANT STOCK QUANTITY
        try {
            $product_variant = ProductVariant::findOrFail($request->variant_id);
        
            if ($request->change_type == 'subtract' && $product_variant->stock < $request->quantity_changed) {
                return response()->json([
                    'status' => 400,
                    'success' => false,
                    'message' => 'Insufficient stock to subtract.',
                ]);
            }
        
            $product_variant->stock += ($request->change_type == 'add') 
                ? $request->quantity_changed 
                : -$request->quantity_changed;
        
            $product_variant->save();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
        

        // SAVE INVENTORY LOG
        try {
            $inventoryLog = new InventoryLog();
            $inventoryLog->product_id = $request->product_id;
            // $inventoryLog->variant_id = $request->variant_id; // Log variant ID
            $inventoryLog->change_type = $request->change_type;
            $inventoryLog->quantity_changed = $request->quantity_changed;
            $inventoryLog->reason = $request->reason;
            $inventoryLog->save();
        
            
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
            'message' => 'Product variant stock updated successfully.',
        ]);
        


    }


}
