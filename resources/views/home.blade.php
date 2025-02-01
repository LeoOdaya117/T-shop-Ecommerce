@extends('layouts.default')
@section('title', 'Home')
@section('style')
<style>
   
        .card, .btn {
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            background-color: #f8f9fa; 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }

        .card img {
            object-fit: contain; /* Ensures the image fits within the specified height and width */
            max-height: 200px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            
        }
</style>
@endsection()
@section('content')
    <main class="container w-100 mb-5">
        
        <!-- Hero Section -->
        <section class="hero-section pt-5 mb-5 text-center align-content-center w-100" style="background-image: url('https://i.pinimg.com/736x/6a/2e/a0/6a2ea0edd5e1a2256652b2e48f22615c.jpg'); background-size: cover; background-position: center; height: 400px; color: white;">
            <div class="hero-content h-100 align-content-center" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
                <h1 class="display-4">Welcome to T-Shop</h1>
                <p class="lead">Discover the best t-shirts for every occasion</p>
                <a href="{{ route('shop') }}" class="btn bg-transparent border-light btn-lg text-light">Shop Now</a>
            </div>
        </section>

        <section  class="brands card-products mb-5" data-aos="fade-up">
            <div class="container align-content-center justify-content-center text-center">
                <p class="lead"><strong>Discover your favorite brands</strong></p>
                <div class="row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4             justify-content-center gap-2">
                    @foreach ($brands as $brand)
                        <div class="col-12 col-md-12 p-1 align-items-center text-center" style="height: auto; width:auto;" >
                            <div class="card p-3 align-items-center rounded-circle mb-1" style="background: url('{{ $brand->image }}'); background-size: contain; background-position: center; height: 75px; width:75px; ">

                            </div>
                            <p>{{ $brand->name }}</p>
                        </div>
                    @endforeach
                    
            </div>
        </section>

        <!-- Popular Products -->
        <section class="featured-products mt-3 mb-3" data-aos="fade-up">
            <h4 class="text-start mb-4 font-weight-lighter">Popular Products</h4>
            <div class="row gx-3 gx-lg-5 p-0 row-cols-2 row-cols-md-4 row-cols-xl-4 ">
                
                @foreach ($popularProducts as $featuredProduct)
                    <div class="col-12 col-md-6 col-lg-2 mb-4" data-aos="fade-up" onclick="route('{{ route('showDetails', $featuredProduct->slug) }}')">
                        <div class="card position-relative">
                            @if($featuredProduct->created_at->between(Carbon\Carbon::now()->startOfWeek(), Carbon\Carbon::now()->endOfWeek()))
                                <div class="position-absolute top-0 start-0 bg-success text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    New
                                </div>  
                            @elseif($featuredProduct->discount != 0.00)
                                <div class="position-absolute top-0 start-0 bg-danger text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    Sale
                                </div>
                            @endif

                            <!-- Product Image -->
                            <img class="card-img-center p-2 mt-3" src="{{ $featuredProduct->image }}" alt="Product Image" />
                            <!-- Product Details -->
                            <div class="card-body p-3">
                                <div class="text-start">
                                    <!-- Product Name -->
                                    <h6 class="fw-bolder text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $featuredProduct->title }}
                                    </h6>
                                    <!-- Product Price -->
                                   <div class="d-flex gap-1">
                                        ₱ {{number_format( $featuredProduct->price - $featuredProduct->discount,2)}}
                                        @if($featuredProduct->discount > 0.00)
                                            <div class="text-muted text-decoration-line-through align-content-center" style="font-size: 12px">₱ {{ number_format($featuredProduct->price,2) }}</div>

                                        @endif
                                   </div>

                                   {{-- Star Rating Section --}}
                                   <div class="d-flex justify-content-between align-items-center">
                        
                                        
                                        @php
                                            $averageRating = $featuredProduct->reviews->avg('rating') ?? 0;
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

                                            <span class="ms-1 text-muted">({{ $featuredProduct->reviews->count() }})</span>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- Product Actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $featuredProduct->slug) }}')">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto w-100">Details</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
                        
            </div>
        </section>
        
        <!-- Categories -->
        <section class=" card-products mb-3" data-aos="fade-up">
            <h4 class="text-start mb-4 font-weight-lighter">Categories</h4>
                <div class="row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($categories as $category)
                        <div data-aos="fade-up" class="col-12 col-md-12 p-1 align-items-center" style="height: auto; width:150px;" >
                            <div class="card p-3 align-items-center" onclick="route('{{ route('search.category.product', $category->id) }}')">
                                <img src="{{ $category->image ?? asset('assets/image/no-image.jpg') }}" class="image-fluid m-" alt="{{ $category->name }}" style="height: 100px; width:100px; object-fit: cover;">
                                <p class="card-title text-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width:100px;">{{ $category->name }}</p>
                                
                            </div>
                        </div>


                    
                    @endforeach
                </div>
        </section>

        <!-- New Arrival -->
        <section class="featured-products mb-3" data-aos="fade-up" 
            @if ($new_arrival->count() < 1)
                hidden
            @endif  
        >
            <h4 class="text-start mb-4 font-weight-lighter">This Month New Arrival</h4>
            <div class="row gx-3 gx-lg-5 p-0 row-cols-2 row-cols-md-4 row-cols-xl-4 ">
                
                @foreach ($new_arrival as $product)
                    <div class="col-12 col-md-6 col-lg-2 mb-4" onclick="route('{{ route('showDetails', $product->slug) }}')">
                        <div class="card position-relative rounded" data-aos="fade-up">
                            @if($product->discount == 0.00)
                                <div class="position-absolute top-0 start-0 bg-success text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    New
                                </div>  
                            @else
                                <div class="position-absolute top-0 start-0 bg-danger text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    Sale
                                </div>
                            @endif
                            <!-- Product Image -->
                            <img class="card-img-center p-2 mt-3" src="{{ $product->image }}" alt="Product Image" />
                            <!-- Product Details -->
                            <div class="card-body p-3">
                                <div class="text-start">
                                    <!-- Product Name -->
                                    <h6 class="fw-bolder text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $product->title }}
                                    </h6>
                                    <!-- Product Price -->
                                   <div class="d-flex gap-1">
                                        ₱ {{ number_format($product->price - $product->discount,2)}}
                                        @if($product->discount > 0.00)
                                            <div class="text-muted text-decoration-line-through align-content-center" style="font-size: 12px">₱ {{ $product->price }}</div>

                                        @endif
                                   </div>
                                    {{-- Star Rating Section --}}
                                   <div class="d-flex justify-content-between align-items-center">
                        
                                        @php
                                            $averageRating = $product->reviews->avg('rating') ?? 0;
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

                                            <span class="ms-1 text-muted">({{ $product->reviews->count() }})</span>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            {{-- <!-- Product Actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto w-100">Details</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
                        
            </div>
        </section>

        <!-- Just For You -->
        <section class=" justforyou-products mb-3" data-aos="fade-up">
            <h4 class="text-start mb-4 font-weight-lighter">Just For You</h4>

            <div id="product-container" class="row gx-4 gx-lg-5  row-cols-2 row-cols-md-3 row-cols-xl-4 "> <!-- Flexbox for equal height -->
                
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-2 mb-4" onclick="route('{{ route('showDetails', $product->slug) }}')">
                        <div class="card position-relative" data-aos="fade-up">
                            @if($product->created_at->between(Carbon\Carbon::now()->startOfWeek(), Carbon\Carbon::now()->endOfWeek()))
                                <div class="position-absolute top-0 start-0 bg-success text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    New
                                </div>  
                            @elseif($product->discount != 0.00)
                                <div class="position-absolute top-0 start-0 bg-danger text-white p-1 px-2 rounded-end" 
                                    style="font-size: 0.75rem; z-index: 20;">
                                    Sale
                                </div>
                            @endif
                            <!-- Product Image -->
                            <img class="card-img-center p-2 mt-3" src="{{ $product->image }}" alt="Product Image" />
                            <!-- Product Details -->
                            <div class="card-body p-3">
                                <div class="text-start">
                                    <!-- Product Name -->
                                    <h6 class="fw-bolder text-truncate" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $product->title }}
                                    </h6>
                                    <!-- Product Price -->
                                    <div class="d-flex gap-1">
                                        ₱ {{ number_format($product->price - $product->discount,2)}}
                                        @if($product->discount > 0.00)
                                            <div class="text-muted text-decoration-line-through align-content-center" style="font-size: 12px">₱ {{ number_format($product->price ,2)}}</div>
    
                                        @endif
                                    </div>
                                    {{-- Star Rating Section --}}
                                    <div class="d-flex justify-content-between align-items-center">
                        
                                        @php
                                            $averageRating = $product->reviews->avg('rating') ?? 0;
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

                                            <span class="ms-1 text-muted">({{ $product->reviews->count() }})</span>
                                        </div>
                                    
                                    
                                    </div>
                                    
                                </div>
                            </div>
                            {{-- <!-- Product Actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto w-100">Details</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4 w-100">
                <button id="load-more" class="btn btn-outline-dark w-50">Load More</button>
            </div>
        </section>
    
        <!-- Newsletter Signup -->
        <section class="newsletter-signup pt-5 text-center">
            <h2 class="mb-4">Stay Updated</h2>
            <p class="lead">Sign up for our newsletter to get the latest updates and offers</p>
            <form action="" method="POST" class="form-inline justify-content-center">
                @csrf
                <input type="email" name="email" class="form-control mb-2 mr-sm-2" placeholder="Enter your email">
                <button type="submit" class="btn btn-primary mb-2">Subscribe</button>
            </form>
        </section>
    </main>
@endsection
@section("script")
    <script>
       
        function route(routeUrl) {
            window.location.href = routeUrl;
        }
        
        let skip = {{ count($products) }};
            document.getElementById('load-more').addEventListener('click', function() {
                fetch(`/load-more-products?skip=${skip}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('product-container').insertAdjacentHTML('beforeend', data.html);
                        skip += 8; // Update the skip value

                        if (!data.hasMore) {
                            document.getElementById('load-more').style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
    </script>
@endsection()