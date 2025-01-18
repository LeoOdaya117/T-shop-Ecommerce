<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    function index(Request $request){
        // Retrieve filter inputs
        $search = $request->input('search');
        $status = $request->input('status') ?? 'active';
    
        // Build the query
        $brands = Brand::query();
    
        // Apply search filter
        if ($search) {
            $brands->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                      ->orWhere('name', 'like', '%' . $search . '%');
            });
        }
 
    
        // Apply status filter
        if ($status) {
            $brands->where('status', $status);
        }
    
        // Fetch paginated results
        $brands = $brands->orderBy('name', 'ASC')
        ->paginate(10);

        return view('admin.brand.brand',compact('brands'));
    }

    function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
            'image'=>'required|string',
            'status'=>'required|string',
        ]);

        $brand =new Brand();
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->image = $request->input('image');
        $brand->status = $request->input('status');

        if($brand->save()){
            return response()->json(['success' =>"Brand Successfully Saved."]);
        }

        return response()->json(['error' => "Something went wrong"]);
    }
    function update(Request $request, $id){
        $request->validate([
            'name'=>'required|string',
            'slug'=>'required|string',
            'image'=>'required|string',
            'status'=>'required|string',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->input('name');
        $brand->slug = $request->input('slug');
        $brand->image = $request->input('image');
        $brand->status = $request->input('status');

        if($brand->save()){
            return response()->json(['success'=> "Brand Successfully Updated."]);
        }

        return response()->json(['error'=> "Something went wrong"]);
    }
    function delete(){
        
    }

    function setInactiveBrand($id){
        $brand  = Brand::where('id',$id)
        ->first();
        if($brand){
            $brand->status = 'inactive';
            $brand->save();
            return response()->json(['success' => true, 'tr'=>'tr_'.$id], 200);
        }
        return response()->json(['success' => false], 404);
    }

    function showCreatePage(){
        return view('admin.brand.create-brand');
    }
    function showEditPage($id){
        $brandInfo = Brand::where('id', $id)->first();

        return view('admin.brand.edit-brand', compact('brandInfo'));
    }

    function getBrands(){
        $brands = Brand::where('status', 'active')
        ->orderBy('name', 'ASC')->get();
        return $brands;
    }
}
