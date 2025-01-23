<!-- filepath: /resources/views/partials/product-cards.blade.php -->
@foreach ($products as $product)
    <div class="col-12 col-md-6 col-lg-2 mb-4">
        <div class="card position-relative" data-aos="fade-up">
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

