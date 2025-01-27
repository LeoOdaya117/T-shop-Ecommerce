<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;

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
    public function update(Request $request, User $user)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'string'
            // 'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            // 'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
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
}