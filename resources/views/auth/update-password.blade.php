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

                

                <div id="alert-container"></div>

               
                <div class="form-group">
                    <input class="form-control form-control-lg" id="password" type="password" name="password" required placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="confirm-password" type="password" name="confirm-password" required placeholder="Password">
                </div>
               
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" required><span class="custom-control-label">By creating an account, you agree the <a href="{{ route("terms-and-conditions") }}">terms and conditions</a></span>
                    </label>
                </div>
               
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