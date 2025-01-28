@extends('layouts.my-account-layout')
@section('title', 'My Profile')
@section('my-account')
    
<main class="container mb-5">
    <section>
        <h5>My Profile</h5>
        <form action="{{ route('profile.update') }}" method="POST" id="UpdateProfileForm">
            @csrf
            @method('PUT')
            <div class="row mt-4 mb-2">
                
                <div id="alert-container1"></div>
             
                <!-- Profile Section -->
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="first_name" class="col-form-label">First Name</label>
                        <input type="text" name="firstname" id="first_name" class="form-control"  value="{{ $userInfo->firstname }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="last_name" class="col-form-label">Last Name</label>
                        <input type="text" name="lastname" id="last_name" class="form-control" value="{{ $userInfo->lastname }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control"  value="{{ $userInfo->email }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="phone" class="col-form-label">Phone Number</label>
                        <input type="text" name="phone_number" id="phone" class="form-control" value="{{ $userInfo->phone_number }}" >
                    </div>
                </div>
                    
            </div>
            <!-- Submit Button -->
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Save Profile</button>
                </div>
            </div>
      
        </form>
        <hr>
        <!-- Address Section -->
        <h6 class="mt-4">Address</h6>
        <div class="row mt-2 gap-0 ">
            <div id="alert-container2"></div>
            @forelse($addresses as $address)
                <div class="col-6 mb-2">
                    <div class="card" >
                            
                        <div class="card-body">
                            <p class="m-0">{{ $address->address_line_1 }},</p>
                            @if (isset($address->address_line_2))
                                <p class="m-0">{{ $address->address_line_2 }},</p>
                            @endif
                            <p class="m-0"> {{ $address->city }}, </p>
                            <p class="m-0">{{ $address->province }} {{ $address->postal_code }}  </p>
                            <p class="m-0">{{ $address->country }} </p>
                        </div>
                    </div>
                </div>
            
            @empty
                <div class="col-6">
                    <div class="card" >
                            
                        <div class="card-body text-center">
                            <p class="">No address found.</p>
                           
                        </div>
                    </div>
                </div>
        

            @endforelse
            

            <div class="col-6">
                <button class="btn btn-success rounded-circle" type="button" title="Add new Address" id="addAddressBtn" data-user-id="{{ auth()->user()->id }}"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>


   
       
    </section>
</main>

   {{-- CREATE ADDRESS MODAL --}}
   @include('partials.modal', [
    'id' => 'createAddressModal',
    'title' => 'Create New Address',
    'body' => '
        <form method="PUT" id="createAddressForm" >
    
            <div class="row">

                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="street" class="col-form-label">Address 1</label>
                        <input type="text" name="address1" id="address1" class="form-control" placeholder="Enter your street address" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="street" class="col-form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="address2" id="address2" class="form-control" placeholder="Enter your street address">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="city" class="col-form-label">City</label>
                        <input type="text" name="city" id="city" class="form-control" placeholder="Enter your city" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="state" class="col-form-label">Province</label>
                        <input type="text" name="province" id="province" class="form-control" placeholder="Enter your state/province" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="postal_code" class="col-form-label">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Enter your postal code" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="country" class="col-form-label">Country</label>
                        <select name="country" id="country" class="form-control" required>
                            <option value="" selected disabled>Select your country</option>
                            <option value="Philippines">Philippines</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                </div>
            </div> 
            <div class="d-flex justify-content-end align-items-end">
                <button type="button" class="btn btn-secondary mx-1"  id="cancelCreateBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="createAddressBtn">Save</button>
            </div>
            
           
        </form>
    ',
    'footer' => '
       
    ',
])
<!-- Ensure jQuery is loaded before your custom script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let user_id = null;
    $('#addAddressBtn').on('click', function(){
        user_id = $(this).data('user-id');
        $('#createAddressModal').modal('show');

    });
    
    $("#UpdateProfileForm").submit(function(e) {
        
        e.preventDefault();
        
        var url = $(this).attr('action'); 
        // Collect the form data
        var formData = new FormData(this); // 'this' refers to the form element

        // Add userId to the form data
        formData.append('user_id', user_id);
    
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                if(response.success == true) {
                    $('#alert-container1').html(`
                        <div class="alert alert-success">
                            ${response.message}
                        </div>
                    `);
                   
                   
                } else {
                    $('#alert-container1').html(`
                        <div class="alert alert-danger">
                            Something went wrong. Please try again.
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
                $('#alert-container1').html(`
                    <div class="alert alert-danger">
                        ${errorHtml}
                    </div>
                `);
            }
        });
    });
    $("#createAddressForm").submit(function(e) {
        
        e.preventDefault();
        var url = "{{ route('user.create.address') }}";

        // Collect the form data
        var formData = new FormData(this); // 'this' refers to the form element

        // Add userId to the form data
        formData.append('user_id', user_id);
    
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                if(response.success == true) {
                    $('#alert-container2').html(`
                        <div class="alert alert-success">
                            ${response.message}
                        </div>
                    `);
                   
                    $('#createAddressModal').modal('hide');
                } else {
                    $('#alert-container2').html(`
                        <div class="alert alert-danger">
                            Something went wrong. Please try again.
                        </div>
                    `);
                    $('#createAddressModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $('#createAddressModal').modal('hide');
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                for (let field in errors) {
                    errorHtml += `<li>${errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
                $('#alert-container1').html(`
                    <div class="alert alert-danger">
                        ${errorHtml}
                    </div>
                `);
            }
        });
    });

</script>

@endsection
