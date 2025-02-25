<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Session;

class AuthManager extends Controller
{
    public function sessionCheck(){
        // Check if the user is authenticated
        if (Auth::check()) {
            // If the user is logged in and is an admin, redirect to the admin dashboard
            if (Auth::user()->is_admin) {
                return redirect()->intended(route("admin.dashboard"));
            }
            else{
                return redirect()->intended(route("home"));
            }
            
        
        } else {
            // If no user is logged in, you can handle the redirection here (e.g., redirect to login)
            return redirect()->route('login');
        }
    
        
    }
    
    function login(){
        // Check if the session variable 'logged_in_redirect' exists
        $this->sessionCheck();
        return view("auth.login");
    }
    function forgotPassword(){
        // Check if the session variable 'logged_in_redirect' exists
        $this->sessionCheck();
        return view("auth.forgot-password");
    }

    
    function admin_Index(){
        $OrderManager = new OrderManager();
        $recentOrders = $OrderManager->getRecentOrders();
        return view("admin.dashboard", compact('recentOrders'));
    }
    function loginPost(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json([
                'success' => true,
                'redirect' => Auth::user()->is_admin ? route("admin.dashboard") : route("home")
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ]);
    }
    

    function registration(){
        return view("auth.register");
    }
    function registrationPost(Request $request){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ],[
            'email.unique' => 'The email address is already taken.',
            'password.min:6' =>'The password must be at least 6 characters.',
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            try {
               

                return response()->json([
                    'status' => 200,
                    'success' => true,
                    'message' => 'You have been registered successfully.',
                ]);
            } catch (\Throwable $th) {
                
                return response()->json([
                    'status' => 500,
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
        }
        return response()->json([
            'status' => 500,
            'success' => false,
            'message' => 'Something went wrong',
        ]);
       
    }



    function logout(){
        Auth::logout();
        Session::forget('cartTotal');

        return redirect("login");
    }

    
}
