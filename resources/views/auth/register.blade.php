@extends("layouts.auth")
@section("style")

    <style>
        html,body{
            height: 100%;
             margin: 0 auto;
        }
        
    </style>
@endsection
@section("content")
    <main class="form-signin w-100 m-auto">
        <div class="container w-50">
            <form method="POST" action="{{route("register.post")}}">
                @csrf
                <div class="mb-3 text-center">
                    <i class="fa-solid fa-cart-shopping fa-lg"></i>
                </div>
                <div class="mb-3">
                    <h2 class="text-center">REGISTER</h2>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Juan Dela Cruz">
                    @error('name')
    
                        <span class="text-danger">{{$message}}</span>
                        
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                    @error('email')
    
                        <span class="text-danger">{{$message}}</span>
                        
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    @error('password')
    
                        <span class="text-danger">{{$message}}</span>
                        
                    @enderror
    
                </div>
               
    
                @if (session()->has("success"))
                    <div class="alert alert-success">
                        {{session()->get("success")}}
                    </div>
                
                @endif
                @if (session("error"))
                    <div class="alert alert-danger">
                        {{session("error")}}
                    </div>
                
                @endif
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                <a href="{{route("login")}}" class="text-center">
                    Already have an account?            
                </a>
            </form>
        </div>
       
    </main>
    

@endsection