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
        

        
        {{-- PRODUCT SECTION --}}
        <section class="py-5 shadow-lg mb-5 shadow-sm" style="background: rgb(241, 240, 240)">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <img class="card-img-top mb-2 mb-md-0 mt-md-0" src="{{ $products->image }}" alt="Product Image" />
                    </div>
                    <div class="col-md-6">
                        {{-- Brand Name --}}
                        {{-- <h5 class="text-muted">{{ $products->brands->name }}</h5> --}}
                        
                        {{-- Product Title & Wishlist Button --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                            
                            
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                    
                            {{-- Star Rating Section --}}
                            @php
                                 $averageRating = $products->reviews->avg('rating') ?? 0;
                                 $roundedRating = round($averageRating);
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-star {{ $i <= $roundedRating ? 'fa-solid text-warning' : 'fa-regular text-muted' }}"></i>
                                @endfor
                                <span class="ms-2 text-muted">({{ $products->reviews->count()  }} reviews)</span>
                            </div>
                            {{-- Wishlist Heart Icon --}}
                            <button class="btn btn-light border-0" onclick="toggleWishlist(this, {{ $products->id }}, '{{ $products->title }}')">
                                <i class="fa-solid fa-heart 
                                
                                
                                 @php
                                    // Default to dark (black)
                                    $wishlistClass = 'text-dark';

                                    // Check if any variant of this product is in the wishlist
                                    if ($variants->whereIn('id', $wishlistItems)->count() > 0) {
                                        $wishlistClass = 'text-danger';
                                    }
                                @endphp
                                " id="wishlist-icon-{{ $products->id }}"></i>
                            </button>
                        </div>
                        <p class="text-muted">Brand: {{ $products->brands->name }}</p>
                        {{-- Price --}}
                        <h2 class="fs-5 mb-2">
                            @if ($products->discount > 0)
                                <span class="text-muted text-decoration-line-through">₱ {{ number_format($products->price,2) }}</span>
                            @endif
                            <span>₱ {{ number_format($products->price - $products->discount,2) }}</span>
                        </h2>

                        @php
                            $sentences = explode('.', $products->descrption);
                            $limitedDescription = implode('.', array_slice($sentences, 0, 2)) . (count($sentences) > 4 ? '...' : '');
                        @endphp

                        <p class="lead">{{ $limitedDescription }}</p>

                        @php
                            // Group variants by color
                            $groupedByColor = $variants->groupBy('color');
                        @endphp

                        <div class="d-flex gap-2 align-content-center text-center align-items-center">
                            <p class="text-muted">Color: </p>
                            <select name="" id="" class="form-select mb-3 w-50 ml-2" onchange="updateSizeOptions(this.value)">
                                <option selected disabled>Select color</option>
                                @foreach ($groupedByColor as $color => $group)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex gap-3 align-content-center text-center align-items-center mb-2">
                            <p class="text-muted">Size: </p>
                            @foreach ($groupedByColor as $color => $group)
                                <div id="sizes-for-{{ $color }}" class="sizes" style="display: none;">
                                    <select class="form-select mb-2 ml-2" onchange="selectSize('{{ $color }}', this.value)">
                                        <option value="" selected disabled>Select Size</option>
                                        @foreach ($group as $variant)
                                            <option value="{{ $variant->size }}">
                                                {{ strtoupper(substr($variant->size, 0, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        <input type="hidden" id="selectedVariantId" name="variant_id" value="">

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
                                    max="" readonly style="max-width: 5rem">
                                <button type="button" class="btn btn-dark " onclick="incrementQuantity()">+</button>
                            </div>
                            <p class="text-center text-muted mb-0 ms-3 stock-display" id="stock-display">
                                {{-- STOCK DISPLAY HERE --}}
                            </p>
                        </div>

                        <div class="d-flex">
                            <button class="btn btn-outline-dark text-dark bg-transparent" onclick="addToCart({{ $products->id }})" id="addToCartButton">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

        {{-- DESCRIPTION AND REVEIEWS --}}
        <section>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                <div class="tab-regular ">
                    <ul class="nav nav-tabs " id="myTab7" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-justify" data-toggle="tab" href="#home-justify" 
                               role="tab" aria-controls="home-justify" aria-selected="true"><strong>Description</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-justify" data-toggle="tab" href="#profile-justify" 
                               role="tab" aria-controls="profile-justify" aria-selected="false"><strong>Review</strong></a>
                        </li>
                    </ul>
                    <div class="container tab-content bg-white p-3" id="myTabContent7">
                        <div class="tab-pane fade show active container " id="home-justify" role="tabpanel" aria-labelledby="home-tab-justify">
                            <p class="lead"> <strong>{{ $products->title }} Description</strong></p>
                            <p>{{ $products->descrption }}</p>
                        </div>
                        <div class="tab-pane fade" id="profile-justify" role="tabpanel" aria-labelledby="profile-tab-justify">
                            <div class="container">

                                <div class="container-fluid mb-2">
                                    <div class="row align-items-center">
                                        <h3 class="fw-bold mb-3">Customer Reviews</h3>
                                
                                        <!-- Left Section: Overall Rating & Review Count -->
                                        <div class="col-md-2 d-flex flex-column align-items-center text-center">
                                            <h1 class="font-weight-bold mb-1">{{ number_format($reviewSummary['average_rating'], 1) }}</h1>
                                            <div class="d-flex justify-content-center mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{ $i <= round($reviewSummary['average_rating']) ? 'text-warning' : 'text-secondary' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="text-muted">{{ $reviewSummary['total_reviews'] }} Reviews</p>
                                        </div>
                                
                                        <!-- Right Section: Star Breakdown -->
                                        <div class="col-md-9">
                                            @foreach ($reviewSummary['ratings'] as $stars => $data)
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="mr-2">{{ $stars }} <i class="fa fa-star text-warning"></i></span>
                                                    <div class="progress flex-grow-1" style="height: 10px;">
                                                        <div class="progress-bar bg-warning" role="progressbar" 
                                                             style="width: {{ $data['percentage'] }}%;" 
                                                             aria-valuenow="{{ $data['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span class="ml-2">{{ $data['count'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="container">
                                    <h4 class="fw-bold mb-3">Reviews</h4>

                                    @foreach ($reviews as $review)
    
                                    <div class="mb-1">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- User Image -->
                                                <div class="col-auto">
                                                    <img class="rounded-circle" src="https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg" alt="User Avatar" width="50px" height="50px">
                                                </div>
                                            
                                                <!-- User Name and Rating -->
                                                <div class="col d-flex flex-column">
                                                    <h5 class="mb-1">{{ $review->user->firstname }} {{ $review->user->lastname }}</h5>
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @for ($i = 1; $i <= $review->rating; $i++)
                                                                <i class="fa fa-star text-warning"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="text-muted mb-0 ms-3">{{ $review->created_at->diffForHumans() }}</p>
                                                    </div>
                                            
                                                    <div class="mt-3">
                                                        <p class="fw-bold">{{ $review->title }}</p>
                                                        <p>{{ $review->comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                    

                                        </div>
                                    </div>
                                    <hr>
                                    
                                    
                                    
                                    
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    
        {{-- REALATED PRODUCTS --}}
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
        $(document).ready(function () {
            $('#myTab7 a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });

       
        function addToCart(productId) {
            // Get the quantity selected by the user
            updateCartItemNumber();
            const quantity = document.getElementById('quantity').value;
            const varaint_id = document.getElementById('selectedVariantId').value;
            // Send AJAX request to add product to cart

            if(!varaint_id){
                // alert('No color and size selected!');
                Swal.fire({
                            icon: 'error',
                            title: `No color and size selected!`,
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
                return;
            }
            
            $.ajax({
                url: '/cart/' + productId + '/' + quantity + '/' + varaint_id,
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
                            // html: '<a class="btn btn-outline-dark text-dark bg-transparent" type="submit" href="{{ route("cart.show") }}"><i class="fa-solid fa-cart-shopping"></i>Cart</a>',
                            didOpen: (toast) => {
                                // toast.addEventListener('mouseenter', Swal.stopTimer);
                                // toast.addEventListener('mouseleave', Swal.resumeTimer);

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
        let variant = null;

        // Update the size options based on the selected color
        function updateSizeOptions(color) {
            selectedColor = color;
            document.querySelectorAll('.sizes').forEach(el => el.style.display = 'none');
            document.getElementById(`sizes-for-${color}`).style.display = 'block';

            // Reset size and stock display
            selectedSize = '';
            variant = null;
            document.getElementById('stock-display').textContent = 'Select a size to view stock availability.';
            updateWishlistIcon();
        }

        // Select size and display stock info
        function selectSize(color, size) {
            selectedSize = size;
            let selectedVariant = @json($variants);
            variant = selectedVariant.find(v => v.color === color && v.size === size);

            if (variant) {
                document.getElementById('selectedVariantId').value = variant.id;
                console.log(variant.id, variant.stock, variant.size, variant.color);

                let stockDisplay = document.getElementById('stock-display');
                let stocksMax = document.getElementById('quantity');
                // let wishlistButton = document.getElementById('wishlistButton');
                let addToCartButton = document.getElementById('addToCartButton');

                if (variant.stock > 0) {
                    stockDisplay.innerHTML = `${variant.stock} stocks available`;
                    stocksMax.value = 1;
                    stocksMax.max = variant.stock;
                    stockDisplay.classList.add('text-success');
                    stockDisplay.classList.remove('text-danger');
                    // wishlistButton.style.display = 'none';
                    addToCartButton.style.display = 'block';
                } else {
                    stockDisplay.innerHTML = 'Out of stock';
                    stockDisplay.classList.add('text-danger');
                    stockDisplay.classList.remove('text-success');
                    // wishlistButton.style.display = 'block';
                    addToCartButton.style.display = 'none';
                }

                updateWishlistIcon(); // Update the wishlist icon based on the selected variant
            }
        }

        // Function to toggle wishlist icon
        function toggleWishlist(button, productId, productTitle) {
            if (!variant) {
                Swal.fire({
                            icon: 'error',
                            title: `No color and size selected!`,
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
                return;
                return;
            }

            let icon = document.getElementById(`wishlist-icon-${productId}`);

            if (icon.classList.contains("text-dark")) {
                // icon.classList.remove("text-dark");
                // icon.classList.add("text-danger");
                addToWishList(productId, productTitle, variant.id);
            } else {
                // icon.classList.remove("text-danger");
                // icon.classList.add("text-dark");
                removeFromWishList(productId, productTitle, variant.id);
            }
        }

        // Add to wishlist AJAX
        function addToWishList(product_id, title, variant_id) {
            let icon = document.getElementById(`wishlist-icon-${product_id}`);
            $.ajax({
                type: "POST",
                url: "{{ route('add.wishlist') }}",
                data: { product_id, variant_id, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: `${title} added to wishlist`,
                            toast: true, position: 'center-end',
                            showConfirmButton: false, timer: 3000, timerProgressBar: true
                        });
                        icon.classList.remove("text-dark");
                        icon.classList.add("text-danger");
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: response.message,
                            toast: true, position: 'center-end',
                            showConfirmButton: false, timer: 3000, timerProgressBar: true
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON.message || 'An error occurred',
                        toast: true, position: 'center-end',
                        showConfirmButton: false, timer: 3000, timerProgressBar: true
                    });
                }
            });
        }


        function removeFromWishList(product_id, title, variant_id){
            let icon = document.getElementById(`wishlist-icon-${product_id}`);
            $.ajax({
                type: "DELETE",
                url: "{{ route('delete.user.wishlist') }}",
                data: { product_id, variant_id, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'info',
                            title: `${title} removed from wishlist`,
                            toast: true, position: 'center-end',
                            showConfirmButton: false, timer: 3000, timerProgressBar: true
                        });
                        icon.classList.remove("text-danger");
                        icon.classList.add("text-dark");
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: response.message,
                            toast: true, position: 'center-end',
                            showConfirmButton: false, timer: 3000, timerProgressBar: true
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON.message || 'An error occurred',
                        toast: true, position: 'center-end',
                        showConfirmButton: false, timer: 3000, timerProgressBar: true
                    });
                }
            });
        }

        // Update wishlist icon when a variant is selected
        function updateWishlistIcon() {
            if (!variant) {
                return; // If no variant is selected, do nothing
            }
            console.log('asd ' + variant.id);
            let icon = document.getElementById(`wishlist-icon-{{ $products->id }}`);
            let wishlistItems = @json($wishlistItems); // Wishlist from controller
            // console.log(wishlistItems[0]);
            // Check if the selected variant is in the wishlist
            if (wishlistItems[0] === variant.id) {
                icon.classList.remove("text-dark");
                icon.classList.add("text-danger"); // Show red icon
            } else {
                icon.classList.remove("text-danger");
                icon.classList.add("text-dark"); // Show black icon
            }
        }

        // On page load, call the updateWishlistIcon to set the correct state
        document.addEventListener("DOMContentLoaded", function() {
            updateWishlistIcon();
        });


    </script>
    
@endsection()
