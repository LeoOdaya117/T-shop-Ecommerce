<!-- filepath: /resources/views/partials/product-cards.blade.php -->
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

