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