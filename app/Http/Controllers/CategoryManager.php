<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class CategoryManager extends Controller
{
    //
    function showCategories(){
        return view('categories');
    }

    function getCategory(){
        $category = Products::ALL();
        return compact('category');
    }


}
