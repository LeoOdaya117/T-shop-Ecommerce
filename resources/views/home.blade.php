@extends('layouts.default')
@section('title', 'Home')
@section('style')
<style>
   
        
</style>
<link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
@endsection()
@section('content')
    <main class="container w-100 mb-5">
        
        <!-- Hero Section -->
        <section class="hero-section  mb-5 text-center align-content-center w-100" style="background-image: url('https://i.pinimg.com/736x/6a/2e/a0/6a2ea0edd5e1a2256652b2e48f22615c.jpg'); background-size: cover; background-position: center; height: 400px; color: white;">
            <div class="hero-content pt-5 h-100 align-content-center" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
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
                        <div class="col-12 col-md-12 p-1 align-items-center text-center" style="height: auto; width:auto;" onclick="route('{{ route('shop', ['brand[]' => $brand->id]) }}')" >
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
            <div class="row g-3 product-list">
                
                @foreach ($popularProducts as $featuredProduct)
                    <div data-aos="fade-up" class="col-12 col-md-6 col-lg-3 mb-2" onclick="route('{{ route('showDetails', $featuredProduct->slug) }}')">
                        <div class="product-card card">
                            <div class="position-relative">
                                @if(\Carbon\Carbon::parse($featuredProduct->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->startOfWeek()))
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">New</span>
                                @endif

                                @if($featuredProduct->discount > 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                @endif

                                <img src="{{ $featuredProduct->image }}" alt="Product Image" class="card-img-top">
                            </div>

                            <div class="card-body text-center">
                                <h6 class="text-truncate">{{ $featuredProduct->title }}</h6>
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="price">₱ {{ number_format($featuredProduct->price - $featuredProduct->discount, 2) }}</span>
                                    @if($featuredProduct->discount > 0)
                                        <span class="old-price">₱ {{ number_format($featuredProduct->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="star-rating">
                                    @php
                                        $rating = $featuredProduct->reviews->avg('rating') ?? 0;
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
                                    ({{ $featuredProduct->reviews->count() }})
                                </div>
                            </div>
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
                            <div class="card p-3 align-items-center"     onclick="route('{{ route('shop', ['category[]' => $category->id]) }}')">
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
            <div class="row g-3 product-list">
                
                @foreach ($new_arrival as $product)
                    <div data-aos="fade-up" class="col-12 col-md-6 col-lg-3 mb-2" onclick="route('{{ route('showDetails', $product->slug) }}')">
                        <div class="product-card card">
                            <div class="position-relative">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2">New</span>


                                @if($product->discount > 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                @endif

                                <img src="{{ $product->image }}" alt="Product Image" class="card-img-top">
                            </div>

                            <div class="card-body text-center">
                                <h6 class="text-truncate">{{ $product->title }}</h6>
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="price">₱ {{ number_format($product->price - $product->discount, 2) }}</span>
                                    @if($product->discount > 0)
                                        <span class="old-price">₱ {{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="star-rating">
                                    @php
                                        $rating = $product->reviews->avg('rating') ?? 0;
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
                                    ({{ $product->reviews->count() }})
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                        
            </div>
        </section>

        <!-- Just For You -->
        <section class=" justforyou-products mb-3" data-aos="fade-up">
            <h4 class="text-start mb-4 font-weight-lighter">Just For You</h4>

            <div id="product-container" class="row g-3 product-list"> <!-- Flexbox for equal height -->
                
                @foreach ($products as $product)
                    <div data-aos="fade-up" class="col-12 col-md-6 col-lg-3 mb-2" onclick="route('{{ route('showDetails', $product->slug) }}')">
                        <div class="product-card card">
                            <div class="position-relative">
                                @if(\Carbon\Carbon::parse($product->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->startOfWeek()))
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">New</span>
                                @endif

                                @if($product->discount > 0)
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                                @endif

                                <img src="{{ $product->image }}" alt="Product Image" class="card-img-top">
                            </div>

                            <div class="card-body text-center">
                                <h6 class="text-truncate">{{ $product->title }}</h6>
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="price">₱ {{ number_format($product->price - $product->discount, 2) }}</span>
                                    @if($product->discount > 0)
                                        <span class="old-price">₱ {{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="star-rating">
                                    @php
                                        $rating = $product->reviews->avg('rating') ?? 0;
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
                                    ({{ $product->reviews->count() }})
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4 w-100" data-aos="fade-up">
                <button id="load-more" class="btn btn-outline-dark w-50">Load More</button>
            </div>
        </section>
    
        <!-- Newsletter Signup -->
        <section data-aos="fade-up" class="newsletter-signup pt-5 text-center">
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