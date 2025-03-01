@extends("layouts.default")
@section("title", "T-Shop - Home")


@section("content")
    <div class="bg-dark text-light pt-2">
        <div class=" container ">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    <li class="breadcrumb-item" onclick="route('{{ route('cart.show') }}')">Cart</li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>

                </ol>
            </nav>
            
        </div>
    </div>
    <main class="container mb-5">
        <section class="">
            <main class="container mt-3 mb-5">
                <h2 class="text-start mb-4">Checkout</h2>
                <div class="row">
                    @if (session('success'))
                    <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Billing and Shipping Details -->
                    <div class="col-lg-7">
                        <div class="card p-4 mb-4 shadow-sm">
                            <h5 class="mb-3">Billing Details</h5>
                            <div id="alert-container">

                            </div>
             
                            <form  method="POST" id="checkoutForm" action="{{ route('checkout.post') }}">
                                
                                @csrf 
                                @method('POST')
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your first name" value="{{ auth()->user()->firstname }}" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="lastname" class="form-control" placeholder="Enter your last name" value="{{ auth()->user()->lastname }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email"  value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number"  value="{{ auth()->user()->phone_number }}" required>
                                </div>
            
                                <!-- Shipping Address Section -->
                                <div class="mb-3">
                                    <label for="address" class="form-label d-flex justify-content-between">Shipping Address
                                        <button type="button" class="btn btn-secondary" id="createAddressBtn" data-id="{{ auth()->user()->id }}">
                                            Add New Address
                                        </button>
                                    </label>
                                    <select id="address" name="shipping_id" class="form-select" required>
                                        <option value="" selected disabled>Select a saved address</option>
                                        <!-- Loop through saved addresses -->
                                        @foreach($user_addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->province }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Shipping OPTION Section -->
                                <div class="mb-3">
                                    <label for="shipping_option" class="form-label d-flex justify-content-between ">
                                        Delivery Method
                                    </label>
                                    <select id="shipping_option" name="shipping_option_id" class="form-select" required>
                                        <option value="" selected disabled>Select shipping option</option>
                                        {{-- <!-- Loop through saved addresses -->
                                        <option value="0" >Standard Shipping (3-5 days)  Free</option>
                                        <option value="75" >Priority (1-3 days) ₱75</option> --}}
                                        @foreach($shipping_options as $shipping_option)
                                            <option value="{{ $shipping_option->id }}" data-price="{{ $shipping_option->cost }}">{{ $shipping_option->name }} ({{ $shipping_option->min_days }}-{{ $shipping_option->max_days }} days) ₱ {{ $shipping_option->cost }}</option> 
                                        @endforeach
                                    </select>
                                </div>
            
            

                                <h5 class="mb-3">Payments</h5>


                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" id="paymentMethodCOD" name="payment_method" value="COD" type="radio">
                                        <label class="form-check-label" for="paymentMethodCOD">
                                            Cash on hand <i class="fa-solid fa-money-bill"></i>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="paymentMethodCard" name="payment_method" value="Card" type="radio">
                                        <label class="form-check-label" for="paymentMethodCard">
                                            Card <i class="fa-brands fa-cc-stripe"></i>
                                        </label>
                                    </div>
                                </div>
                                
                                <button class="btn btn-success  w-100" type="submit">Place Order</button>
                            </form>
                        </div>
                    </div>
            
                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="card p-4 shadow-sm">
                            <h5 class="mb-3">Order Summary</h5>
                            <ul class="list-group mb-3">
                                @php
                                    $totalPrice =0;
                                @endphp
                                @foreach ($cartItems as $item)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>
                                            {{ $item->product->title }}
                                            <small class="fw-bold">x</small>
                                            {{ $item->quantity }}
                                        </span>
                                        <span>₱ {{ number_format(($item->product->price - $item->product->discount ) * $item->quantity,2) }}</span>
                                        
                                    </li>
                                    @php $totalPrice += ($item->product->price - $item->product->discount ) * $item->quantity; @endphp  

                                @endforeach
                               
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Shipping</span>
                                    <span name="shipping_fee" class="shipping_fee" id="shipping_fee">₱ 0.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Discount</span>
                                    <span name="discount" class="discount" id="discount">₱ 0.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong class="total_price">₱ {{ number_format($totalPrice ,2) }}</strong>
                                </li>
                            </ul>

                            <div class="form-group d-flex">
                                <input type="text" class="form-control" name="coupon" placeholder="Coupon">
                                <button class="btn btn-success">Redeem</button>
                            </div>
                            {{-- <button class="btn btn-primary w-100">Place Order</button> --}}
                        </div>
                    </div>
                </div>
            </main>
            
            
        </section>
    </main>
     {{-- CREATE ADDRESS MODAL --}}
 @include('partials.modal', [
    'id' => 'createAddressModal',
    'title' => 'Create New Address',
    'body' => '
        <form id="createAddressForm"  method="POTS">
               
                
                <div class="mb-3">
                    <label for="new_street" class="form-label">Address 1</label>
                    <input type="text" name="address1" class="form-control" placeholder="Enter your street address" required>
                </div>
                <div class="mb-3">
                    <label for="new_street" class="form-label">Address 2 <span class="text-muted">(Optionanl)</span></label>
                    <input type="text" name="address2" class="form-control" placeholder="Enter your street address" >
                </div>
                <div class="mb-3">
                    <label for="new_city" class="form-label">City</label>
                    <input type="text" name="city" class="form-control" placeholder="Enter your city" required>
                </div>
                <div class="mb-3">
                    <label for="new_state" class="form-label">Province</label>
                    <input type="text" name="province" class="form-control" placeholder="Enter your province" required>
                </div>
                <div class="mb-3">
                    <label for="new_postal_code" class="form-label">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" placeholder="Enter your postal code" required>
                </div>
                <div class="mb-3">
                    <label for="new_country" class="form-label">Country</label>
                    <select class="custom-select d-block w-100 form-control" name="country" id="country" required>
                        <option value="Philippines">Philippines</option>
                    </select>
                </div>
                <div  class="d-flex justify-content-end align-items-end gap-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveAddressBtn">Save Address</button>
                </div>
                
        </form>
    ',
    'footer' => '
       
    ',
])

@endsection


@section('script')
    <script>
        function route(routeUrl) {
                window.location.href = routeUrl;
        }
        let user_id = null;
        $('#createAddressBtn').on('click', function(){
            user_id = $(this).data('id');
            $('#createAddressModal').modal('show');
        }); 

        // var modal = new bootstrap.Modal(document.getElementById('createAddressModal'));
        // modal.show(); // This ensures Bootstrap properly manages aria attributes.
        $('#createAddressForm').submit(function(e){
            e.preventDefault();

            var formData = new FormData(this); 
            var url = "{{ route('user.create.address') }}";

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
                        location.reload();

                        $('#createAddressModal').modal('hide');
                    } else {
                       
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

        $("#shipping_option").change(function() {
            var shippingFee = parseFloat($(this).find(':selected').data('price')) || 0;
            var baseTotal = parseFloat("{{ $totalPrice }}"); // Get the initial total price from Blade

            var newTotal = baseTotal + shippingFee;

            // Update the shipping fee display
            $("#shipping_fee").text("₱ " + shippingFee.toFixed(2));

            // Update the total price dynamically
            $(".total_price").text("₱ " + newTotal.toFixed(2));
        });

    </script>
@endsection