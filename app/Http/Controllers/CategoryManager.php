<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class CategoryManager extends Controller
{
    //
    function index(){
        $categories = Category::paginate(10);

        return view('admin.category.categories',compact('categories'));
    }

    function getCategory(){
        $category = Category::ALL();
        return compact('category');
    }

    function setInactiveCategories($id){
        $product  = Category::where('id',$id)
        ->first();
        if($product){
            $product->status = 'inactive';
            $product->save();
            return response()->json(['success' => true, 'tr'=>'tr_'.$id], 200);
        }
        return response()->json(['success' => false], 404);
    }

    function showCreatePage(){
      
        return view('admin.category.create-category');
    }
    function showEditPage($id) {
        $categoryInfo = Category::where('id',$id)
        ->first();
   
        return view("admin.category.edit-category", compact('categoryInfo'));
    }
}
