@extends("layouts.auth")
@section("title", "")
@section("style")

    <style>
        html,body{
            height: 100%;
            margin: 0 auto;
        }
        .form-sign{
            
            padding: 1rem;
        }
        .logo{
            cursor: pointer;
        }
    </style>
@endsection
@section("content")
    <main class="form-signin m-auto">
        <div class="container-fluid shadow-lg p-4">
            <form method="POST" action="{{route("login.post")}}" class="form-sign">
                @csrf
                <div class="mb-3 text-center logo" onclick="home('{{ route('home') }}')">
                    <i class="fa-solid fa-cart-shopping fa-lg"> T-Shop</i>
                </div>
                <div class="mb-3">
                    <h2 class="text-center">LOGIN</h2>
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
                <div class="mb-3 form-check">
                    <input type="checkbox" name="Rememberme" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
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
                <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
                <a href="{{route("register")}}" class="text-center form-label">
                    Creat new account            
                </a>
            </form>
        </div>
        
    </main>

@endsection
@section("script")
    <script>
        function home(routeUrl){
            window.location.href = routeUrl;

        }
    </script>
@endsection()