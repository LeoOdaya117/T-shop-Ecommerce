@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <style>
        .card, .btn {
            cursor: pointer;
        }
        .card:hover {
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for a 3D effect */
            background-color: #f8f9fa; /* Optional: Change background color */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }
    </style>
@endsection
@include("includes.scripts")
@section("content")
    <main class="container w-100 mb-5">
        <section class="pt-5">
            <div class="container w-50">
                @if (session()->has("success"))
                    <div class="alert alert-success">
                        {{ session()->get("success") }}
                    </div>
                @endif
                @if (session("error"))
                    <div class="alert alert-danger">
                        {{ session("error") }}
                    </div>
                @endif
                <div class="text-center mt-5">
                    <h2>Checkout form</h2>
                </div>
                <div class="row">
                    <div class="col">
                        <h4 class="mb-3">Billing address</h4>
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
                        <form method="POST" action="{{ route('checkout.post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" value="" required>
                                    <div class="invalid-feedback"> Valid first name is required. </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="" value="" required>
                                    <div class="invalid-feedback"> Valid last name is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone Number <span class="text-muted"></span></label>
                                <input type="phone" class="form-control" name="phone" id="phone" required>
                                <div class="invalid-feedback"> Please enter a valid phone number for shipping updates. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required="">
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                                <input type="text" class="form-control" name="address2" id="address2" placeholder="Apartment or suite">
                            </div>
                            <div class="mb-3">
                                <label for="address2">City</label>
                                <input type="text" class="form-control" name="city" id="city" placeholder="">
                            </div>
                            <div class="row align-content-center align-items-center">
                                <div class="col-md-4 mb-3">
                                    <label for="province">Province</label>
                                    <select class="custom-select d-block w-100" name="province" id="province" required>
                                        <option value="">Choose...</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['name'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"> Please provide a valid province. </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label for="country">Country</label>
                                    <select class="custom-select d-block w-100" name="country" id="country" required>
                                        <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
                                    </select>
                                    <div class="invalid-feedback"> Please select a valid country. </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Zip</label>
                                    <input type="text" class="form-control" name="pincode" id="zip" placeholder="" required>
                                    <div class="invalid-feedback"> Zip code required. </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        // (function () {
        //     'use strict'
        //     var forms = document.querySelectorAll('.needs-validation')
        //     Array.prototype.slice.call(forms)
        //         .forEach(function (form) {
        //             form.addEventListener('submit', function (event) {
        //                 if (!form.checkValidity()) {
        //                     event.preventDefault()
        //                     event.stopPropagation()
        //                 }
        //                 form.classList.add('was-validated')
        //             }, false)
        //         })
        // })()
    </script>
@endsection