<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsManager extends Controller
{
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'User not authenticated.',
            ]);
        }

        // Validate the incoming data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',  // Ensure each product exists
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string',   // Allow null values
            'comment' => 'nullable|string', // Allow null values
        ]);
        
        

        try {
            // Loop through each product ID in the products array and create a review for each
            foreach ($request->products as $product_id) {
                Reviews::create([
                    'user_id' => auth()->user()->id,   // Get the authenticated user's ID
                    'product_id' => $product_id,        // The product ID from the request
                    'order_id' => $request->order_id,   // The order ID from the request
                    'rating' => $request->rating,       // The rating for all products
                    'title' => $request->title,         // The review title
                    'comment' => $request->comment,     // The review comment
                ]);
            }

            // Mark the order as reviewed
            Orders::where('id', $request->order_id)->update(['is_reviewed' => true]);

            // Return a successful response
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Review submitted successfully.',
            ]);

        } catch (\Throwable $th) {
            // Catch any errors and return a failure response
            return response()->json([
                'status' => $th->getCode(),
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
