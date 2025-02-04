<?php

namespace App\Http\Controllers;

use App\Models\ShippingOptions;
use Illuminate\Http\Request;

class ShippingOptionController extends Controller
{
    function show(Request $request){

        // Retrieve filter inputs
        $search = $request->input('search');
        $status = $request->input('status'); // Default to 'active' if not provided

        // Use query builder instead of all()
        $query = ShippingOptions::query();

        // Apply filters
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->where('carrier', 'like', '%' . $search . '%');
        }

        if ($status) {
            $query->where('status', $status);
        }
        else{
            $query->where('status', 'active');
        }

        // Apply sorting and paginate
        $shipping_options = $query->orderBy('created_at', 'ASC')->paginate(10);


        return view('admin.shipping.shipping', compact('shipping_options'));
    }

    function showEditPage($id){

        $shipping_option_info = ShippingOptions::where('id', $id)->first();

        return view('admin.shipping.edit', compact('shipping_option_info'));
    }

    function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:shipping_option,id',
            'name' => 'required|string|max:255',
            'carrier' => 'required|string|max:255',
            'min_days' => 'required|integer|min:1',
            'max_days' => 'required|integer|gte:min_days',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|string'
        ]);
    
        try {
            // Find the shipping option by ID
            $shipping_option = ShippingOptions::find($request->id);
    
            // Check if the record exists
            if (!$shipping_option) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shipping option not found!'
                ], 404);
            }
    
            // Update the record
            $shipping_option->update([
                'name' => $request->name,
                'carrier' => $request->carrier,
                'min_days' => $request->min_days,
                'max_days' => $request->max_days,
                'cost' => $request->cost,
                'status' => $request->status
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Shipping option updated successfully!',
                'data' => $shipping_option
            ], 200);
    
        } catch (\Throwable $th) {
           
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update shipping option. Please try again.'
            ], 500);
        }
    }
    function showCreatePage(){
        
        return view('admin.shipping.create');
    }

    function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'carrier' => 'required|string|max:255',
            'min_days' => 'required|integer|min:1',
            'max_days' => 'required|integer|gte:min_days', 
            'cost' => 'required|numeric|min:0',
        ]);
    
        try {
            $shipping_option = ShippingOptions::create([
                'name' => $request->name,
                'carrier' => $request->carrier,
                'min_days' => $request->min_days,
                'max_days' => $request->max_days,
                'cost' => $request->cost,
                'status' => 'active' 
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Shipping option added successfully!',
                'data' => $shipping_option
            ], 201);
    
        } catch (\Throwable $th) {
            
    
            return response()->json([
                'success' => false,
                'message' =>  $th->getMessage(),
            ], 500);
        }
    }
    function destroy(Request $request){
        $request->validate([
            'shipping_option_id' => 'required|exists:shipping_option,id'
        ]);

       try {
            $shipping_option = ShippingOptions::findOrFail($request->shipping_option_id);
            $shipping_option->status = "inactive";
            $shipping_option->save();
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
            'id' => $request->shipping_option_id,
            'message' => 'Deleted Successfully',
        ]);
    }

    public function get($id) {
        $shipping_option = ShippingOptions::find($id);
    
        if (!$shipping_option) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping option not found!'
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => $shipping_option
        ], 200);
    }

    
    

}
