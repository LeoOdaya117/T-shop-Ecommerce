@extends('admin.layouts.default')
@section('title', 'Categories')

@section('content')
<main>
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
                            <h2 class="pageheader-title">Brands </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Brands</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Brand List</li>
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header d-flex justify-content-between align-items-center">
                            Brands List
                        </h5>
                        
                        <div class="card-body">
                            <div id="alert-container"></div>

                            <!-- Form with Search and Filter -->
                            <div class="d-flex  align-items-center justify-content-between mb-2 ">
                                <form method="GET" action="{{ route('admin.brands') }}" class="d-flex align-items-center position-relative">
                                    <!-- Search Input -->
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill" placeholder="Search brands..." style="max-width: 100%;">

                                    <!-- Filter Button -->
                                    <button type="button" id="filterBtn" class="btn btn-primary ms-2"> <i class="fas fa-filter"></i> Filter</button>
                                    
                                    
                                    <!-- Filter Dropdown -->
                                    <div id="filterDropdown" class="d-none position-absolute bg-white border shadow rounded p-3 mt-2" style="max-width: 350px; left: 0;">
                                        <!-- Close Button Inside the Dropdown -->
                                        
                                        <form method="GET" action="{{ route('admin.categories') }}" class="d-flex flex-column">
                                                       
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
                                <a href="{{ route('admin.brand.createpage') }}" class="btn btn-success rounded">
                                    <i class="fas fa-plus"> Create</i>
                                </a>
                            </div>
                            <div class="table-responsive">

                                <table id="product-table" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Brand Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($brands->count() > 0)
                                            @foreach($brands as $brand)
                                                <tr class="text-center" id="tr_{{ $brand->id }}">
                                                    <td>{{ $brand->id }}</td>
                                                    <td>{{ $brand->name }}</td>
                                                    <td>{{ $brand->slug }}</td>
                                                    <td>{{ $brand->status }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit.brand', $brand->id) }}" class="btn btn-warning rounded">
                                                            <i class="fas fa-edit text-dark"></i>
                                                        </a>
                                                        <a  href="#" class="btn btn-danger rounded delete-btn" data-id="{{ $brand->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                                
                                            <tr >
                                                <td colspan="5" class="text-center">
                                                    <p>No data found</p>
                                                </td>
                                            </tr>
                                            
                                        @endif
                                    </tbody>
                                </table>
                
                                <!-- Pagination Links -->
                                <div class="mt-2">
                                    {{ $brands->links('pagination::bootstrap-5') }}
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
    document.addEventListener('DOMContentLoaded', function () {
        let itemIdToInactivate = null;
        const inactivateModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
                

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                itemIdToInactivate = this.dataset.id;
                inactivateModal.show();
            });
        });

        document.getElementById('cancelDelete').addEventListener('click', function () {
            if (itemIdToInactivate) {
                inactivateModal.hide();
            }
        });
        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (itemIdToInactivate) {
                console.log("Deleted");
                $.ajax({
                    url: '/admin/brand/inactivate/' + itemIdToInactivate,
                    type: 'PUT',  // Using PATCH method
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                    },
                    success: function (result) {
                        $("#"+result['tr']).slideUp("slow");
                        inactivateModal.hide();
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (xhr.status === 422) {
                           
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
                        } else {
                            $('#alert-container').html(`
                                <div class="alert alert-danger">
                                    ${errors}
                                </div>
                            `);
                        }
                    }
                });
            }
        });
    });
    document.getElementById('filterBtn').addEventListener('click', function () {
        var filterDropdown = document.getElementById('filterDropdown');
        filterDropdown.classList.toggle('d-none');
    });

    document.getElementById('closeFilterDropdown').addEventListener('click', function () {
        document.getElementById('filterDropdown').classList.add('d-none');
    });


</script>
@endsection
