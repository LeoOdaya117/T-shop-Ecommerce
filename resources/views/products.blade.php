@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <style>

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
    <main class="container w-100 mb-3">
        
        
        <div class="container">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    @if(isset($categories) && $categories->isNotEmpty())
                        <li class="breadcrumb-item" onclick="route('{{ route('shop') }}')">Products</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $categories->first()->name }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page" onclick="route('{{ route('shop') }}')">Products</li>
                    @endif
                </ol>
            </nav>
            
        </div>
        <hr style="border: 0px solid #e4e1e1; margin: 0 auto;">

        <div class="align-items-center d-flex justify-content-end text-center m-2">
            <p class="text-center  mb-0 me-2" style="font-size: 12px">Sort by: </p>
            <select name="sort" id="sort" class="form-select align-items-end " style="width: 150px; border-radius:10px" onchange="route('{{ route('shop') }}?sort=' + this.value)">
                <option value="default">Best Match</option>
                <option value="price">Price low to high</option>
                <option value="name">Price high to low</option>
            </select>
        </div>
        <hr style="border: 0px solid #e4e1e1; margin: 0 auto;">

        <section >
            
            <div  data-aos="fade-up" class="row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4 "> <!-- Flexbox for equal height -->
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
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto">View product</a></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                @endif

                
                
            </div>

            <div class="">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </main>
@endsection()

@section("script")
    <script>
        function route(routeUrl) {
            window.location.href = routeUrl;
        }
    </script>
@endsection()
