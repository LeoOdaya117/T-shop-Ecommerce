@extends("layouts.default")
@section("title", "T-Shop - Home")

@section("style")
    <style>
        .btn:hover{
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for a 3D effect */
            background-color: #f8f9fa; /* Optional: Change background color */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }
        img{
            object-fit: contain; /* Ensures the image fits within the specified height and width */
            max-height: 75%;
        }
    </style>
@endsection()

@section("content")
    <main class="container">

        <div class="container">
            ...
        </div>
        <section class="card mt-5">
            <div class="container-fluid">
                <div class="row  shawdow-sm">
                    <!-- Product Image -->
                    <div class="col-12 col-md-6 mb-3 mb-md-0 align-content-center align-items-center">
                        <img src="{{ $products->image }}" alt="Product Image" class="img-fluid align-content-center">
                    </div>
                    
                    <!-- Product Details -->
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start">
                        <div class="row mb-3">
                            <h3>{{ $products->title }}</h3>
                        </div>
                        <div class="row mb-3">
                            <p><strong>₱ {{ $products->price }}</strong></p>
                        </div>
                        <div class="row mb-3">
                            <p>{{ $products->descrption }}</p>
                        </div>
                        
                        <!-- Quantity Input -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                            </div>
                        </div>
    
                        <!-- Buttons -->
                        <div class="row w-100">
                            <div class="col-12 col-sm-6 mb-2 mb-sm-0">
                                <button class="btn bg-warning w-100">Buy now</button>
                            </div>
                            <div class="col-12 col-sm-6">
                                <button class="btn bg-success w-100" onclick="addToCart({{ $products->id }})">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        
        </section>
        <section class="mt-5">
            <h4 class="mb-4">Just For You</h4>
            <div class="row">
                @foreach ($products as $recommendedProduct)
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ $products->image }}" alt="Recommended Product Image" class="card-img-top img-fluid">
                            <div class="card-body">
                                <h5 class="card-title">{{ $products->title }}</h5>
                                <p class="card-text"><strong>₱ {{ $products->price }}</strong></p>
                                <a href="{{ route('showDetails', $products->slug) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection()

@section("script")
    <script>
        function addToCart(productId) {
            // Get the quantity selected by the user
            const quantity = document.getElementById('quantity').value;

            // Send AJAX request to add product to cart
            $.ajax({
                url: '/cart/' + productId + '/' + quantity,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.error,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Something went wrong',
                    //     toast: true,
                    //     position: 'top-end',
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     timerProgressBar: true,
                    //     didOpen: (toast) => {
                    //         toast.addEventListener('mouseenter', Swal.stopTimer);
                    //         toast.addEventListener('mouseleave', Swal.resumeTimer);
                    //     }
                    // });

                    window.location.href = '{{ route('login') }}';

                    console.log(error);
                }
            });


            
        }

     
    </script>
@endsection()
