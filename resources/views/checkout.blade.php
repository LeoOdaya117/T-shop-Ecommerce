@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <style>
       
    </style>
@endsection
@include("includes.scripts")
@section("content")
    <main class="container w-100 mb-5">
        <section class="pt-5">
            <main class="container mt-5 mb-5">
                <h2 class="text-center mb-4">Checkout</h2>
                <div class="row">
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
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createAddressModal">
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
            

                                <h5 class="mb-3">Payments</h5>


                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" id="paymentMethodCOD" name="payment_method" value="COD" type="radio">
                                        <label class="form-check-label" for="paymentMethodCOD">
                                            Cash on hand
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="paymentMethodCard" name="payment_method" value="Card" type="radio">
                                        <label class="form-check-label" for="paymentMethodCard">
                                            Card
                                        </label>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary  w-100" type="submit">Place Order</button>
                            </form>
                        </div>
                    </div>
            
                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="card p-4 shadow-sm">
                            <h5 class="mb-3">Order Summary</h5>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Product Name 1</span>
                                    <span>$50.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Product Name 2</span>
                                    <span>$30.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Shipping</span>
                                    <span>$10.00</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong>$90.00</strong>
                                </li>
                            </ul>
                            {{-- <button class="btn btn-primary w-100">Place Order</button> --}}
                        </div>
                    </div>
                </div>
            </main>
            {{-- MODAL --}}

            <!-- Add New Address Modal -->
            <div class="modal fade" id="createAddressModal" tabindex="-1" aria-labelledby="createAddressModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAddressModalLabel">Create New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createAddressForm" action="{{ route('user.create.address') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-3" hidden>
                                    <label for="new_street" class="form-label">User ID</label>
                                    <input type="text" name="user_id" class="form-control" value="{{ auth()->user()->id }}">
                                </div>
                                <div class="mb-3">
                                    <label for="new_street" class="form-label">Address 1</label>
                                    <input type="text" name="address1" class="form-control" placeholder="Enter your street address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_street" class="form-label">Address 2 <span class="text-muted">(Optionanl)</span></label>
                                    <input type="text" name="address2" class="form-control" placeholder="Enter your street address" required>
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
                                        <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveAddressBtn">Save Address</button>
                        </div>
                    </div>
                </div>
            </div>
                    
            
        </section>
    </main>
@endsection

@section('script')

@endsection