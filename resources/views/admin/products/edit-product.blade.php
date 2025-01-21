@extends('admin.layouts.default')
@section('title', 'Products')
@section('style')

@endsection
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
                                <h2 class="pageheader-title">Products </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Products</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Products List</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
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
                            <h5 class="card-header ">
                               Edit {{ $productInfo->title }}
                            </h5>
                            <div class="card-body">
                                <div class="container">
                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.update.product', $productInfo->id) }}" method="POST" style="color: black;" id="productUpdateForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-0">
                                            <div class="col">
                                                <div class="row d-block">
                                                    <div class="col">
                                                        <h5 for="inputText3" class="col-form-label">Product Image</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <img class="border border-dark" id="image-container" src="{{ $productInfo->image ?? asset('assets/image/no-product-image.png')}}" alt="{{ $productInfo->title }}" height="200" width="100%">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input name="image" id="image-url" type="text" class="form-control" value="{{ $productInfo->image }}" placeholder="Image URL">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label">Title</label>
                                                            <input name="title" id="title" type="text" class="form-control" value="{{ $productInfo->title }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label">Slug</label>
                                                            <input readonly name="slug" id="slug" type="text" class="form-control" value="{{ $productInfo->slug }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Price</label>
                                                    <input name="price" type="text" class="form-control" value="{{ $productInfo->price }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Category</label>
                                                    <select name="category" class="form-control" id="input-select">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $category->id == $productInfo->category ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Brand</label>
                                                    <select name="brand" class="form-control" id="input-select">
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ $brand->id == $productInfo->brand ? 'selected' : '' }}>
                                                                {{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active" {{ $productInfo->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $productInfo->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Discount</label>
                                                    <input name="discount" type="text" class="form-control" value="{{ $productInfo->discount }}">
                                                </div>
                                                
                                            </div>
                                            <div class="col">
                                               
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Description</label>
                                                    <textarea class="form-control" name="description" rows="9">{{ $productInfo->descrption }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                      
                                        
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-warning rounded" type="button" id="openModal">Update</button>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="container">
                                      <!-- Variants Section -->
                                      <div class="row mt-4">
                                        <div class="col">
                                            <h4>Variants</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Variant ID</th>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th>Stock</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($productInfo->variants as $variant)
                                                        <tr class="text-center">
                                                            <td>{{ $variant->id }}</td>
                                                            <td>{{ $variant->color }}</td>
                                                            <td>{{ $variant->size }}</td>
                                                            <td>{{ $variant->stock }}</td>
                                                            <td>
                                                                <button  class="btn btn-info rounded adjust-btn" data-id="{{ $variant->id }}" 
                                                                    data-product-id="{{ $variant->product_id }}">
                                                                    <i class="fas fa-cogs"></i> Adjust Stock
                                                                </button>
                                                               
                                                                <a href="#" class="btn btn-danger rounded delete-btn" data-id="{{ $variant->id }}"  >
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- End Variants Section -->
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

    @include('partials.modal', [
        'id' => 'updateConfirmation',
        'title' => 'Update Confirmation',
        'body' => '
            <p>Are you sure you want to update this product? This action cannot be undone.</p>
        ',
        'footer' => '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-warning" id="confirmUpdate">Update</button>
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
    
    

   <script>
    document.getElementById('openModal').addEventListener('click', function () {
        $('#updateConfirmation').modal('show');
    });

    document.getElementById('confirmUpdate').addEventListener('click', function () {
        const form = document.getElementById('productUpdateForm');
        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('admin.update.product', $productInfo->id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#updateConfirmation').modal('hide');
                $('#alert-container').html(`<div class="alert alert-success">Product updated successfully!</div>`);
            },
            error: function (xhr) {
                $('#updateConfirmation').modal('hide');
                if (xhr.status === 422) {
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
                } else {
                    $('#alert-container').html(`
                        <div class="alert alert-danger">
                            Something went wrong. Please try again.
                        </div>
                    `);
                }
            }
        });
    });

    document.getElementById('image-url').addEventListener('change', function() {
        const newImageUrl = this.value;
        const imageElement = document.getElementById('image-container');
        
        if (newImageUrl) {
            imageElement.src = newImageUrl;
        } else {
            imageElement.src = "{{ asset('assets/image/no-product-image.png') }}";
        }
    });

    document.getElementById('title').addEventListener('change', function() {
        const newTitle = this.value;
        const slugElement = document.getElementById('slug');

        if (newTitle) {
            slugElement.value = createSlug(newTitle);
        } else {
            slugElement.value = "";
        }
    });

    function createSlug(title){
        return title.replace(/ /g,"-").toLowerCase();
    }
   
   
    document.addEventListener('DOMContentLoaded', function () {
    let productId = null;
    let variant_id = null;
    const adjustStockModal = new bootstrap.Modal(document.getElementById('adjustStockModal'));
   
    // Assuming you have a button or link to open the modal
    $('.adjust-btn').on('click', function() {
        $('#adjustStockForm')[0].reset(); // Reset form data
        variantId = this.getAttribute('data-id');
        productId = this.getAttribute('data-product-id');
        adjustStockModal.show();
    });

    document.getElementById('cancelUpdateStockBtn').addEventListener('click', function () {
            adjustStockModal.hide();
    });

    $("#adjustStockForm").submit(function(e) {
            const url = `{{ route('admin.inventory.stock.update') }}`;
           
            var form = $(this);
            var formData = form.serialize(); // Serialize the form data

            // Append product_id to the serialized form data
            formData += `&product_id=${productId}`;
            formData += `&variant_id=${variantId}`;
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
                        
                        adjustStockModal.hide();
                        Swal.fire({
                            icon: 'success', // Icon type ('success', 'error', 'warning', 'info', 'question')
                            title: 'Success!',
                            text: response.message, // Display the success message from the response
                            confirmButtonText: 'OK', // Button text
                        });

                        location.reload();
                        
                    } else {
                        $('#alert-container').html(`
                            <div class="alert alert-danger">
                                Something went wrong. Please try again.
                            </div>
                        `);
                        adjustStockModal.hide();
                    }
                },
                error: function(xhr, status, error) {
                    adjustStockModal.hide(); // Close the modal on failure
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
    });
    

        



   </script>
@endsection
