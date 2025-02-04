@extends('admin.layouts.default')
@section('title', 'Inventory')

@section('content')
<style>
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
                                <h2 class="pageheader-title">Shipping Options</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.shipping') }}" class="breadcrumb-link">Shipping</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Shipping Option</li>
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
                                Shipping Option List
                            </h5>
                            
                            <div class="card-body">
                                <!-- Form with Search and Filter -->
                                <div class="d-flex  align-items-center justify-content-between mb-2 ">
                                    <form method="GET" action="{{ route('admin.shipping') }}" class="d-flex align-items-center position-relative">
                                        <!-- Search Input -->
                                        <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill" placeholder="Search categories..." style="max-width: 100%;">

                                        <!-- Filter Button -->
                                        <button type="button" id="filterBtn" class="btn btn-primary ms-2"> <i class="fas fa-filter"></i> Filter</button>
                                        
                                        
                                        <!-- Filter Dropdown -->
                                        <div id="filterDropdown" class="d-none position-absolute bg-white border shadow rounded p-3 mt-2" style="max-width: 350px; left: 0;">
                                            <!-- Close Button Inside the Dropdown -->
                                            
                                            <form method="GET" action="{{ route('admin.shipping') }}" class="d-flex flex-column">
                                                        
                                                <!-- Status Filter -->
                                                <select name="status" class="form-control rounded-pill mb-2">
                                                    <option value="">Select Status</option>
                                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>

                                                <!-- Submit Button -->
                                                <div class="d-flex">
                                                    <button type="submit" class="btn btn-primary rounded-pill mr-1">Apply Filters</button>
                                                    <button type="button" id="closeFilterDropdown" class="btn btn-secondary rounded-pill w-100">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </form>

                                    <!-- Add New Product Button -->
                                    <a href="{{ route('admin.shipping.create') }}" class="btn btn-success rounded">
                                        <i class="fas fa-plus"> Create</i>
                                    </a>
                                </div>
                                <div class="table-responsive">
    
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Carrier</th>
                                                <th class="text-center">Estimated Date</th>
                                                <th class="text-center">Cost</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($shipping_options->count() > 0)
                                                @foreach ($shipping_options as $shipping_option)
                                                    <tr class="text-center">
                                                        <td>{{ ($shipping_options->currentPage() - 1) * $shipping_options->perPage() + $loop->iteration }}</td>
                                                        <td>{{ $shipping_option->name }}</td>
                                                        <td>{{ $shipping_option->carrier }}</td>
                                                        <td>{{ $shipping_option->min_days }} - {{ $shipping_option->max_days }} days</td>
                                                        <td>₱ {{ number_format($shipping_option->cost, 2) }}</td>
                                                        <td>{{ ucfirst($shipping_option->status) }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.shipping.edit', $shipping_option->id) }}" 
                                                               class="btn btn-warning rounded">
                                                                <i class="fas fa-edit text-dark"></i>
                                                            </a>
                                                            <a href="#" 
                                                               class="btn btn-danger rounded delete-shipping-btn" 
                                                               data-url="{{ route('admin.shipping.delete', $shipping_option->id) }}" 
                                                               data-id="{{ $shipping_option->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    
                                    
                    
                                    <!-- Pagination Links -->
                                    <div class="mt-2">
                                        {{ $shipping_options->links('pagination::bootstrap-5') }}
                                    </div>
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


        // DELETE ADDRESS
        $(document).on('click', '.delete-shipping-btn', function(){
            const shipping_option_id = $(this).data('id'); // Get ID
            const deleteUrl = $(this).data('url'); // Get delete URL

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: deleteUrl,
                        data: {
                            shipping_option_id: shipping_option_id,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove row from the table without refreshing
                                $(`a[data-id="${shipping_option_id}"]`).closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });

                                Swal.fire({
                                    title: "Deleted!",
                                    text: "The shipping option has been removed.",
                                    icon: "success"
                                });
                            } else {
                                Swal.fire("Error!", "Failed to delete the shipping option.", "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("Error!", "Something went wrong. Try again later.", "error");
                        }
                    });
                }
            });
        });

    
    </script>
@endsection()
                                