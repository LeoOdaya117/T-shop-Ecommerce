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
            <div class="container px-4 px-lg-5 ">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <img class="card-img-top mb-2 mb-md-0 mt-md-0" src="{{ $products->image }}" alt="Product Image" />
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                        <div class="fs-5 mb-2">
                            @if ($products->discount > 0)
                                <span class="text-muted text-decoration-line-through">₱ {{ $products->price }}</span>
                            @endif
                            <span>₱ {{ $products->price - $products->discount }}</span>
                        </div>
                        @php
                            $sentences = explode('.', $products->descrption); // Split by periods
                            $limitedDescription = implode('.', array_slice($sentences, 0, 4)) . (count($sentences) > 4 ? '...' : ''); // Join the first 4 sentences and add '...' if there are more sentences
                        @endphp
        
                        <p class="lead">{{ $limitedDescription }}</p>
        
                        @php
                            // Group variants by color
                            $groupedByColor = $variants->groupBy('color');
                        @endphp
        
                        <p class="text-muted">Color</p>
                        @foreach ($groupedByColor as $color => $group)
                            <button class="btn btn-outline-dark text-dark bg-transparent mb-2" 
                                    data-color="{{ $color }}" 
                                    onclick="updateSizeOptions('{{ $color }}')">{{ $color }}</button>
                        @endforeach
        
                        <p class="text-muted">Size</p>
                        @foreach ($groupedByColor as $color => $group)
                            <div id="sizes-for-{{ $color }}" class="sizes" style="display: none;">
                                @foreach ($group as $variant)
                                    <button class="btn btn-outline-dark text-dark bg-transparent mb-2" 
                                            onclick="selectSize('{{ $color }}', '{{ $variant->size }}')">
                                        {{ strtoupper(substr($variant->size, 0, 1)) }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        @endforeach
        
        
                        <div class="d-flex mb-2 align-items-center m-0">
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
                            <p class="text-center text-muted mb-0 ms-3 stock-display" id="stock-display">
                               {{-- STOCK DISPLAY HERE --}}
                            </p>
                        </div>
        
                        <div class="d-flex">
                            <button class="btn btn-outline-dark text-dark bg-transparent" onclick="addToWishList({{ $products->id}},'{{ $products->title }}')"
                                id="wishlistButton" style="display: none;">
                                Add to Wishlist</button>
                            <button class="btn btn-outline-dark text-dark bg-transparent" onclick="addToCart({{ $products->id }})" id="addToCartButton">Add to Cart</button>
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

        let selectedColor = '';
    let selectedSize = '';

    // Update the size options based on the selected color
    function updateSizeOptions(color) {
        selectedColor = color;
        // Hide all size options and show the sizes for the selected color
        document.querySelectorAll('.sizes').forEach(function(element) {
            element.style.display = 'none';
        });
        document.getElementById(`sizes-for-${color}`).style.display = 'block';
        // Reset the selected size and stock info
        selectedSize = '';
        document.getElementById('stock-display').textContent = 'Select a size to view stock availability.';
    }

    // Select size and display stock info
    function selectSize(color, size) {
        selectedSize = size;
        let selectedVariant = @json($variants);
        let variant = selectedVariant.find(variant => variant.color === color && variant.size === size);
        
        let stockDisplay = document.getElementById('stock-display');
        let wishlistButton = document.getElementById('wishlistButton');
        let addToCartButton = document.getElementById('addToCartButton');
        if (variant && variant.stock > 0) {
            stockDisplay.innerHTML = `${variant.stock} stocks available`;
            stockDisplay.classList.remove('text-danger'); // Remove out-of-stock class if any
            stockDisplay.classList.add('text-success'); // Add in-stock class
            wishlistButton.style.display = 'none';
            addToCartButton.style.display = 'block';
        } else {
            stockDisplay.innerHTML = 'Out of stock';
            stockDisplay.classList.remove('text-success'); // Remove in-stock class if any
            stockDisplay.classList.add('text-danger'); // Add out-of-stock class
            wishlistButton.style.display = 'block';
            addToCartButton.style.display = 'none';
        }


    }

    </script>
@endsection()
