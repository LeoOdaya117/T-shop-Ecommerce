@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
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
            <div class="col-1">
                <div class="m-2"  >
                    <button class="mt-3 filter-toggle-btn"  onclick="toggleFilters()">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
                

            </div>
            <div class="col-11">
                <div class="d-flex justify-content-end text-center m-2">
                    <form id="search-form" action="{{ route('shop') }}" method="GET" class="d-flex align-items-end">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search products..." style="width: 200px; border-radius:10px">
                        <button type="submit" class="btn btn-outline-dark ms-2" style="border-radius:10px">Search</button>
                    </form>
                </div>
               
            </div>
            <hr style="border: 0px solid #e4e1e1; margin: 0 auto;">
        </div>

        <div class="row g-3">
            <!-- Filters Column -->
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 filter-container p-3 border rounded">
                <h5 class="mb-3">Filters</h5>
                <div class="accordion" id="filterAccordion">
                    <!-- Category Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCategory">
                            <button class="accordion-button" type="button" data-target="#collapseCategory">
                                Category
                            </button>
                        </h2>
                        <div id="collapseCategory" class="accordion-collapse collapse">
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
                            <button class="accordion-button" type="button" data-target="#collapseBrand">
                                Brand
                            </button>
                        </h2>
                        <div id="collapseBrand" class="accordion-collapse collapse">
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
                            <button class="accordion-button" type="button" data-target="#collapseSize">
                                Size
                            </button>
                        </h2>
                        <div id="collapseSize" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Small" id="size_Small" name="size[]">
                                    <label class="form-check-label" for="size_Small">Small</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Medium" id="size_Medium" name="size[]">
                                    <label class="form-check-label" for="size_Medium">Medium</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="Large" id="size_Large" name="size[]">
                                    <label class="form-check-label" for="size_Large">Large</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter" type="checkbox" value="XL" id="size_XL" name="size[]">
                                    <label class="form-check-label" for="size_XL">XL</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPrice">
                            <button class="accordion-button" type="button" data-target="#collapsePrice">
                                Price Range
                            </button>
                        </h2>
                        <div id="collapsePrice" class="accordion-collapse collapse">
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
                </div>

                <!-- Buttons Section -->
                <div class="d-flex justify-content-between mt-3">
                    <button id="apply-filters-btn" class="btn btn-primary w-48">Apply Filters</button>
                    <button id="reset-filters-btn" class="btn btn-outline-secondary w-48">Reset</button>
                </div>
            </div>

            <!-- Product List Column -->
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                {{-- <button class="filter-toggle-btn" onclick="toggleFilters()">Filter</button> --}}

                <div class="row g-3 product-list" id="product-list">
                    @if ($products->isEmpty())
                        <div data-aos="fade-up" class="col-12 col-md-6 col-lg-2 mb-4 w-100">
                            <div class="alert text-center">No products found.</div>
                        </div>
                    @else
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
                    @endif
                </div>
                <div>
                    {{  $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/products-filter.js') }}"></script>

    <!-- Add Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionButtons = document.querySelectorAll('.accordion-button');

            accordionButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetCollapse = document.querySelector(targetId);

                    if (targetCollapse.classList.contains('show')) {
                        targetCollapse.classList.remove('show');
                    } else {
                        targetCollapse.classList.add('show');
                    }
                });
            });
        });
    </script>
@endsection
