@extends("layouts.default")
@section("title", "T-Shop - Home")

@section("style")
    <style>
        
        .product-image{
            object-fit: contain; /* Ensures the image fits within the specified height and width */
            max-height: 75%;
        }
        .btn:hover .fa-heart {
        background-color: rgba(255, 0, 0, 0.1); /* Light red background */
        transform: scale(1.1); /* Slightly larger on hover */
        transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
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
                        <img class="card-img-top mb-2 mb-md-0 mt-md-0 product-image" src="{{ $products->image }}" alt="Product Image" />
                    </div>
                    <div class="col-md-6">
                        {{-- Brand Name --}}
                        {{-- <h5 class="text-muted">{{ $products->brands->name }}</h5> --}}
                        
                        {{-- Product Title & Wishlist Button --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="display-5 fw-bolder">{{ $products->title }}</h1>
                            
                            
                        </div>
                        {{-- Products ratings & wishlist button --}}
                        <div class="d-flex justify-content-between align-items-center">
                    
                            {{-- Star Rating Section --}}
                            @php
                                $averageRating = $products->reviews->avg('rating') ?? 0;
                            @endphp

                            <div class="d-flex align-items-center mb-2">
                                @for ($i = 1; $i <= floor($averageRating); $i++)
                                    <i class="fa fa-star text-warning"></i>
                                @endfor

                                @if (($averageRating - floor($averageRating)) >= 0.5)
                                    <i class="fa fa-star-half-alt text-warning"></i>
                                @endif

                                @for ($i = ceil($averageRating); $i < 5; $i++)
                                    <i class="fa fa-star text-muted"></i>
                                @endfor

                                <span class="ms-2 text-muted">({{ $products->reviews->count() }} reviews)</span>
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

                        {{-- <div class="d-flex gap-2 align-content-center text-center align-items-center">
                            <p class="text-muted">Color: </p>
                            <select name="" id="" class="form-select mb-3 w-50 ml-2" onchange="updateSizeOptions(this.value)">
                                <option selected disabled>Select color</option>
                                @foreach ($groupedByColor as $color => $group)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <!-- Color Selection -->
                        <div class="d-flex gap-2 align-items-center text-center mb-3">
                            <p class="text-muted mb-0">Color: </p>
                            <div class="d-flex gap-2" id="color-options">
                                @foreach ($groupedByColor as $color => $group)
                                    <div class="color-option rounded-circle border border-secondary"
                                        style="width: 30px; height: 30px; background-color: {{ $color }}; cursor: pointer; transition: 0.3s ease-in-out; display: flex; justify-content: center; align-items: center;"
                                        onclick="updateSizeOptions('{{ $color }}')"
                                        data-color="{{ $color }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Size Selection -->
                        <div class="d-flex gap-3 align-items-center text-center mb-3">
                            <p class="text-muted mb-0">Size: </p>
                            @foreach ($groupedByColor as $color => $group)
                                <div id="sizes-for-{{ $color }}" class="sizes" style="display: block;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        @foreach ($group as $variant)
                                            <div class="size-option border border-secondary rounded-3" 
                                                style="width: 40px; height: 40px; cursor: pointer; display: flex; justify-content: center; align-items: center; background-color: white;"
                                                onclick="selectSize('{{ $color }}', '{{ $variant->size }}')" 
                                                data-color="{{ $color }}" 
                                                data-size="{{ $variant->size }}">
                                                <span>{{ strtoupper(substr($variant->size, 0, 1)) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Hidden input for variant ID --}}
                        <input type="hidden" id="selectedVariantId" name="variant_id" value="">

                        <div class="d-flex mb-3 align-items-center m-0">
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

                        <div class="d-flex gap-2">
                            
                            <button class="btn btn-large btn-outline-dark text-dark bg-transparent shadow-lg" onclick="addToCart({{ $products->id }})" id="addToCartButton">
                                Add to Cart
                            </button>
                            <button class="btn btn-large btn-outline-dark text-dark bg-warning shadow-lg" onclick="addToCart({{ $products->id }})" id="addToCartButton">
                                Buy Now
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
                                        <h3 class="fw-bold mb-3 w-100 text-center">Customer Reviews</h3>
                                
                                        <!-- Left Section: Overall Rating & Review Count -->
                                        <div class="col-md-2 d-flex flex-column align-items-center text-center">
                                            <h1 class="font-weight-bold mb-1">{{ number_format($reviewSummary['average_rating'], 1) }}</h1>
                                            <div class="d-flex justify-content-center mb-2">
                                                @for ($i = 1; $i <= floor($reviewSummary['average_rating']); $i++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor
                                                
                                                @if (($reviewSummary['average_rating'] - floor($reviewSummary['average_rating'])) >= 0.5)
                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                @endif
                                                
                                                @for ($i = ceil($reviewSummary['average_rating']); $i < 5; $i++)
                                                    <i class="fa fa-star text-secondary"></i>
                                                @endfor
                                            </div>
                                            <p class="text-muted">{{ $reviewSummary['total_reviews'] }} Reviews</p>
                                        </div>
                                
                                        <!-- Right Section: Star Breakdown -->
                                        <div class="col-md-10">
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

                                    @forelse ($reviews as $review)
    
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
                                        
                                    @empty

                                    <p>No reviews found.</p>
                                    
                                    
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    
        {{-- REALATED PRODUCTS --}}
        <section class="mt-5 mb-4">
            <h4 class="mb-4">Related Products</h4>
            <div class="row g-3 product-list">
                @if (count($relatedProducts) == 0)
                    <div class="col-12">
                        <div class="alert text-center">
                            No related products found.
                        </div>
                    </div>
                    
                @else
                    
                    @foreach ($relatedProducts as $recommendedProduct)
                        <div class="col-12 col-md-6 col-lg-3 mb-2" onclick="route('{{ route('showDetails', $recommendedProduct->slug) }}')">
                            <div class="product-card card">
                                <div class="position-relative">
                                    @if(\Carbon\Carbon::parse($recommendedProduct->created_at)->isToday())
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-2">New</span>
                                    @endif

                                    @if($recommendedProduct->discount > 0)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                    @endif

                                    <img src="{{ $recommendedProduct->image }}" alt="Product Image" class="card-img-top">
                                </div>

                                <div class="card-body text-center">
                                    <h6 class="text-truncate">{{ $recommendedProduct->title }}</h6>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="price">₱ {{ number_format($recommendedProduct->price - $recommendedProduct->discount, 2) }}</span>
                                        @if($recommendedProduct->discount > 0)
                                            <span class="old-price">₱ {{ number_format($recommendedProduct->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="star-rating">
                                        @php
                                            $rating = $recommendedProduct->reviews->avg('rating') ?? 0;
                                            $fullStars = floor($rating);
                                            $halfStars = ceil($rating - $fullStars);
                                        @endphp
                                        @if($rating == 0)
                                            <i class="fa fa-star text-muted"></i>
                                            <i class="fa fa-star text-muted"></i>
                                            <i class="fa fa-star text-muted"></i>
                                            <i class="fa fa-star text-muted"></i>
                                            <i class="fa fa-star text-muted"></i>
                                        @else
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fa fa-star text-warning"></i>
                                            @endfor
                                            @for ($i = 0; $i < $halfStars; $i++)
                                                <i class="fa fa-star-half-alt text-warning"></i>
                                            @endfor
                                            @for ($i = $fullStars + $halfStars; $i < 5; $i++)
                                                <i class="fa fa-star-o text-light"></i>
                                            @endfor
                                        @endif
                                        ({{ $recommendedProduct->reviews->count() }})
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
        window.routeUrls = {
            addToWishlists: "{{ route('add.wishlist') }}",
            removeToWishlist: "{{ route('delete.user.wishlist') }}",
            
            login: "{{ route('login') }}",
        };
        window.variantData = @json($variants ?? []);
        window.wishlistItems = @json($wishlistItems ?? []);
        
    </script>
    <script src="{{ asset('assets/js/product_details.js') }}"></script>
    
@endsection()
