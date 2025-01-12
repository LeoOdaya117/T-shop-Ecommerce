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

        <h2 class="text-center mb-3 mt-3">Your Cart[{{ Session::get('cartTotal', 0) }}]</h2>

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

                <div class="table-header row align-items-center mt-2">
                   <div class="row">
                        <div class="col-6 col-md-3 d-flex justify-content-center">
                            <h5>Item</h5>
                        </div>

                        <div class="col-3 col-md-2 text-center text-md-start">
                            <h5>Quantity</h5>
                        </div>

                        <div class="col-3 col-md-1  d-flex justify-content-center">
                            <h5>Total</h5>
                        </div>
                        <hr style="border-top: 2px solid #000000; max-width: auto;">
                    </div>

                </div>
                
                

                <div class="cart-content row" style="max-height: 550px; overflow-y: auto;">
                    <!-- Cart Items List -->
                    <div class="col-12 col-md-8" id="cart-items" >
                        @php 
                            $totalPrice = 0; 
                            $shippingFee = 75;
                        @endphp  <!-- Initialize totalPrice variable -->
                        @foreach ($cartItems as $key => $items)
                            <div class="col-12  cart-item" data-id="{{ $items->id }}">
                                <div class=" ">
                                    <div class="row align-items-center g-0">
                                        <!-- Product Image -->
                                        <!-- filepath: /c:/Users/Leo/Desktop/Laragon/Laragon/www/Ecommerce-app/resources/views/cart.blade.php -->
                                        <div class="col-5 d-flex flex-column flex-md-row align-items-center">
                                            <!-- Product Image -->
                                            <div class="order-1 order-md-1 d-flex justify-content-center align-items-center" onclick="clickProduct('{{ route('showDetails', $items->slug) }}')" STYLE="cursor: pointer;">
                                                <img src="{{ $items->image }}" class="img-fluid" alt="Product Image" style="max-width: 100px; height: auto;">
                                            </div>
                                            <!-- Product Details -->
                                            <div class="card-body order-2 order-md-2 text-center">
                                                <strong class="card-title">{{ $items->title }}</strong>
                                                <span class="d-block">₱ {{ $items->price }}</span>
                                            </div>
                                        </div>
        
                                        <!-- Quantity Selector -->
                                        <div class="col-4 col-md-2 d-flex justify-content-center">
                                            <input type="number" class="form-control quantity text-center" value="{{ $items->quantity }}" min="1" style="width: 75px;" data-price="{{ $items->price }}" data-id="{{ $items->product_id }}">
                                        </div>
        
                                        <!-- Total Price per Item -->
                                        <div class="col-2 col-md-3 d-flex justify-content-center align-items-center">
                                            <strong class=" item-total-price">₱ {{ $items->price * $items->quantity }}</strong>
                                        </div>
        
                                        <!-- Remove Button -->
                                        <div class="col-1 col-md-1 d-flex justify-content-center align-items-center " style="color: red; cursor: pointer;">
                                            {{-- <i class="remove-item fa-solid fa-minus fa-lg" style="color: red;"></i> --}}
                                            <i class=" remove-item fa-solid fa-x"></i>
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid #313131;">
                                @php $totalPrice += $items->price * $items->quantity; @endphp  <!-- Add to totalPrice -->
                            </div>
                            
                        @endforeach
                    </div>
        
                    <!-- Total Price -->
                    <div class="col-12 col-md-4 justify-content-end mb-5">
                        <div class="card p-3">
                            <h5 class="text-center"> Summary</h5>
                            <hr>
                            <div class="row">
                                <h6 class="col-6 text-start">
                                    Subtotal:
                                </h6>
                                <h6 class="text-end col-6  ">
                                    ₱ <span id="subtotal-price">{{ $totalPrice }}</span>
                                </h6>
                            </div>
                            <div class="row">
                                <h6 class="col-6 text-start">
                                    Discount:
                                </h6>
                                <h6 class="text-end col-6  ">
                                    ₱ <span id="discount-price">{{ 0 }}</span>
                                </h6>
                            </div>
                            <div class="row">
                                <h6 class="col-6 text-start">
                                    Tax:
                                </h6>
                                <h6 class="text-end col-6  ">
                                    ₱ <span id="tax-price">0</span>
                                </h6>
                            </div>
                            <div class="row">
                                <h6 class="col-6 text-start">
                                    Shipping:
                                </h6>
                                <h6 class="text-end col-6  ">
                                    ₱ <span id="shipping-price">{{ $shippingFee }}</span>
                                </h6>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <h5 class="col-6 text-start">
                                    Total:
                                </h5>
                                <h5 class="text-end col-6  ">
                                    ₱ <span id="total-price">{{ $totalPrice + $shippingFee }}</span>
                                </h5>
                            </div>
                            <a href="{{ route('checkout.show') }}" class="btn btn-warning w-100">Checkout</a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2 text-dark">Continue Shopping</a>
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
                const cartItem = this.closest('.cart-item');
                const itemId = cartItem.getAttribute('data-id');
                const quantity = parseInt(this.value);
                const price = parseFloat(this.getAttribute('data-price'));
                const itemTotal = quantity * price;
                const itemTotalElement = this.closest('.cart-item').querySelector('.item-total-price');
                const subtotalPriceElement = document.getElementById('subtotal-price');
                const totalPriceElement = document.getElementById('total-price');
                const shippingFee = parseFloat(document.getElementById('shipping-price').textContent.replace('₱', '').trim());

                // Update item total
                itemTotalElement.textContent = `₱ ${itemTotal.toFixed(2)}`;

                // Recalculate the subtotal price of the cart
                let subtotalPrice = 0;
                document.querySelectorAll('.item-total-price').forEach(item => {
                    subtotalPrice += parseFloat(item.textContent.replace('₱', '').trim());
                });

                // Update the subtotal price of the cart
                subtotalPriceElement.textContent = `${subtotalPrice.toFixed(2)}`;

                // Calculate the total price (subtotal + shipping)
                const totalPrice = subtotalPrice + shippingFee;

                // Update the total price of the cart
                totalPriceElement.textContent = `${totalPrice.toFixed(2)}`;

                // Send AJAX request to update the quantity on the server
                $.ajax({
                    url: '{{ route("add.quantity", [":id", ":quantity"]) }}'
                        .replace(':id', itemId)
                        .replace(':quantity', quantity),
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            console.log(response.success);
                        } else {
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });

        // Optional: Remove item from cart (you can handle backend logic here)
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const cartItem = this.closest('.cart-item');
                const itemId = cartItem.getAttribute('data-id');

                // Remove the cart item from the DOM
                cartItem.remove();
                updateCartItemNumber();
                // Recalculate subtotal and total price after removing an item
                let subtotalPrice = 0;
                document.querySelectorAll('.item-total-price').forEach(item => {
                    subtotalPrice += parseFloat(item.textContent.replace('₱', '').trim());
                });

                // Update the subtotal price of the cart
                document.getElementById('subtotal-price').textContent = `${subtotalPrice.toFixed(2)}`;

                // Calculate the total price (subtotal + shipping)
                const shippingFee = parseFloat(document.getElementById('shipping-price').textContent.replace('₱', '').trim());
                const totalPrice = subtotalPrice + shippingFee;

                // Update the total price of the cart
                document.getElementById('total-price').textContent = `${totalPrice.toFixed(2)}`;

                // Send AJAX request to remove the item from the server
                $.ajax({
                    url: '{{ route("cart.remove", ":id") }}'.replace(':id', itemId),
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            console.log(response.success);
                        } else {
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
                 updateCartItemNumber();
            });
        });
    });

    function clickProduct(routeUrl) {
        window.location.href = routeUrl;
    }
</script>
@endsection
