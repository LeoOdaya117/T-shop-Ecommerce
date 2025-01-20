<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\InventoryLog;
use Illuminate\Http\Request;


class InventoryLogManager extends Controller
{
    function index(Request $request){

        $search = $request->input('search');
        $changeType = $request->input('change_type');

        
        $inventoryLogs = InventoryLog::with('product')
            ->orderBy('created_at', 'desc')
            ->get();
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

       
        // UPDATE PRODUCT STOCK QUANTITY
        try {
            $product = Products::findOrFail($request->product_id);
            if ($request->change_type == 'add') {
                $product->stock += $request->quantity_changed;
            }
            elseif($request->change_type == 'subtract') {
                $product->stock -= $request->quantity_changed;
            }
    
            $product->save();

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }

        // SAVE INVENTORY LOG
        try {
            $inventoryLog  =  new InventoryLog();
            $inventoryLog->product_id = $request->product_id;
            $inventoryLog->change_type = $request->change_type;
            $inventoryLog->quantity_changed = $request->quantity_changed;
            $inventoryLog->reason = $request->reason;
            $inventoryLog->save();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Product Stocks updated successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }


    }


}
