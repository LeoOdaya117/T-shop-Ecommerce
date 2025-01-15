@extends('admin.layouts.default')
@section('title', 'Categories')
@section('content')
<main>

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
                            <h2 class="pageheader-title">Categories </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Category</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manage Cateogries</li>
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
                            Category Table
                        </h5>
                        
                        <div class="card-body">
                            <!-- Form with Search and Filter -->
                            <div class="d-flex  align-items-center justify-content-between mb-2 ">
                                <form method="GET" action="{{ route('admin.categories') }}" class="d-flex align-items-center position-relative">
                                    <!-- Search Input -->
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill" placeholder="Search products..." style="max-width: 100%;">

                                    <!-- Filter Button -->
                                    <button type="button" id="filterBtn" class="btn btn-primary ms-2"> Search</button>
           
                                </form>

                                <!-- Add New Product Button -->
                                <a href="{{ route('admin.create.category') }}" class="btn btn-success rounded">
                                    <i class="fas fa-plus"> Create</i>
                                </a>
                            </div>
                            <div class="table-responsive">

                                <table id="product-table" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Slug</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($categories->count() > 0)
                                            @foreach($categories as $category)
                                                <tr class="text-center" id="tr_{{ $category->id }}">
                                                    <td>{{ $category->id }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->slug }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit.category', $category->id) }}" class="btn btn-warning rounded">
                                                            <i class="fas fa-edit text-dark"></i>
                                                        </a>
                                                        <a  href="#" class="btn btn-danger rounded delete-btn" data-id="{{ $category->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                                
                                            <tr >
                                                <td colspan="4" class="text-center">
                                                    <p>No data found</p>
                                                </td>
                                            </tr>
                                            
                                        @endif
                                    </tbody>
                                </table>
                
                                <!-- Pagination Links -->
                                <div class="mt-2">
                                    {{ $categories->links('pagination::bootstrap-5') }}
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
                    url: '/admin/categories/inactivate/' + itemIdToInactivate,
                    type: 'PUT',  // Using PATCH method
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                    },
                    success: function (result) {
                        $("#"+result['tr']).slideUp("slow");
                        inactivateModal.hide();
                    },
                    error: function () {
                        alert('An error occurred while updating the product status.');
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
