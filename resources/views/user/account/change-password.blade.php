@extends('layouts.my-account-layout')
@section('title', 'Order History')
@section('my-account')
    
    <main class="container  mb-5">
        <section class="">
            <div class="row d-flex align-items-center align-content-center justify-content-between mb-2 w-auto">
                <div class="col-12">
                    <h5 class="mb-3">Change Password</h5>
                    <div id="alert-container"></div>
                    <div class="card p-2">
                        <div class="card-body">
                           
                            <form action="{{ route('user.update.password') }}" method="POST" id="changePasswordForm">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-2">
                                    <label for="" class="col-form-label">Current Password</label>
                                    <input type="password" name="current_password" id="" class="form-control" >
                                </div>
                                <div class="form-group mb-2">
                                    <label for="" class="col-form-label">New Password</label>
                                    <input type="password" name="new_password" id="" class="form-control" >
                                </div>
                                <div class="form-group mb-3">
                                    <label for="" class="col-form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="" class="form-control" >
                                </div>
        
                                <button class="btn btn-primary form-control" type="submit">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
               
            </div>
           
        </section>
        
    </main>
@endsection
@section('script')
    <script>

        $("#changePasswordForm").submit(function(e) {
            
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "PUT",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    if(response.success == true){
                        $('#alert-container').html(`
                        <div class="alert alert-success">
                            ${response.message}
                        </div>
                    `);
                    }
                    else{
                        $('#alert-container').html(`
                            <div class="alert alert-danger">
                                ${response.message}
                            </div>
                        `);
                    }
                    $("#changePasswordForm").trigger("reset");

                    
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
