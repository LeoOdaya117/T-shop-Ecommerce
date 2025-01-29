<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManager extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $users = User::where('is_admin', false)
        ->orderBy('name', 'DESC')
        ->get();
        return view('admin.users.customer', compact('users'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified resource
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified resource
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update the specified resource in storage
    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'string'
          
        ]);

        try {
            $user = User::findOrFail(auth(0)->user()->id);
            $user->firstname = $request->firstname; 
            $user->lastname = $request->lastname; 
            
            if( $user->email != $request->email ){
                $user->email = $request->email; 
            }
            
            $user->phone_number = $request->phone_number;   
            
            $user->save();
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
            'message' => 'Updated Successfully',

        ]);
        // return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

 // Remove the specified resource from storage
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    function profile(){
        $userInfo = User::find(auth()->user()->id);
        $addressManager = new AddressManager();
        $addresses = Address::where('user_id', auth()->id())->get(); // Fetch addresses for the user

        return view('user.account.profile', compact('userInfo','addresses'));
    }

    
    function updatePassword(Request $request){

       
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
    

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Current password is incorrect.',
            ]);
        }

    
    
        try {
            // Update password
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'success' => true,
                'message' => $th->getMessage(),
            ]);
        }


        
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Password Updated Successfully.',
        ]);
    }
}