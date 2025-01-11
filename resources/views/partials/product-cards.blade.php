<!-- filepath: /resources/views/partials/product-cards.blade.php -->
@foreach ($products as $product)
<div class="col">
    <div class="card m-1">
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