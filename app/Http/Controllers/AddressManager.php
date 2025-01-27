<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressManager extends Controller
{
    public function show($userId){
        $addresses = Address::where('user_id', $userId)->get();

        return $addresses;
    }

    function store(Request $request){
      
       try {
        $address = new Address();
        $address->user_id = $request->user_id;
        $address->address_line_1 = $request->address1;
        $address->address_line_2 = $request->address2;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->postal_code = $request->postal_code;
        $address->country = $request->country;
        $address->is_primary = 0;
        $address->save();


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
            'message' => 'Address Successfully saved.',

       ]);

    }
}
