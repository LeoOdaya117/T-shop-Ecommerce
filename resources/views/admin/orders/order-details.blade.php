@extends('admin.layouts.default')
@section('title', 'Products')
@section('content')
<main>
    <style>
        /* Dropdown Container */
#filterDropdown {
    position: absolute; /* Position it below the search input */
    top: 100%; /* Align it right below the input */
    left: 0;
    width: 100%; /* Make sure it spans the width of the input */
    z-index: 1050; /* Set a higher z-index so it stays above other content */
    max-height: auto; /* Set a max height to avoid overflow */
    overflow-y: auto; /* Enable scrolling if content exceeds max height */
    border: 1px solid #ddd; /* Optional: border for the dropdown */
    border-radius: 5px; /* Optional: rounded corners */
}

/* Dropdown Items */
#filterDropdown select {
    width: 100%; /* Ensure select boxes take the full width */
}

    </style>
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Orders </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Orders</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}" class="breadcrumb-link">Orders List</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Orders Details</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->

               
                
                <!-- ============================================================== -->
                <!-- basic table  -->
                <!-- ============================================================== -->
               
                <div class="row">

                    
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
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
                        <div class="card">
                            <h4 class="card-header d-flex justify-content-between align-items-center">
                                ORDER: #{{ $orderInfo->id }}
                                <div class=" 
                                    @if ($orderInfo->order_status == "Delivered")
                                        text-success
                                    @elseif($orderInfo->order_status == "Order Placed")
                                        text-dark
                                    @elseif($orderInfo->order_status == "Processing")
                                        text-warning
                                    @elseif($orderInfo->order_status == "Shipped")
                                        text-info
                                    @else
                                        text-danger
                                    @endif
                                    ">
                                    {{ $orderInfo->order_status }}
                                </div>
                            </h4>
                            
                            <div class="card-body">
                               <!-- Order Summary -->
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="m-0">Order Summary</h5>
                                        <p class="m-0">Order ID: #{{ $orderInfo->id }}</p>
                                        <p class="m-0">Order Date: {{ $orderInfo->created_at->format('F j, Y') }}</p>
                                        <p class="m-0">Order Status: <span class="badge 
                                            @if ($orderInfo->order_status == "Delivered")
                                                bg-success
                                            @elseif($orderInfo->order_status == "Order Placed")
                                                bg-dark
                                            @elseif($orderInfo->order_status == "Processing")
                                                bg-warning
                                            @elseif($orderInfo->order_status == "Shipped")
                                                bg-info
                                            @else
                                                bg-danger
                                            @endif
                                            text-white
                                            ">{{ $orderInfo->order_status }}</span></p>
                                        <p class="m-0">Payment Method: {{ $orderInfo->payment_method }}</p>    
                                        <p class="m-0">Total Amount: ₱ {{ number_format($orderInfo->total_price, 2) }}</p>
                            
        
                                    </div>
                                    <div class="col-6">
                                         <!-- Customer Info -->
                                        <h5 class="m-0">Customer Information</h5>
                                        <p class="m-0">Name: {{ $orderInfo->fname }} {{ $orderInfo->lname }}</p>
                                        <p class="m-0">Email: {{ $orderInfo->email ?? 'N/A'}}</p>
                                        <p>Phone: {{ $orderInfo->phone ?? 'N/A'}}</p>
                                        <p class="m-0"><strong>Shipping Address:</strong></p>
                                        <p class="m-0">{{ $orderInfo->shippingAddress->address_line_1 }}</p>
                                            @if ($orderInfo->shippingAddress->address_line_2)
                                                <p class="m-0">{{ $orderInfo->shippingAddress->address_line_2 }}</p>
                                            @endif
                                        <p class="m-0">{{ $orderInfo->shippingAddress->city }}, {{ $orderInfo->shippingAddress->province }} {{ $orderInfo->shippingAddress->postal_code }}</p>
                                        <p class="m-0">{{ $orderInfo->shippingAddress->country }}</p>
                                
                                    </div>
                                </div>
                                
                           
                                
                                <hr>
                                
                                
                            </div>
                        </div>

                        <div class="card">
                            <h5 class="card-header d-flex">ORDERED ITEMS</h5>
                            <div class="container-fluid table-responsive">
                                
                                <table class="table ">
                                    <thead>
                                        <tr class="">
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ordered_items as $item)

                                            <tr>
                                                <td>
                                                   <div >
                                                        {{ $item['product_name'] }}
                                                        <p class="">
                                                            <small>{{ $item['variant']['color'] ?? '' }}</small>
                                                            <small>{{ $item['variant']['size'] ?? '' }}</small>
                                                        </p>
                                                        
                                                   </div>
                                                </td>
                                                <td>₱ {{ number_format($item['price'],2) }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>₱ {{ number_format($item['subtotal'] ,2) }}</td>
                                            </tr>
                                                
                                        @endforeach
                                        
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end"><strong>Subtotal:</strong></td>
                                            <td class="text-end"><strong>₱  {{ number_format($orderInfo->total_price , 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end"><strong>Shipping:</strong></td>
                                            <td class="text-end"><strong>₱ {{ number_format($orderInfo->shipping_fee, 2)  }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end"><h5>Grand Total:</h5></td>
                                            <td class="text-end"><h5>₱ {{ number_format($orderInfo->total_price + $orderInfo->shipping_fee, 2) }}</h5></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                              
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="card   text-center">
                            <h5 class="card-header">
                                ORDER STATUS
                            </h5>
                            
                            <div class="card-body">
                                <form id="updateStatusForm" action="{{ route('admin.orders.update', $orderInfo->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="order_status" class="form-control rounded-pill mb-3 text-center">
                                        <option class=" fw-bolder" disabled>Choose Status</option>
                                        <option class="text-success fw-bolder" value="Delivered" {{$orderInfo->order_status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                        <option class="text-primary fw-bolder" value="Out for Delivery" {{$orderInfo->order_status == 'Out for Delivery' ? 'selected' : ''}}>Out for Delivery</option>
                                        <option class="text-info fw-bolder"  value="Shipped" {{$orderInfo->order_status == 'Shipped' ? 'selected' : ''}}>Shipped</option>
                                        <option class="text-waring fw-bolder"  value="Processing" {{$orderInfo->order_status == 'Processing' ? 'selected' : ''}}>Processing</option>
                                        <option class="text-danger fw-bolder"  value="Cancelled" {{$orderInfo->order_status == 'Cancelled' ? 'selected' : ''}}>Cancel</option>
                                        <option class="text-danger fw-bolder"  value="Order Placed" {{$orderInfo->order_status == 'Order Placed' ? 'selected' : ''}}>Order Placed</option>

    
                                    </select>
                                    <button class="btn btn-primary w-100 rounded" type="submit" {{$orderInfo->order_status == 'Delivered' ? 'disabled' : ''}}>Update</button>
                                </form>
                               

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end basic table  -->
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</main>




@endsection
