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

button{
    cursor: pointer;
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
                                        <li class="breadcrumb-item active" aria-current="page">Orders List</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->

                <div class="container">
                    <div class="row">
                        @foreach ($groupOrders as $order)
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                <form method="GET" action="{{ route('admin.orders') }}">
                                    <input type="hidden" name="order_status" value="{{ $order->order_status }}">
                                    <button type="submit" class="border-0 bg-transparent p-0 w-100">
                                        <div class="card bg-{{ 
                                            $order->order_status == 'Delivered' ? 'success' : 
                                            ($order->order_status == 'Processing' ? 'warning' : 
                                            ($order->order_status == 'Shipped' ? 'info' : 
                                            ($order->order_status == 'Cancelled' ? 'danger' : 'secondary')))
                                        }} text-dark">
                                            <div class="card-header text-center">
                                                <strong>{{ $order->order_status }}</strong>
                                            </div>
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-white">{{ $order->order_count }} Orders</h5>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                
                <!-- ============================================================== -->
                <!-- basic table  -->
                <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header d-flex justify-content-between align-items-center">
                            Order List
                        </h5>
                        
                        <div class="card-body">
                            <!-- Form with Search and Filter -->
                            <div class="d-flex  align-items-center justify-content-end mb-2 ">
                                <form method="GET" action="{{ route('admin.orders') }}" class="d-flex align-items-center position-relative">
                                    <!-- Search Input -->
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill" placeholder="Search products..." style="max-width: 100%;">

                                    <!-- Filter Button -->
                                    <button type="button" id="filterBtn" class="btn btn-primary ms-2"> <i class="fas fa-filter"></i> Filter</button>
                                    
                                    
                                    <!-- Filter Dropdown -->
                                    <div id="filterDropdown" class="d-none position-absolute bg-white border shadow rounded p-3 mt-2" style="max-width: 350px; left: 0;">
                                        <!-- Close Button Inside the Dropdown -->
                                        
                                        <form method="GET" action="{{ route('admin.orders') }}" class="d-flex flex-column">
                                            
                                                        
                                            <!-- Status Filter -->
                                            <select name="order_status" class="form-control rounded-pill mb-2">
                                                <option value="">Select Status</option>
                                                <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="Processing" {{ request('order_status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="Cancelled" {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>Cancel</option>
                                                <option value="Order Placed" {{ request('order_status') == 'Order Placed' ? 'selected' : '' }}>Order Placed</option>

                                            </select>

                                            <!-- Submit Button -->
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-primary rounded-pill mr-1">Apply Filters</button>
                                                <button type="button" id="closeFilterDropdown" class="btn btn-secondary rounded-pill w-100">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </form>

                            
                            </div>
                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <thead class="bg-light">
                                        <tr class="border-0 text-center">
                                            <th class="border-0">Order ID</th>
                                            <th class="border-0">Total Price</th>
                                            <th class="border-0">Customer</th>
                                            <th class="border-0">Order Time</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orders->count() > 0)
                                            @foreach ($orders as $order)
                                                <tr class="text-center">
                                                    
                                                    <td>{{ $order->id }}</td>
                                                    <td>₱ {{ number_format($order->total_price,2) }}</td>
                                                    <td>{{ $order->fname }} {{ $order->lname }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td >
                                                        <div class="
                                                            @if ($order->order_status == "Delivered")
                                                                text-success
                                                            @elseif($order->order_status == "Order Placed")
                                                            text-dark
                                                            @elseif($order->order_status == "Processing")
                                                            text-warning
                                                            @elseif($order->order_status == "Shipped")
                                                            text-info
                                                            @else
                                                                text-danger
                                                            @endif
                                                        rounded text-white">
                                                            {{ $order->order_status }}
                                                        </div>
                                                    
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.orders.details', $order->id) }}" title="View Order Details"><i class="fas fa-eye"></i></a>
                                                    </td>
                                

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr >
                                                <td colspan="6" class="text-center">
                                                    <p>No data found</p>
                                                </td>
                                            </tr>
                                        @endif
                                        
                                        

                                      
                                    </tbody>
                                </table>
                
                                <!-- Pagination Links -->
                                <div class="mt-2">
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
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

<!-- Include Modal -->
@include('partials.modal', [
    'id' => 'deleteConfirmationModal',
    'title' => 'Delete Confirmation',
    'body' => '
        <p>Are you sure you want to delete this item? This action cannot be undone.</p>
    ',
    'footer' => '
        <button type="button" class="btn btn-secondary" id="cancelDelete">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
    ',
])



<script>
   document.getElementById('filterBtn').addEventListener('click', function () {
        var filterDropdown = document.getElementById('filterDropdown');
        filterDropdown.classList.toggle('d-none');
    });

    document.getElementById('closeFilterDropdown').addEventListener('click', function () {
        document.getElementById('filterDropdown').classList.add('d-none');
    });


    
    function route(routeUrl) {
        window.location.href = routeUrl;
    }   
</script>
@endsection
