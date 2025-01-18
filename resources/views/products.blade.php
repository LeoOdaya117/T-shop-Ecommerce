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

    <div class="bg-dark text-light">
        <div class=" container ">
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
    </div>

    <main class="container w-100 mb-3">
        
        
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-12">
                
                <div class="align-items-center d-flex justify-content-end text-center m-2">
                   
                    <p class="text-center  mb-0 me-2" style="font-size: 12px">Sort by: </p>
                    <select name="sort" id="sort" class="form-select align-items-end " style="width: 150px; border-radius:10px" onchange="route('{{ route('shop') }}?sort=' + this.value)">
                        <option value="default">Best Match</option>
                        <option value="price">Price low to high</option>
                        <option value="name">Price high to low</option>
                    </select>
                </div>
                <hr style="border: 0px solid #e4e1e1; margin: 0 auto;">
            </div>
            <div class="col">
                
            </div>
          
        </div>

        <div class="row  g-3 ">
            <div class="container col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 bg-white">
                <div class="container text-center mt-3 mb-3">
                    <h5>Filter Products</h5>
                </div>
                <hr>
                <!-- Category Filter with Checkboxes -->
                <div class="container mt-3 mb-3">
                    <h5>Category</h5>
                    @foreach ($categories as $category)
                        <div class="form-check">

                                <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="{{ $category->id }}">
                                <label class="form-check-label" for="{{ $category->name }}">
                                    {{ $category->name }}
                                </label>
                            
                            
                        </div>
                    @endforeach
                </div>
                <hr>
                <!-- Brand Filter with Checkboxes -->
                <div class="container mt-3 mb-3">
                    <h5>Brand</h5>
                    @foreach ($brands as $brand)
                        <div class="form-check">

                                <input class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="{{ $brand->id }}">
                                <label class="form-check-label" for="{{ $brand->name }}">
                                    {{ $brand->name }}
                                </label>
                            
                            
                        </div>
                    @endforeach
                </div>
                <hr>
                <!-- Size Filter with Checkboxes -->
                <div class="container mt-3 mb-3">
                    <h5>Size</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="small" id="sizeSmall">
                        <label class="form-check-label" for="sizeSmall">
                            Small (S)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="medium" id="sizeMedium">
                        <label class="form-check-label" for="sizeMedium">
                            Medium (M)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="large" id="sizeLarge">
                        <label class="form-check-label" for="sizeLarge">
                            Large (L)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="xlarge" id="sizeXLarge">
                        <label class="form-check-label" for="sizeXLarge">
                            Extra Large (XL)
                        </label>
                    </div>
                </div>
                <hr>
                <!-- Price Filter with Price Range Checkboxes -->
                <div class="container mt-3 mb-3">
                    <h5>Filter by Price</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0-50" id="price0to50">
                        <label class="form-check-label" for="price0to50">
                            $0 - $50
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="51-100" id="price51to100">
                        <label class="form-check-label" for="price51to100">
                            $51 - $100
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="101-200" id="price101to200">
                        <label class="form-check-label" for="price101to200">
                            $101 - $200
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="201-500" id="price201to500">
                        <label class="form-check-label" for="price201to500">
                            $201 - $500
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="500" id="priceAbove500">
                        <label class="form-check-label" for="priceAbove500">
                            $500+
                        </label>
                    </div>
                </div>
            </div>
            
            
            
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
               
            
                    <div  data-aos="fade-up" class="row gx-4 gx-lg-5 p-2 row-cols-2 row-cols-md-3 row-cols-xl-4 "> <!-- Flexbox for equal height -->

                        @if ($products->isEmpty())
                            <div class="col-12 col-md-6 col-lg-2 mb-4 w-100">
                                <div class="alert  text-center a align-content-center">
                                    No products found.
                                </div>
                            </div>
                            
                        @else
                            @foreach ($products as $product)
                            <div class="col-12 col-md-6 col-lg-2 mb-4">
                                <div class="card position-relative">
                                    <!-- Label Indicator -->
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
                                                ₱ {{ $product->price - $product->discount}}
                                                @if($product->discount > 0.00)
                                                    <div class="text-muted text-decoration-line-through align-content-center" style="font-size: 12px">₱ {{ $product->price }}</div>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Actions -->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                        <div class="text-center">
                                            <a class="btn btn-outline-dark mt-auto w-100">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        
                        
                            
                        @endif
        
                        
                        
                    </div>
                    <div class="">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                    
                
            </div>
           
        </div>
        
        

       

       
    </main>
@endsection()

@section("script")
    <script>
        function route(routeUrl) {
            window.location.href = routeUrl;
        }
        
    </script>
@endsection()
