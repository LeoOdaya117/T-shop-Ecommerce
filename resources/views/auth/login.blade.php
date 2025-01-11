@extends("layouts.auth")
@section("title", "")
@section("style")

    <style>
        html,body{
            height: 100%;
            margin: auto auto;
        }
        .form-sign{
            
            padding: 1rem;
        }
        .logo{
            cursor: pointer;
        }
        .form-label{
            font-size: 15px;
        }
        .create{
            font-size: 15px;
            
        }
        .forgot-password,.create{
            color: blue;
            cursor: pointer;
            
        }
    </style>
@endsection
@section("content")
    <main class="form-signin m-auto">
        <div class="container-fluid shadow-lg p-4">
            <form method="POST" action="{{route("login.post")}}" class="form-sign w-auto">
                @csrf
                <div class="mb-4 text-center logo" onclick="changeURL('{{ route('home') }}')">
                    <i class="fa-solid fa-cart-shopping fa-lg"> T-Shop</i>
                </div>
                <div class="row">
                    <h3 class="text-start">Sign in</h3>
                    <p class="form-label">or <span onclick="changeURL('{{ route('register') }}')"  class="create">create and account</span></p>
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
                    <p  class="float-end form-label forgot-password">Forgot password?</p>
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
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                {{-- <a href="{{route("register")}}" class="text-center form-label">
                    Creat new account            
                </a> --}}
            </form>
        </div>
        
    </main>

@endsection
@section("script")
    <script>
        function changeURL(routeUrl){
            window.location.href = routeUrl;

        }
    </script>
@endsection()