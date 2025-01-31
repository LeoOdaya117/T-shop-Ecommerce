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
                                                <img src="{{ $product->image }}" alt="Product Image" style="width: 100px; height: auto;">
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
                                                ">{{ $order->order_status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <a href="{{ route('user.order.tracking', $order->id) }}" class="btn btn-light text-dark btn-outline-dark fw-bold">Track Order</a>
                                        <form id="cancelOrderForm" action="{{ route('admin.orders.orderStatus') }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="order_id" value="{{ $order->id }}" hidden>
                                            <input type="text" name="order_status" value="Cancelled" hidden>
                                            <button class="text-danger btn" type="submit">Cancel order</button>
                                        </form>
                                    </div>
                                
                                </div>
                            
                                
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
                                                <img src="{{ $product->image }}" alt="Product Image" style="width: 100px; height: auto;">
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
                                                ">{{ $order->order_status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-center">
                                        <a href="{{ route('user.order.tracking', $order->id) }}" class="btn btn-light text-dark btn-outline-dark fw-bold">View Order</a>
                                        @if (!$order->is_reviewed)
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
                    <input type="text" class="form-control" id="reviewTitle" name="title" required>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                    <label for="reviewText" class="form-label">Your Review</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
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
    <script>
        $("#cancelOrderForm").submit(function(e) {
           
            var form = $(this);
            var formData = form.serialize(); // Serialize the form data
            var url = form.attr('action'); 
            e.preventDefault();
            $.ajax({
                type: "PUT",
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    if(response.success == true) {
                        $('#alert-container').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div>
                        `);
                       
                        // $(`tr[data-variant-id="${variantId}"] td:nth-child(2)`).text(color);
                        // $(`tr[data-variant-id="${variantId}"] td:nth-child(3)`).text(size);

                    } else {
                        $('#alert-container').html(`
                            <div class="alert alert-danger">
                                Something went wrong. Please try again.
                            </div>
                        `);
                       
                    }
                },
                error: function(xhr, status, error) {
                   
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    for (let field in errors) {
                        errorHtml += `<li>${errors[field][0]}</li>`;
                    }
                    errorHtml += '</ul>';
                    $('#alert-container').html(`
                        <div class="alert alert-danger">
                            ${errorHtml}
                        </div>
                    `);
                }
            });
        });
    
        let orderData = null;
        $('.writeReviewBtn').on('click',function(){
            orderData = $(this).data('order');
            
            // alert('ORDER ID: '+ orderData.id + "PRODUCT ID: "+ orderData.product_id);
            $('#submitReviewModal').modal('show');

        });   
        $(document).ready(function() {
            var rating = 0; // Initialize rating to 0
           
            // Hover effect for stars
            $('.submit_star').on('mouseenter', function() {
                var rating = $(this).data('rating');
                for (var i = 1; i <= rating; i++) {
                    $('#submit_star_' + i).addClass('text-warning'); // Highlight stars on hover
                }
            });

            

            // Set the rating when a star is clicked
            $('.submit_star').on('click', function() {
                rating = $(this).data('rating'); // Save the rating value
                for (var i = 1; i <= 5; i++) {
                    $('#submit_star_' + i).removeClass('text-warning'); // Reset all stars
                }
                for (var i = 1; i <= rating; i++) {
                    $('#submit_star_' + i).addClass('text-warning'); // Highlight selected stars
                }
                $('#rate').val(rating); // Set the value of the input
            });

            $('#productReviewForm').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);  // 'this' refers to the form element

    // Create a new array to hold the product IDs
    var productArray = [];
    
    // Check if orderData.product_id is already an array, if not, make it an array
    if (Array.isArray(orderData.product_id)) {
        productArray = orderData.product_id;
    } else {
        // If it's a string, parse it into an array
        productArray = JSON.parse(orderData.product_id);
    }

    // Append each product ID individually to the new array
    productArray.forEach(function(product) {
        formData.append('products[]', product); // Appends each product ID as an individual item
    });

    formData.append('order_id', orderData.id);

    var url = "{{ route('store.product.review') }}";
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,  // Prevent jQuery from automatically transforming the data into a query string
        contentType: false,  // Don't set a content-type header; let the browser set it correctly for FormData
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
            if(response.success == true) {
                location.reload();
                Swal.fire("Saved!", response.message, "success");
            } else {
                Swal.fire("Error!", response.message, "error");
            }
        },
        error: function(xhr, status, error) {
            const errors = xhr.responseJSON.errors;
            let errorHtml = '';
            for (let field in errors) {
                errorHtml += `${errors[field][0]}<br>`;  // Added <br> for better error formatting
            }

            Swal.fire("Error!", errorHtml, "error");  // Correct string interpolation here
        }
    });
});

        });
    </script>
@endsection