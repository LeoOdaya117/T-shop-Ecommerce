@extends('layouts.my-account-layout')
@section('title', 'Order History')

@section('my-account')
<style>
   
    .submit_star {
      cursor: pointer;
      color: #bbb5;
    }
  </style>
    {{-- <div class="bg-dark text-light">
        <div class=" container ">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    <li class="breadcrumb-item" onclick="route('{{ route('order.history',['status'=> 'all']) }}')">Order History</li>
                    <li class="breadcrumb-item active" aria-current="page">Track Order</li>

                </ol>
            </nav>
            
        </div>
    </div> --}}
    <main class="container  mb-5" >
        <section class="">
            <div class="row d-flex align-items-center align-content-center justify-content-between mb-2 w-auto">
                <div class="col-12">
                    <h5>Orders</h5>

                    {{-- ACTIVE ORDERS --}}
                    <div class="container mt-3  w-100">
                        <h6 class="text-muted">Active Orders</h6>

                        {{-- ALERT MESSAGE CONTAINER --}}
                        <div id="alert-container"></div>

                        @forelse($active_orders as $order)
                            <div class="card shawdow-sm p-3 mb-2">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-9">
                                        <div class="product-images d-flex gap-2">
                                            @foreach($order->products as $product)
                                            <div>
                                                <img src="{{ $product->image }}" alt="Product Image" style="width: 100px; height: auto;" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="order-info d-flex gap-1">
                                            <div class="d-block shadow-sm p-1 border-dark">
                                                <p class="fw-bold m-0">Order number</p>
                                                <p class="m-0">{{ $order->id }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Order Date</p>
                                                <p class="m-0">{{ $order->created_at->format('M j, Y') }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Total</p>
                                                <p class="m-0">₱ {{ number_format($order->total_price,2) }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Status</p>
                                                <p class="m-0 
                                                    @if ($order->order_status == 'Delivered')
                                                        text-success
                                                    @elseif ($order->order_status == 'Shipped')
                                                        text-info
                                                    @elseif ($order->order_status == 'Processing')
                                                        text-warning
                                                    @elseif ($order->order_status == 'Out for Delivery')
                                                        text-primary
                                                    @else
                                                        
                                                    @endif
                                                " id="order_status">{{ $order->order_status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center" >
                                        <a href="{{ route('user.order.tracking', $order->id) }}" class="btn btn-light btn-outline-dark fw-bold">Track Order</a>
                                        @if ($order->order_status === "Processing" ||$order->order_status === "Order Placed" )
                                            <form id="cancelOrderForm" action="{{ route('admin.orders.orderStatus') }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="order_id" value="{{ $order->id }}" hidden>
                                                <input type="text" name="order_status" value="Cancelled" hidden>
                                                <button class="text-danger btn" type="submit">Cancel order</button>
                                            </form>
                                        @endif
                                    </div>
                                
                                </div>
                            
                                <!-- Hidden Order ID for Pusher -->
                                <span id="order_id" style="display:none;">{{ $order->id }}</span>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card" >
                                        
                                    <div class="card-body text-center">
                                        <p class="">No active orders.</p>
                                    
                                    </div>
                                </div>
                            </div>
                    
            
                        @endforelse

                      
                    </div>

                    {{-- Previous ORDERS --}}
                    <div class="container mt-3  w-100">
                        <h6 class="text-muted">Previous Orders</h6>
                        @forelse($past_orders as $order)
                            <div class="card shawdow-sm p-3 mb-2">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col-9">
                                        <div class="product-images d-flex gap-2">
                                            @foreach($order->products as $product)
                                            <div>
                                                <img src="{{ $product->image }}" alt="Product Image" style="width: 100px; height: auto;" onclick="route('{{ route('showDetails', $product->slug) }}')">
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="order-info d-flex gap-1">
                                            <div class="d-block shadow-sm p-1 border-dark">
                                                <p class="fw-bold m-0">Order number</p>
                                                <p class="m-0">{{ $order->id }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Order Date</p>
                                                <p class="m-0">{{ $order->created_at->format('M j, Y') }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Total</p>
                                                <p class="m-0">₱ {{ number_format($order->total_price,2) }}</p>
                                            </div>
                                            <div class="d-block shadow-sm p-1">
                                                <p class="fw-bold m-0">Status</p>
                                                <p class="m-0 
                                                    @if ($order->order_status == 'Delivered')
                                                        text-success
                                                
                                                    @else
                                                        text-danger
                                                    @endif
                                                " >{{ $order->order_status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <a href="{{ route('user.order.tracking', $order->id) }}" class="btn btn-light btn-outline-dark fw-bold">View Order</a>
                                        @if (!$order->is_reviewed && $order->order_status === "Delivered")
                                            <button type="button" class="btn text-info writeReviewBtn"  data-order="{{ $order }}">Write a review</button>

                                        @endif
                                    </div>
                                
                                </div>
                            
                                
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card" >
                                        
                                    <div class="card-body text-center">
                                        <p class="">No previous orders.</p>
                                    
                                    </div>
                                </div>
                            </div>
                    
            
                        @endforelse
                        <div class="col-12 d-flex justify-content-end">
                            {{ $past_orders->links('pagination::bootstrap-4') }} <!-- Pagination links -->
                        </div>
                    </div>


                </div>

            </div>

            
        </section>
       
    </main>

     {{-- CREATE ADDRESS MODAL --}}
     @include('partials.modal', [
        'id' => 'submitReviewModal',
        'title' => 'Write a Product Review',
        'body' => '
            <form id="productReviewForm" >
                    <div class="mb-3 justify-items-center">
                        <label for="rateTitle" class="form-label">Rate</label>
                        <h1 class="text-center">
                            <i class="fa fa-star submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                            <i class="fa fa-star submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                            <i class="fa fa-star submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                            <i class="fa fa-star submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                            <i class="fa fa-star submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                        </h1>
                        <input type="number" class="form-control" id="rate" name="rating" hidden>

                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                    <label for="reviewTitle" class="form-label">Review Title</label>
                    <input type="text" class="form-control" id="reviewTitle" name="title" >
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                    <label for="reviewText" class="form-label">Your Review</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" ></textarea>
                    </div>

                  
                    <div  class="d-flex justify-content-end align-items-end gap-1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="rateSubmitButton">Submit</button>
                    </div>
                    
            </form>
        ',
        'footer' => '
           
        ',
    ])
   
@endsection


@section('script')
    <!-- Include CSRF Token for Fetch Requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include Pusher.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>

    <script>
        window.routeUrls = {
            reviewRoute: "{{ route('store.product.review') }}",
        };
    </script>

    <!-- Your Custom Script -->
    <script src="{{ asset('assets/js/order-history.js') }}"></script>
@endsection
