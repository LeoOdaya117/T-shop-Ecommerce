
@extends("layouts.auth")
@section("title", "T-Shop - Login")
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
    @if (Auth::check())
        <script>window.location.href = "{{ url('/') }}";</script>
    @endif
 
    <main class="form-signin m-auto">
        
        <div class="splash-container">
            <div class="card ">
                <div class="card-header text-center">
                    <a href="{{ route("home") }}">
                        <div class="logo-img">
                            <i class="fa-solid fa-cart-shopping fa-lg "> T-Shop</i>
                        </div>
                    </a>
                    <span class="splash-description">
                        Please enter your user information.
                    </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                        @csrf
                        <div id="alert-container"></div>
                        <div class="form-group">
                            <input name="email" class="form-control form-control-lg" id="username" type="email" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
                <div class="card-footer bg-white p-0  ">
                    <div class="card-footer-item card-footer-item-bordered">
                        <a href="{{ route("register") }}" class="footer-link">Create An Account</a></div>
                    <div class="card-footer-item card-footer-item-bordered">
                        <a href="{{ route("forgot.password") }}" class="footer-link">Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('script')
    <script>
        $("#loginForm").submit(function(e) {

            var form = $(this);
          
            e.preventDefault();
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect; // Redirect on success
                    } else {
                        $("#alert-container").html(`
                            <div class="alert alert-danger">${response.message}</div>
                        `);
                    }

                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    for (let field in errors) {
                        errorHtml += `<li>${errors[field][0]}</li>`;
                    }
                    errorHtml += '</ul>';
                    $('#alert-container').html(`
                        <div class="alert alert-danger">
                            ${errorHtml}
                        </div>
                    `);
                }
       
            });
        });
    </script>
@endsection
