<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistManager extends Controller
{
    function show(){

        $wishlist = Wishlist::with(['product','variant'])->where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'DESC')
        ->get();
       
        return view('user.account.wishlist', compact('wishlist'));
    }

    function store(Request $request){
        $request->validate([
            'product_id' => 'required',
            'variant_id' => 'required',
        ], [
            'product_id.required' => 'The product is required.',
            'variant_id.required' => 'Please select color and size before adding to your wishlist.',
        ]);
        

       
        try {
            $wishlist = new Wishlist();
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $request->product_id;
            $wishlist->variant_id = $request->variant_id;
            $wishlist->save();
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
            'message' => 'Wishlist added successfully.',
        ]);

    }

    function destroy(Request $request) {
        $request->validate([
            'wishlist_id' => 'required|exists:wishlist,id'
        ]);

        try {
            $wishlist = Wishlist::findOrFail($request->wishlist_id);
            $wishlist->delete();

            return response()->json([
                'status' => 200,
                'success' => true,
                'wishlist_id' =>$request->wishlist_id,
                'message' => 'Wishlist item deleted successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    function userRemoveWishlist(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id'
        ]);

        try {
            $wishlist = Wishlist::where('user_id',auth()->user()->id)
                ->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)
            ;
            $wishlist->delete();

            return response()->json([
                'status' => 200,
                'success' => true,
                'wishlist_id' =>$request->wishlist_id,
                'message' => 'Wishlist item deleted successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
