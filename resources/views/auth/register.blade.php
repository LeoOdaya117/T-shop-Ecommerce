@extends("layouts.auth")
@section("style")

    <style>
        html,body{
            height: 100%;
             margin: 0 auto;
        }
        .form-register{
            
            padding: 1rem;
        }
        .logo{
            cursor: pointer;
        }
    </style>
@endsection
@section("content")
<!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" method="POST" id="registerForm" action="{{ route("register.post") }}">
        @csrf
        @method('post')
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user information.</p>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif --}}

                <div id="alert-container"></div>

                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="firstname" required placeholder="Firstname" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="lastname" required placeholder="Lastname" autocomplete="off">
                </div>
                
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" required placeholder="E-mail" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="password" type="password" name="password" required placeholder="Password">
                </div>
                {{-- <div class="form-group">
                    <input class="form-control form-control-lg" required placeholder="Confirm">
                </div> --}}
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" required><span class="custom-control-label">By creating an account, you agree the <a href="{{ route("terms-and-conditions") }}">terms and conditions</a></span>
                    </label>
                </div>
                {{-- <div class="form-group row pt-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                        <button class="btn btn-block btn-social btn-facebook " type="button">Facebook</button>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <button class="btn  btn-block btn-social btn-twitter" type="button">Twitter</button>
                    </div>
                </div> --}}
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="{{ route("login") }}" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
    

@endsection

@section('script')
    <script>
        $("#registerForm").submit(function(e) {

            var form = $(this);
          
            e.preventDefault();
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    if(response.success == true) {
                        $('#alert-container').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div>
                        `);
                    
                    } else {
                        $('#alert-container').html(`
                            <div class="alert alert-danger">
                                 ${response.message}
                            </div>
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