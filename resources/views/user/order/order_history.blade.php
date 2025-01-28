@extends('layouts.my-account-layout')
@section('title', 'Order History')
@section('my-account')
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
    <main class="container  mb-5">
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
    

    </script>
@endsection