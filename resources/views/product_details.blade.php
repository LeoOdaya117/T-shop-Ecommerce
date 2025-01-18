@extends("layouts.default")
@section("title", "T-Shop - Home")

@section("style")
    <style>
        
        img{
            object-fit: contain; /* Ensures the image fits within the specified height and width */
            max-height: 75%;
        }
        .btn:hover .fa-heart {
        background-color: rgba(255, 0, 0, 0.1); /* Light red background */
        transform: scale(1.1); /* Slightly larger on hover */
        transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }
    </style>
@endsection()

@section("content")
    <div class="bg-dark text-light">
        <div class="container">
            <nav aria-label="breadcrumb" class="pt-5 mt-4 text-white">
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
    </div>
    <main class="container " >
        

        

        <section class="py-5 shadow-lg" style="background: rgb(241, 240, 240)">
            <div class="container px-4 px-lg-5 " >
                <div class="row gx-4 gx-lg-5 align-items-center">
                    
                    <div class="col-md-6"><img class="card-img-top mb-2 mb-md-0 mt-md-0" src="{{ $products->image }}" alt="Product Image" /></div>
                    <div class="col-md-6">
                        <!-- Heart icon overlay -->
                        
                        <div class="container d-flex justify-content-end">
                            <button class="btn p-0 border-0 bg-transparent rounded-circle">
                                <i class="fas fa-heart text-danger p-1" style="font-size: 1.5rem;"></i>
                            </button>
                        </div>
                        <div class="small mb-1">SKU: {{ $products->sku }}</div>

                        
                        <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                        <div class="fs-5 mb-2">
                            @if ($products->discount > 0)
                                <span class="text-muted text-decoration-line-through">₱ {{ $products->price }}</span>
                                
                            @endif
                            <span>₱ {{ $products->price - $products->discount }}</span>
                        </div>
                        {{-- <div class="fs-5 mb-2 text-muted " >
                            <span class="" style="font-size: 15px">Stocks</span>
                            <span style="font-size: 15px">{{ $products->stock }}</span>
                        </div> --}}
                        <p class="lead">{{ $products->descrption }}</p>
                        <div class="d-flex mb-2  align-items-center m-0">
                            <div class="input-group d-flex" style="max-width: 8rem;">
                                <button type="button" class="btn btn-dark" onclick="decrementQuantity()">-</button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    class="form-control text-center text-dark" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $products->stock }}" readonly style="max-width: 5rem">
                                <button type="button" class="btn btn-dark " onclick="incrementQuantity()">+</button>
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
                        <div class="col-12 col-md-6 col-lg-2 mb-4">
                            <div class="card position-relative">
                                <!-- Label Indicator -->
                                {{-- @if($product->is_new)
                                <div class="position-absolute top-0 start-0 bg-success text-white p-1 px-2 rounded-end" style="font-size: 0.75rem; z-index: 20;">
                                    New
                                </div>
                                @elseif($product->on_sale)
                                <div class="position-absolute top-0 start-0 bg-danger text-white p-1 px-2 rounded-end" style="font-size: 0.75rem; z-index: 2;">
                                    Sale
                                </div>
                                @endif --}}
                                <div class="position-absolute top-0 start-0 bg-success text-white p-1 px-2 rounded-end" style="font-size: 0.75rem; z-index: 20;">
                                    New
                                </div>
                                <!-- Product Image -->
                                <img class="card-img-center p-2 mt-3" src="{{ $recommendedProduct->image }}" alt="Product Image" />
                                <!-- Product Details -->
                                <div class="card-body p-3">
                                    <div class="text-start">
                                        <!-- Product Name -->
                                        <h6 class="fw-bolder text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $recommendedProduct->title }}
                                        </h6>
                                        <!-- Product Price -->
                                        ₱ {{ $recommendedProduct->price }}
                                    </div>
                                </div>
                                <!-- Product Actions -->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $recommendedProduct->slug) }}')">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto w-100">Details</a>
                                    </div>
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
