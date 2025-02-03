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
    .main {
        height: 100vh;
    }
}

    </style>
@endsection()
@section("content")
    <div class="bg-dark text-light">
        <div class=" container ">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
            
        </div>
    </div>
<main class="container main">
    <section class="">

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
 
                <div
                    class="row g-2">
                    <div class="col">
                        <table class="table table-hover table-responsive">
                            <tr class="text-center">
                                <th >Item</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            @php 
                                $totalPrice = 0; 
                                $shippingFee = 75;      
                             @endphp  <!-- Initialize totalPrice variable -->
                            @foreach ($cartItems as $key => $items)
                                <tr class="align-items-center justify-content-center text-center align-middle cart-item" data-id="{{ $items->id }}"> 
                                    <td>
                                        <div class="d-flex flex-column gap-0 flex-md-row align-items-center">
                                            <!-- Product Image -->
                                            <div class="order-1 order-md-1 d-flex justify-content-center align-items-center" onclick="clickProduct('{{ route('showDetails', $items->product->slug) }}')" STYLE="cursor: pointer;">
                                                <img src="{{ $items->product->image }}" class="img-fluid" alt="Product Image" style="max-width: 100px; height: auto;">
                                            </div>
                                            <!-- Product Details -->
                                            <div class="card-body order-2 order-md-2 text-center">
                                                <strong class="card-title">{{ $items->product->title }}</strong>
                                                <p class="text-muted">{{ $items->variant->color }} {{ $items->variant->size }}</p>
                                                <span class="d-block">₱ {{ number_format($items->product->price - $items->product->discount,2) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" align-middle">
                                        <div class=" d-flex justify-content-center align-items-center">
                                            <input type="number" class="form-control quantity text-center" value="{{ $items->quantity }}" min="1" style="width: 75px;" data-price="{{ $items->product->price }}" data-discount="{{ $items->product->discount }}" data-id="{{ $items->product_id }}">

                                        </div>
                                    </td>
                                    <td>
                                        <strong class=" item-total-price">₱ {{ number_format(($items->product->price - $items->product->discount ) * $items->quantity,2) }}</strong>
                                    </td>
                                    <td>
                                        <!-- Remove Button -->
                                        <div class="col-1 col-md-1" style="color: red; cursor: pointer;">
                                            {{-- <i class="remove-item fa-solid fa-minus fa-lg" style="color: red;"></i> --}}
                                            <i class="remove-item fa-solid fa-x"></i>
                                        </div>
                                     </td>
                                     @php $totalPrice += ($items->product->price - $items->product->discount ) * $items->quantity; @endphp  
                                    </tr>
                            @endforeach
                        </table>
                    </div>

                    {{-- SUMMARY --}}
                    <div class="col-12 col-md-4">
                         <!-- Total Price -->
                         <div class="card p-3">
                            <h5 class="text-center"> Summary</h5>
                            <hr>
                            <div class="row">
                                <h6 class="col-6 text-start">
                                    Subtotal:
                                </h6>
                                <h6 class="text-end col-6  ">
                                    ₱ <span id="subtotal-price">{{ number_format($totalPrice,2) }}</span>
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
                                    ₱ <span id="shipping-price">{{ number_format($shippingFee) }}</span>
                                </h6>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <h5 class="col-6 text-start">
                                    Total:
                                </h5>
                                <h5 class="text-end col-6  ">
                                    ₱ <span id="total-price">{{ number_format($totalPrice + $shippingFee,2) }}</span>
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
    window.routeUrls = {
        removeToCart: "{{ route('cart.remove', ':id') }}",
        updateQuantity: "{{ route('add.quantity', [':id', ':quantity']) }}"
    };
</script>

<script src="{{ asset('assets/js/cart.js') }}"></script>
@endsection
