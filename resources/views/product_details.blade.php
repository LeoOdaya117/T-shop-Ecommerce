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
    <main class="container " >
        

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    @if(isset($products) && $categories->isNotEmpty())
                        <li class="breadcrumb-item" onclick="route('{{ route('shop') }}')">Products</li>
                        <li class="breadcrumb-item"  onclick="route('{{ route('search.category.product', $products->category) }}')" >{{ $categories->first()->name }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $products->title }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page" onclick="route('{{ route('shop') }}')">Products</li>
                    @endif
                </ol>
            </nav>
        </div>

        <section class="py-5 shadow-lg" style="background: rgb(241, 240, 240)">
            <div class="container px-4 px-lg-5 " >
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-2 mb-md-0 mt-md-0" src="{{ $products->image }}" alt="Product Image" /></div>
                    <div class="col-md-6">
                        <div class="small mb-1">SKU: {{ $products->sku }}</div>
                        <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                        <div class="fs-5 mb-2">
                            @if ($products->discount > 0)
                                <span class="text-muted text-decoration-line-through">₱ {{ $products->original_price }}</span>
                                
                            @endif
                            <span>₱ {{ $products->price }}</span>
                        </div>
                        {{-- <div class="fs-5 mb-2 text-muted " >
                            <span class="" style="font-size: 15px">Stocks</span>
                            <span style="font-size: 15px">{{ $products->stock }}</span>
                        </div> --}}
                        <p class="lead">{{ $products->descrption }}</p>
                        <div class="d-flex mb-2  align-items-center m-0">
                            <div class="input-group d-flex" style="max-width: 8rem;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    class="form-control text-center text-dark" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $products->stock }}" readonly style="max-width: 5rem">
                                <button type="button" class="btn btn-outline-secondary " onclick="incrementQuantity()">+</button>
                            </div>
                            
                            {{-- <input type="number" id="quantity" name="quantity" class="form-control text-center me-3" value="1" min="1" max="{{ $products->stock }}" style="max-width: 5rem"> --}}
                            <p class="text-center text-muted mb-0 ms-3"> 
                                @if ($products->stock == 0)
                                    <div class="text-danger mb-0" role="alert">
                                         Out of stock
                                    </div>
                                @else
                                    {{ $products->stock }} stocks available
                                @endif
                            </p>
                        </div>
                        
                        <div class="d-flex">
                            @if ($products->stock == 0)
                                <button class="btn btn-outline-dark text-dark bg-transparent" onclick="addToWishList({{ $products->id}},'{{ $products->title }}')">
                                    Add to Wishlist</button>
                            @else
                                <button class="btn btn-outline-dark text-dark bg-transparent" onclick="addToCart({{ $products->id }})">Add to Cart</button>
                            @endif
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
                                <img  class="card-img-top p-2" src="{{ $recommendedProduct->image }}" alt="Product Image"  />
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
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $recommendedProduct->slug) }}')">
                                    <div class="text-center"><a class="btn btn-outline-dark text-dark">View Product</a></div>
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
            updateCartItemNumber();
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
                    
                    window.location.href = '{{ route('login') }}';

                    console.log(error);
                }
            });
            updateCartItemNumber();

            
        }

        function addToWishList(id, titile){
            Swal.fire({
                icon: 'success',
                title: `${titile} added to wishlist`,
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

        function incrementQuantity() {
            let input = document.getElementById('quantity');
            let currentValue = parseInt(input.value);
            let maxValue = parseInt(input.max);

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            let input = document.getElementById('quantity');
            let currentValue = parseInt(input.value);
            let minValue = parseInt(input.min);

            if (currentValue > minValue) {
                input.value = currentValue - 1;
            }
        }


        function route(routeUrl) {
            window.location.href = routeUrl;
        }

    </script>
@endsection()
