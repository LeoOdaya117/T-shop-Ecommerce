@extends('admin.layouts.default')
@section('title', 'Inventory')
@section('content')
    <main >
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
                                <h2 class="pageheader-title">Inventory Logs</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Products</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header d-flex justify-content-between align-items-center">
                                Order List
                            </h5>
                            
                            <div class="card-body">
                                <!-- Form with Search and Filter -->
                                <div class="d-flex  align-items-center justify-content-end mb-2 ">
                                    <form method="GET" action="{{ route('admin.inventory.inventory_logs') }}" class="d-flex align-items-center position-relative">
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
                                                    <option value="">Select Change Type</option>
                                                    <option value="add" {{ request('change_type') == 'add' ? 'selected' : '' }}>Stock In</option>
                                                    <option value="subtract" {{ request('change_type') == 'subtract' ? 'selected' : '' }}>Stock Out</option>
                                                   
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
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Change Type</th>
                                                <th class="text-center">Quantity Changed</th>
                                                <th class="text-center">Reason</th>
                                                <th class="text-center">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($inventoryLogs->count() > 0)
                                                @foreach ($inventoryLogs as $log)
                                                    <tr>
                                                        <td>
                                                            {{ $log->product->title }} 
                                                            {{ $log->product->color}} 
                                                            {{ $log->product->size }}</td>
                                                        <td class="text-center">{{ ucfirst($log->change_type) }}</td>
                                                        <td class="text-center">{{ $log->quantity_changed }}</td>
                                                        <td class="text-center">{{ $log->reason ?? 'N/A'}}</td>
                                                        <td class="text-center">{{ $log->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                                
                                            @else
                                                    
                                                    <tr>
                                                        <td colspan="5" class="text-center">No records found.</td>
                                                    </tr>
                                                
                                            @endif
                                        </tbody>
                                    </table>
                                    
                    
                                    {{-- <!-- Pagination Links -->
                                    <div class="mt-2">
                                        {{ $orders->links('pagination::bootstrap-5') }}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </main>

    <script>
        document.getElementById('filterBtn').addEventListener('click', function () {
        var filterDropdown = document.getElementById('filterDropdown');
        filterDropdown.classList.toggle('d-none');
    });

    document.getElementById('closeFilterDropdown').addEventListener('click', function () {
        document.getElementById('filterDropdown').classList.add('d-none');
    });


    // When the dropdown button is clicked, toggle the "show" class on the dropdown
    document.querySelectorAll('.dropdown-button').forEach(button => {
            button.addEventListener('click', function() {
                var dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('show');
            });
        });

        // Optional: Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-button')) {
                var dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(function(dropdown) {
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                });
            }
        }
    </script>
@endsection()
                                