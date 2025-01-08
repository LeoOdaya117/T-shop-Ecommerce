<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Session;

class AuthManager extends Controller
{
    function login(){
        return view("auth.login");
    }
    function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {
            
            return redirect()->intended(route("home"));
        }
        return redirect("login")->with("error", "Invalid email or password.");
    }

    function registration(){
        return view("auth.register");
    }
    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            try {
                return redirect()->intended(route('login'))
                ->with("success", "You have been registered successfully.");
            } catch (\Throwable $th) {
                return redirect()->intended(route('login'))
                ->with("error", $th->getMessage());
            }
        }
        return redirect(route("register"))->with("error", "Something went wrong");
    }

    function logout(){
        Auth::logout();
        Session::forget('cartTotal');

        return redirect("login");
    }
}
