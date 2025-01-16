<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class CategoryManager extends Controller
{
    //
    function index(Request $request){
        // Retrieve filter inputs
        $search = $request->input('search');
        $status = $request->input('status') ?? 'active';
    
        // Build the query
        $categories = Category::query();
    
        // Apply search filter
        if ($search) {
            $categories->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                      ->orWhere('name', 'like', '%' . $search . '%');
            });
        }
 
    
        // Apply status filter
        if ($status) {
            $categories->where('status', $status);
        }
    
        // Fetch paginated results
        $categories = $categories->orderBy('name', 'ASC')
        ->paginate(10);

        return view('admin.category.categories',compact('categories'));
    }

    function getCategory(){
        $category = Category::where('status', 'active')->get();
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

    function create(Request $request)
    {

    }
    function update(Request $request, $id){
        $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
            'image'=>'required|string',
            'status'=>'required|string',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->image = $request->input('image');
        $category->status = $request->input('status');

        if($category->save()){
            return redirect()->route('admin.edit.category', $id)->with('success', 'Category Updated Successfully.');
        }

        return redirect()->route('admin.edit.category', $id)->with('error', 'Something Went Wrong.');

    }
    
}
