<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistManager extends Controller
{
    function show(){
        return view('user.account.wishlist');
    }
}
