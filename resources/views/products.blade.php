@extends("layouts.default")
@section("title", "T-Shop - Home")
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
            justify-content: space-between; /* Space out title, price, and other details */
        }
    </style>
@endsection()
@section("content")
    <main class="container w-100 mb-5">
        <section class="pt-5">
            <div class="pt-5 row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4 "> <!-- Flexbox for equal height -->
                {{-- @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <div class="card  shadow-sm h-100" onclick="clickProduct('{{ route('showDetails', $product->slug) }}')">
                            <img src="{{ $product->image }}" alt="Product Image" class="card-img-top">
                            <div class="card-body">
                                <p>{{ $product->title }}</p>
                                <p><strong>₱ {{ $product->price }}</strong></p>
                            </div>
                        </div>
                    </div>
                @endforeach --}}
                @if ($products->isEmpty())
                    <div class="col-12 col-md-6 col-lg-2 mb-4 w-100">
                        <div class="alert  text-center a align-content-center">
                            No products found.
                        </div>
                    </div>
                    
                @else
                    @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-2 mb-4">
                        <div class="card" >
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
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="clickProduct('{{ route('showDetails', $product->slug) }}')">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto">View product</a></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                @endif

                
                
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </section>
    </main>
@endsection()

@section("script")
    <script>
        function clickProduct(routeUrl) {
            window.location.href = routeUrl;
        }
    </script>
@endsection()
