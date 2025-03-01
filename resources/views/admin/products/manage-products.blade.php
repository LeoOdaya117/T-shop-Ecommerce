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
        /* Hide the dropdown content initially */
        .dropdown-content {
            display: none; /* Hide by default */
            right: 0;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            overflow-y: auto; /* Enable scrolling if content exceeds max height */
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 12356;
        }

        /* Show the dropdown content when the dropdown is active */
        .dropdown.show .dropdown-content {
            display: block;
        }

        /* Style for dropdown button */
        .dropdown-button {
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        

        /* Dropdown links */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            z-index: 12356;
            overflow-y: auto; /* Enable scrolling if content exceeds max height */
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
                            <h2 class="pageheader-title">Manage Products </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Products</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Products</li>
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
                            Products Table
                        </h5>
                        
                        <div class="card-body">

                            {{-- Alert message container --}}
                            <div id="alert-container"></div>
                            <!-- Form with Search and Filter -->
                            <div class="d-flex  align-items-center justify-content-between mb-2 ">
                                <form method="GET" action="{{ route('admin.products') }}" class="d-flex align-items-center position-relative">
                                    <!-- Search Input -->
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill" placeholder="Search products..." style="max-width: 100%;">

                                    <!-- Filter Button -->
                                    <button type="button" id="filterBtn" class="btn btn-primary ms-2"> <i class="fas fa-filter"></i> Filter</button>
                                    
                                    
                                    <!-- Filter Dropdown -->
                                    <div id="filterDropdown" class="d-none position-absolute bg-white border shadow rounded p-3 mt-2" style="max-width: 350px; left: 0;">
                                        <!-- Close Button Inside the Dropdown -->
                                        
                                        <form method="GET" action="{{ route('admin.products') }}" class="d-flex flex-column">
                                            <!-- Category Filter -->
                                            <select name="category" class="form-control rounded-pill mb-2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                               
                                            </select>
                                            
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
                                <div class="">
                                    <button class="btn btn-warning update-btn" id="bulkUpdateButton" style="display: none;">Update</button>

                                    <button class="btn btn-danger delete-btn" id="bulkDeleteButton" style="display: none;">Delete</button>
                                    <a href="{{ route('admin.create.product') }}" class="btn btn-success rounded">
                                        <i class="fas fa-plus"> Create</i>
                                    </a>
                                </div>
                                
                            </div>
                            <div class="table-responsive">

                                <table id="product-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            {{-- <th>#</th> --}}
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Price</th>
                                            <th>status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($products->count() > 0)
                                            @foreach($products as $product)
                                            

                                            <tr class="text-center
                                            @if ($product->lowest_stock <= 0)
                                                bg-danger text-white
                                            @elseif ($product->lowest_stock <= 10)
                                                bg-warning text-dark
                                            @else
                                                
                                            @endif
                                            
                                            ">
                                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                                <td><input type="checkbox" class="rowCheckbox" data-id="{{ $product->id }}"></td>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->title }}</td>
                                                {{-- <td>
                                                    @if($product->size && $product->color)
                                                        <p>{{ $product->size }}, {{ $product->color }}</p>
                                                    @else
                                                        <p>No variants available</p>
                                                    @endif
                                                </td> --}}
                                                <td>{{ $product->category_name ?? 'No category' }}</td>
                                                <td>{{ $product->brand_name ?? 'No brand' }}</td>
                                                <td>₱ {{ number_format($product->price,2) }}</td>
                                                <td>{{ $product->status }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <div>
                                                            <i class="dropdown-button fas fa-ellipsis-h"></i>
                                                        </div>
                                                        <div class="dropdown-content">
                                                            <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-light rounded">
                                                                <i class="fas fa-edit text-dark"></i> Edit
                                                            </a>
                                                            {{-- <a href="#" class="btn btn-info rounded adjust-btn" data-id="{{ $product->id }}">
                                                                <i class="fas fa-cogs"></i> Adjust Stock
                                                            </a> --}}
                                                            <a href="#" class="btn rounded btn-light delete-btn" data-id="{{ $product->id }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <p>No data found</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    
                                    
                                    
                                    
                                    
                                </table>
                
                                <!-- Pagination Links -->
                                <div class="mt-2">
                                    {{ $products->appends(request()->all())->links('pagination::bootstrap-5') }}

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

@include('partials.modal', [
    'id' => 'adjustStockModal',
    'title' => 'ADJUST PRODUCT STOCKS',
    'body' => '
        <form method="POST" id="adjustStockForm" >
    
            <div class="form-group">
                <label for="inputText3" class="col-form-label">Quantity</label>
                <input type="text" name="quantity_changed"  class="form-control rounded-pill" placeholder="0" >
            </div>
            
             <div class="form-group">
                <label for="inputText3" class="col-form-label">Asjustment Type</label>
                <select name="change_type" class="form-control rounded-pill mb-2">
                    <option value="" disable>Select Status</option>
                    <option value="add" >Add</option>
                    <option value="subtract">Subtract</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Reason" class="col-form-label">Reason</label>
                <input type="text" name="reason"  class="form-control rounded-pill" placeholder="Reason..." >
            </div>
            <div class="d-flex justify-content-end align-items-end">
                <button type="button" class="btn btn-secondary mx-1" id="cancelUpdateStockBtn">Cancel</button>
                <button type="submit" class="btn btn-danger" id="updateStockBtn">Update</button>
            </div>
            
           
        </form>
    ',
    'footer' => '
       
    ',
])

@include('partials.modal', [
    'id' => 'updateProductModal',
    'title' => 'Update Products',
    'body' => view('partials.update-product-form', compact('categories','brands'))->render(),
    'footer' => '
       
    ',
])



<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ asset('assets/js/products.js') }}"></script>

@endsection
