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
                    <div class="row text-center">
                        <!-- Order Placed -->
                        <div class="col-md-2">
                            <div class="card bg-light text-white">
                                <div class="card-body">
                                    <h5 class="card-title">New Order</h5>
                                    <h3>30</h3>
                                </div>
                            </div>
                        </div>
                       
                        <!-- Pending -->
                        <div class="col-md-2">
                            <div class="card bg-warning text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Processing</h5>
                                    <h3>15</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Shipped -->
                        <div class="col-md-2">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Shipped</h5>
                                    <h3>10</h3>
                                </div>
                            </div>
                        </div>
                         <!-- Delivered -->
                         <div class="col-md-2 ">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Delivered</h5>
                                    <h3>25</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Cancelled -->
                        <div class="col-md-2">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Cancelled</h5>
                                    <h3>5</h3>
                                </div>
                            </div>
                        </div>
                        
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
                                            
                                            {{-- <!-- Price Filter -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <!-- Min Price Input -->
                                                <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control me-2" placeholder="Min Price" style="max-width: 150px;">
                                                
                                                <!-- 'To' Text -->
                                                <span class="mx-2">to</span>
                                                
                                                <!-- Max Price Input -->
                                                <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control me-2" placeholder="Max Price" style="max-width: 150px;">
                                            </div> --}}
                                                                               
                                            <!-- Status Filter -->
                                            <select name="order_status" class="form-control rounded-pill mb-2">
                                                <option value="">Select Status</option>
                                                <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="Processing" {{ request('order_status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="Cancelled" {{ request('order_status') == 'Cancelled' ? 'selected' : '' }}>Shipped</option>
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

                                <table class="table">
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
                                        @foreach ($orders as $order)
                                            <tr class="text-center">
                                                
                                                
       
                                                <td>{{ $order->id }}</td>
                                                <td>₱ {{ $order->total_price }}</td>
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

    
    
</script>
@endsection
