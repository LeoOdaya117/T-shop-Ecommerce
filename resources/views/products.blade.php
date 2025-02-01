@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .breadcrumb-item {
            cursor: pointer;
            transition: color 0.3s;
        }

        .breadcrumb-item:hover {
            color: #007bff;
        }

        .filter-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: max-height 0.3s ease;
            margin-top: 20px;
        }

        .filter-container h5 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .filter-container .form-check {
            margin-bottom: 15px;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-input {
            border-radius: 50%;
            transition: all 0.3s;
        }

        .form-check-label {
            font-size: 1rem;
            color: #333;
            padding-left: 10px;
            cursor: pointer;
        }

        .filter-toggle-btn {
            display: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .filter-toggle-btn:hover {
            background-color: #0056b3;
        }

        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border-radius: 10px;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            object-fit: cover;
            height: 250px;
            border-radius: 10px;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #000000;
        }

        .old-price {
            font-size: 1rem;
            text-decoration: line-through;
            color: #999;
            margin-left: 10px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 50px;
        }

        .badge.bg-primary {
            background-color: #007bff;
        }

        .badge.bg-danger {
            background-color: #e74c3c;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .star-rating i {
            margin: 0 2px;
        }

        .filter-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .filter-container h5 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .accordion-button {
            font-weight: bold;
            background-color: #f8f9fa;
            color: #333;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .filter-toggle-btn {
            display: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .filter-toggle-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 767px) {
            .filter-container {
                display: none;
            }

            .filter-toggle-btn {
                display: inline-block;
            }

            .product-list .col-12 {
                width: 50%;
            }
        }

        @media (min-width: 768px) {
            .product-list .row-cols-md-2 {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }
        }

        @media (min-width: 1024px) {
            .product-list .row-cols-md-3 {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }
        }
    </style>
@endsection()

@section("content")
    <div class="bg-dark text-light">
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
    </div>

    <main class="container w-100 mb-3">
        <div class="row justify-content-center align-items-center g-2 mb-2">
            <div class="col-12">
                <div class="d-flex justify-content-end text-center m-2">
                    <form action="{{ route('search.product') }}" method="GET" class="d-flex align-items-end">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search products..." style="width: 200px; border-radius:10px">
                        <button type="submit" class="btn btn-outline-dark ms-2" style="border-radius:10px">Search</button>
                    </form>
                </div>
                <hr style="border: 0px solid #e4e1e1; margin: 0 auto;">
            </div>
        </div>

        <div class="row g-3">
              <!-- Filters Column -->
              <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 filter-container">
                <h5>Filters</h5>
                <div class="accordion" id="filterAccordion">
                    <!-- Category Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategory">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                                Category
                            </button>
                        </h2>
                        <div id="collapseCategory" class="accordion-collapse collapse show" aria-labelledby="headingCategory" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input filter" type="checkbox" value="{{ $category->id }}" id="category_{{ $category->id }}" name="category[]">
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Brand Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingBrand">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand" aria-expanded="false" aria-controls="collapseBrand">
                                Brand
                            </button>
                        </h2>
                        <div id="collapseBrand" class="accordion-collapse collapse" aria-labelledby="headingBrand" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                @foreach ($brands as $brand)
                                    <div class="form-check">
                                        <input class="form-check-input filter" type="checkbox" value="{{ $brand->id }}" id="brand_{{ $brand->id }}" name="brand[]">
                                        <label class="form-check-label" for="brand_{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
            
                    <!-- Size Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSize">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSize" aria-expanded="false" aria-controls="collapseSize">
                                Size
                            </button>
                        </h2>
                        <div id="collapseSize" class="accordion-collapse collapse" aria-labelledby="headingSize" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Small" id="size_Small" name="size[]">
                                    <label class="form-check-label" for="size_small">Small</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Medium" id="size_Medium" name="size[]">
                                    <label class="form-check-label" for="size_medium">Medium</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Large" id="size_Large" name="size[]">
                                    <label class="form-check-label" for="size_small">Large</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="XL" id="size_XL" name="size[]">
                                    <label class="form-check-label" for="size_small">XL</label>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Price Range Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPrice">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                                Price Range
                            </button>
                        </h2>
                        <div id="collapsePrice" class="accordion-collapse collapse" aria-labelledby="headingPrice" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="0-50" id="price_range_1" name="price_range[]">
                                    <label class="form-check-label" for="price_range_1">$0 - $50</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="51-100" id="price_range_2" name="price_range[]">
                                    <label class="form-check-label" for="price_range_2">$51 - $100</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="apply-filters-btn" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
            

            

            <!-- Product List Column -->
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                <button class="filter-toggle-btn" onclick="toggleFilters()">Filter</button>

                <div class="row g-3 product-list" id="product-list">
                    @if ($products->isEmpty())
                        <div class="col-12 col-md-6 col-lg-2 mb-4 w-100">
                            <div class="alert text-center">No products found.</div>
                        </div>
                    @else
                        @foreach ($products as $product)
                            <div class="col-12 col-md-6 col-lg-3 mb-2" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                <div class="product-card card">
                                    <div class="position-relative">
                                        @if(\Carbon\Carbon::parse($product->created_at)->isToday())
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
                    @endif
                </div>
                <div>
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

    function toggleFilters() {
        const filterContainer = document.querySelector('.filter-container');
        filterContainer.style.display = filterContainer.style.display === 'block' ? 'none' : 'block';
    }

    // Function to gather selected filters and reload the page with updated query parameters
    function applyFilters() {
        let categories = document.querySelectorAll('input[name="category[]"]:checked');
        let brands = document.querySelectorAll('input[name="brand[]"]:checked');
        let sizes = document.querySelectorAll('input[name="size[]"]:checked');
        let priceRange = document.querySelectorAll('input[name="price_range[]"]:checked');
        let search = 

        let queryString = '';

            // Prepare query parameters for category filter
     if (categories.length > 0) {
         categories.forEach(category => {
             queryString += `category[]=${category.value}&`;
         });
     }

     // Prepare query parameters for brand filter
     if (brands.length > 0) {
         brands.forEach(brand => {
             queryString += `brand[]=${brand.value}&`;
         });
     }

     // Prepare query parameters for size filter
     if (sizes.length > 0) {
         sizes.forEach(size => {
             queryString += `size[]=${size.value}&`;
         });
     }

     // Prepare query parameters for price range filter
     if (priceRange.length > 0) {
         priceRange.forEach(price => {
             queryString += `price_range[]=${price.value}&`;
         });
     }

        // Remove trailing '&' if exists
        queryString = queryString.endsWith('&') ? queryString.slice(0, -1) : queryString;

        // Reload the page with the updated query string
        window.location.href = '{{ route('shop') }}?' + queryString;
    }

    // Listen for the apply filter button click
    document.getElementById('apply-filters-btn').addEventListener('click', applyFilters);

    // Function to pre-select filters based on the URL query parameters
    function setSelectedFilters() {
        // Get the current URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // For search term
        const searchTerm = urlParams.get('search');
        if (searchTerm) {
            document.getElementById('search').value = searchTerm;
        }

        // For category filter
        const selectedCategories = urlParams.getAll('category[]');
        selectedCategories.forEach(categoryId => {
            document.querySelectorAll(`input[name="category[]"][value="${categoryId}"]`).forEach(input => {
                input.checked = true;
            });
        });

        // For brand filter
        const selectedBrands = urlParams.getAll('brand[]');
        selectedBrands.forEach(brandId => {
            document.querySelectorAll(`input[name="brand[]"][value="${brandId}"]`).forEach(input => {
                input.checked = true;
            });
        });

        // For size filter (if any)
        const selectedSizes = urlParams.getAll('size[]');
        selectedSizes.forEach(sizeId => {
            document.querySelectorAll(`input[name="size[]"][value="${sizeId}"]`).forEach(input => {
                input.checked = true;
            });
        });

        // For price range filter (if any)
        const selectedPriceRanges = urlParams.getAll('price_range[]');
        selectedPriceRanges.forEach(priceRange => {
            document.querySelectorAll(`input[name="price_range[]"][value="${priceRange}"]`).forEach(input => {
                input.checked = true;
            });
        });
    }


    window.onload = setSelectedFilters;



</script>

@endsection()
