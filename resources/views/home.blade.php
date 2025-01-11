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
        <section class="hero-section pt-5 mb-3 text-center align-content-center w-100" style="background-image: url('https://i.pinimg.com/736x/6a/2e/a0/6a2ea0edd5e1a2256652b2e48f22615c.jpg'); background-size: cover; background-position: center; height: 400px; color: white;">
            <div class="hero-content h-100 align-content-center" style="background: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
                <h1 class="display-4">Welcome to T-Shop</h1>
                <p class="lead">Discover the best t-shirts for every occasion</p>
                <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products mb-3" data-aos="fade-up">
            <h4 class="text-start mb-4 font-weight-lighter">Featured Products</h4>
            <div class="row gx-3 gx-lg-5 p-0 row-cols-2 row-cols-md-4 row-cols-xl-4 ">
                @foreach ($popularProducts as $featuredProduct)
                
                    <div class="col" >
                        <div class="card m-1" >
                            <!-- Product image-->
                            <img class="card-img-top mt-3" src="{{ $featuredProduct->image }}" alt="{{ $featuredProduct->title }}" >
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $featuredProduct->title }}</h5>
                                    <!-- Product price-->
                                    ₱ {{ $featuredProduct->price }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $featuredProduct->slug) }}')">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto">View product</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        
  


        <section class=" card-products mb-3" >
            <h4 class="text-start mb-4 font-weight-lighter">Categories</h4>
                <div class="row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($categories as $category)
                        <div class="col-12 col-md-12 p-1 align-items-center" style="height: auto; width:150px;" >
                            <div class="card p-3 align-items-center" onclick="route('{{ route('search.category.product', $category->id) }}')">
                                <img src="{{ $category->image ?? asset('assets/image/no-image.jpg') }}" class="image-fluid m-" alt="{{ $category->name }}" style="height: 100px; width:100px; object-fit: cover;">
                                <p class="card-title text-center">{{ $category->name }}</p>
                            </div>
                        </div>


                    
                    @endforeach
                </div>
        </section>





        <section class=" justforyou-products mb-3">
            <h4 class="text-start mb-4 font-weight-lighter">Just For You</h4>

            <div id="product-container" class="row gx-4 gx-lg-5  row-cols-2 row-cols-md-3 row-cols-xl-4 "> <!-- Flexbox for equal height -->
                @foreach ($products as $product)
                <div class="col" >
                    <div class="card m-1" >
                        <!-- Product image-->
                        <img class="card-img-top mt-3" src="{{ $product->image }}" alt="Product Image" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{ $product->title }}</h5>
                                <!-- Product price-->
                                ₱ {{ $product->price }}
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $product->slug) }}')">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto">View product</a></div>
                        </div>
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