@extends("layouts.default")
@section("title", "T-Shop - Home")

@section("style")
    <style>
        .btn:hover{
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for a 3D effect */
            background-color: #f8f9fa; /* Optional: Change background color */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }
        img{
            object-fit: contain; /* Ensures the image fits within the specified height and width */
            max-height: 75%;
        }
    </style>
@endsection()

@section("content")
    <main class="container">

        <div class="container">
            ...
        </div>

        <section class="py-5 pt-5 shadow-lg" style="background: rgb(241, 240, 240)">
            <div class="container px-4 px-lg-5 " >
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-2 mb-md-0" src="{{ $products->image }}" alt="Product Image" /></div>
                    <div class="col-md-6">
                        <div class="small mb-1">{{ $products->sku }}</div>
                        <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                        <div class="fs-5 mb-2">
                            <span class="text-decoration-line-through">₱ 45.00</span>
                            <span>₱ {{ $products->price }}</span>
                        </div>
                        <div class="fs-5 mb-2 text-muted " >
                            <span class="" style="font-size: 15px">Stocks</span>
                            <span style="font-size: 15px">{{ $products->stock }}</span>
                        </div>
                        <p class="lead">{{ $products->descrption }}</p>
                        <div class="d-flex">
                            <input type="number" id="quantity" name="quantity" class="form-control text-center me-3" value="1" min="1" style="max-width: 5rem">
                            {{-- <input class="form-control text-center me-3" name="quantity"  id="inputQuantity" type="num" value="1" style="max-width: 3rem" /> --}}
                            <button class="btn btn-outline-dark flex-shrink-0 text-dark" type="button" onclick="addToCart({{ $products->id }})">
                                <i class="bi-cart-fill me-1 "></i>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="card mt-5">
            <div class="container-fluid">
                <div class="row  shawdow-sm">
                    <!-- Product Image -->
                    <div class="col-12 col-md-6 mb-3 mb-md-0 align-content-center align-items-center">
                        <img src="{{ $products->image }}" alt="Product Image" class="img-fluid align-content-center">
                    </div>
                    
                    <!-- Product Details -->
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start">
                        <div class="row mb-3">
                            <h3>{{ $products->title }}</h3>
                        </div>
                        <div class="row mb-3">
                            <p><strong>₱ {{ $products->price }}</strong></p>
                        </div>
                        <div class="row mb-3">
                            <p>{{ $products->descrption }}</p>
                        </div>
                        
                        <!-- Quantity Input -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                            </div>
                        </div>
    
                        <!-- Buttons -->
                        <div class="row w-100">
                            <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                                <button class="btn bg-warning w-100">Buy now</button>
                            </div>
                            <div class="col-12 col-sm-6">
                                <button class="btn bg-success w-100" onclick="addToCart({{ $products->id }})">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        
        </section> --}}
        <section class="mt-5">
            <h4 class="mb-4">Related Products</h4>
            <div class="row">
                @if (count($relatedProducts) == 0)
                    <div class="col-12">
                        <div class="alert text-center">
                            No related products found.
                        </div>
                    </div>
                    
                @else
                    @foreach ($relatedProducts as $recommendedProduct)
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <div class="card" >
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ $recommendedProduct->image }}" alt="Product Image" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{ $recommendedProduct->title }}</h5>
                                        <!-- Product price-->
                                        ₱ {{ $recommendedProduct->price }}
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="clickProduct('{{ route('showDetails', $recommendedProduct->slug) }}')">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto text-dark">View options</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                @endif
                
            </div>
        </section>
    </main>
@endsection()

@section("script")
    <script>
        function addToCart(productId) {
            // Get the quantity selected by the user
            const quantity = document.getElementById('quantity').value;

            // Send AJAX request to add product to cart
            $.ajax({
                url: '/cart/' + productId + '/' + quantity,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                            toast: true,
                            position: 'center-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            html: '<a class="btn btn-outline-dark text-dark bg-transparent" type="submit" href="{{ route("cart.show") }}"><i class="fa-solid fa-cart-shopping"></i>Cart</a>',
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);

                                // Add event listener to the custom button
                                document.getElementById('customButton').addEventListener('click', function() {
                                    // Custom button click handler
                                    console.log('Button clicked!');
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                            toast: true,
                            position: 'center-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Something went wrong',
                    //     toast: true,
                    //     position: 'top-end',
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     timerProgressBar: true,
                    //     didOpen: (toast) => {
                    //         toast.addEventListener('mouseenter', Swal.stopTimer);
                    //         toast.addEventListener('mouseleave', Swal.resumeTimer);
                    //     }
                    // });

                    window.location.href = '{{ route('login') }}';

                    console.log(error);
                }
            });


            
        }

        function clickProduct(routeUrl) {
            window.location.href = routeUrl;
        }
    </script>
@endsection()
