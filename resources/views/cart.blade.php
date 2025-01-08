@extends("layouts.default")
@section("title", "T-Shop - Cart")
@section("style")
    <style>
        @media (max-width: 768px) {
    .cart-item img {
        max-height: 100px; /* Reduce image size further for smaller screens */
    }

    .cart-item .text-truncate {
        font-size: 0.85rem; /* Smaller text for titles */
    }

    .cart-item .quantity {
        width: 45px; /* Shrink input box */
        font-size: 0.75rem; /* Smaller font for input */
    }

    .cart-item .item-total-price {
        font-size: 0.8rem; /* Smaller text for total price */
    }

    .cart-item i.remove-item {
        font-size: 0.9rem; /* Smaller icon size */
    }
    .container {
        height: 100vh;
    }
}

    </style>
@endsection()
@section("content")
<main class="container">
    <section class="pt-5">

        <h2 class="text-center mb-2 mt-3">Your Cart[{{ Session::get('cartTotal', 0) }}]</h2>

        @if (session()->has("success"))
            <div class="alert alert-success">
                {{session()->get("success")}}
            </div>
        
        @endif
        @if (session("error"))
            <div class="alert alert-danger">
                {{session("error")}}
            </div>
        
        @endif

        <div class="row">

            @if ( Session::get('cartTotal')  < 1)
                <div class="p-4">
                    Your cart is empty, see <span><a href="{{ route('home') }}">products</a></span>.
                </div>
            @else

                <div class="row align-items-center mt-2">
                    <div class="col-6 col-md-4 d-flex justify-content-center">
                        <h5>Item</h5>
                    </div>

                    <div class="col-4 col-md-1 text-center text-md-start">
                        <h5>Quantity</h5>
                    </div>

                    <div class="col-2 col-md-2 d-flex justify-content-center">
                        <h5>Total</h5>
                    </div>


                </div>
                <hr style="border-top: 2px solid #000000; max-width: 65%;">
                

                <div class="row">
                    <!-- Cart Items List -->
                    <div class="col-12 col-md-8" id="cart-items">
                        @php $totalPrice = 0; @endphp  <!-- Initialize totalPrice variable -->
                        @foreach ($cartItems as $key => $items)
                            <div class="col-12  cart-item" data-id="{{ $items->product_id }}">
                                <div class=" ">
                                    <div class="row align-items-center g-0">
                                        <!-- Product Image -->
                                        <div class="col-3 col-md-2 d-flex justify-content-center" onclick="clickProduct('{{ route('showDetails', $items->slug) }}')">
                                            <img src="{{ $items->image }}" class="card-img-top" alt="Product Image" style="max-width: 100%; height: auto;">
                                        </div>
        
                                        <!-- Product Details -->
                                        <div class="col-3 col-md-3 text-center text-md-start">
                                            <div class="card-body">
                                                <strong class="card-title">{{ $items->title }}</strong>
                                                <span class="d-block mb-2">₱ {{ $items->price }}</span>
                                            </div>
                                        </div>
        
                                        <!-- Quantity Selector -->
                                        <div class="col-3 col-md-3 d-flex justify-content-center">
                                            <input type="number" class="form-control quantity" value="{{ $items->quantity }}" min="1" style="width: 75px;" data-price="{{ $items->price }}" data-id="{{ $items->product_id }}">
                                        </div>
        
                                        <!-- Total Price per Item -->
                                        <div class="col-2 col-md-2 d-flex justify-content-center align-items-center">
                                            <strong class=" item-total-price">₱ {{ $items->price * $items->quantity }}</strong>
                                        </div>
        
                                        <!-- Remove Button -->
                                        <div class="col-1 col-md-1 d-flex justify-content-center align-items-center">
                                            <i class="remove-item fa-solid fa-minus fa-lg" style="color: red;"></i>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid #313131;">
                                @php $totalPrice += $items->price * $items->quantity; @endphp  <!-- Add to totalPrice -->
                            </div>
                            
                        @endforeach
                    </div>
        
                    <!-- Total Price -->
                    <div class="col-12 col-md-4 justify-content-end mb-3">
                        <div class="card p-3">
                            <h5 class="text-end">Total: ₱ <span id="total-price">{{ $totalPrice }}</span></h5> <!-- Display Total -->
                            <a href="{{ route('checkout.show') }}" class="btn btn-warning w-100">Checkout</a>
                        </div>
                    </div>
                </div>
            @endif

        </div>



    </section>
</main>
@endsection


@section("script")
<script>
    // Update the total price dynamically when quantity is changed
    document.addEventListener("DOMContentLoaded", function() {
        const quantityInputs = document.querySelectorAll('.quantity');
        quantityInputs.forEach(input => {
            input.addEventListener('input', function() {
                const quantity = parseInt(this.value);
                const price = parseFloat(this.getAttribute('data-price'));
                const itemTotal = quantity * price;
                const itemTotalElement = this.closest('.cart-item').querySelector('.item-total-price');
                const totalPriceElement = document.getElementById('total-price');

                // Update item total
                itemTotalElement.textContent = `₱ ${itemTotal.toFixed(2)}`;

                // Recalculate the total price of the cart
                let totalPrice = 0;
                document.querySelectorAll('.item-total-price').forEach(item => {
                    totalPrice += parseFloat(item.textContent.replace('₱', '').trim());
                });

                // Update the total price of the cart
                totalPriceElement.textContent = totalPrice.toFixed(2);
            });
        });

        // Optional: Remove item from cart (you can handle backend logic here)
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartItem = this.closest('.cart-item');
                cartItem.remove();

                // Recalculate total price after removing an item
                let totalPrice = 0;
                document.querySelectorAll('.item-total-price').forEach(item => {
                    totalPrice += parseFloat(item.textContent.replace('₱', '').trim());
                });

                // Update the total price of the cart
                document.getElementById('total-price').textContent = totalPrice.toFixed(2);
            });
        });
    });

    function clickProduct(routeUrl) {
            window.location.href = routeUrl;
        }
</script>
@endsection
