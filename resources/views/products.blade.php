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
            <div class="row pt-4 d-flex align-items-stretch"> <!-- Flexbox for equal height -->
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <div class="card  shadow-sm h-100" onclick="clickProduct('{{ route('showDetails', $product->slug) }}')">
                            <img src="{{ $product->image }}" alt="Product Image" class="card-img-top">
                            <div class="card-body">
                                <p>{{ $product->title }}</p>
                                <p><strong>₱ {{ $product->price }}</strong></p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
