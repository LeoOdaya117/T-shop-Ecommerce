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
                                            <button class="btn btn-warning rounded" type="button" id="updateProductOpenModal">Update</button>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="container">
                                      <!-- Variants Section -->
                                      <div class="row mt-4">
                                        <div class="col">
                                            <div id="alert-container2"></div>
                                            <div class="d-flex m-1">
                                                <h4>Product Variants</h4>
                                                <button class="btn btn-success rounded ml-auto" id="addVariantBtn" data-id="{{ $productInfo->id }}" data-title="{{ $productInfo->title }}">
                                                    <i class="fas fa-plus"></i> Add Variant
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover tabled" id="variants-table">
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
                                                            <tr class="text-center" data-variant-id="{{ $variant->id }}">
                                                                <td>{{ $variant->id }}</td>
                                                                <td>{{ $variant->color }}</td>
                                                                <td>{{ $variant->size }}</td>
                                                                <td>{{ $variant->stock }}</td>
                                                                <td>
                                                                    <button  class="btn btn-info rounded adjust-btn" data-id="{{ $variant->id }}" data-product-id="{{ $productInfo->id }}">
                                                                 
                                                                        <i class="fas fa-cogs"></i> Adjust Stock
                                                                    </button>
                                                                    <button class="btn btn-warning rounded edit-btn" title="Edit Variant Data" data-id="{{ $variant->id }}" data-productid="{{ $variant->product_id }}" 
                                                                    data-color="{{ $variant->color }}" data-size="{{ $variant->size }}" >
                                                                        <i class="fas fa-edit"></i> 
                                                                    </button>
                                                                   
                                                                    <button class="btn btn-danger rounded variantDelete-btn" title="Delete Variant Data" data-id="{{ $variant->id }}"  >
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
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
   {{-- ADJUST STOCK MODAL --}}
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
                    <button type="button" class="btn btn-secondary mx-1" id="cancelUpdateStockBtn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="updateStockBtn">Update</button>
                </div>
                
               
            </form>
        ',
        'footer' => '
           
        ',
    ])

    {{-- UPDATE VARIANT MODAL --}}
    @include('partials.modal', [
        'id' => 'updateVariantModal',
        'title' => 'Update Product Variant',
        'body' => '
            <form method="PUT" id="updateVariantForm" >
        
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Variant ID</label>
                    <input readonly type="text" name="variant_id" id="variantId"  class="form-control rounded-pill" placeholder="" >
                </div>
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Color</label>
                    <input type="text" name="color" id="variantColor"  class="form-control rounded-pill" placeholder="" >
                </div>
                
                
                 <div class="form-group">
                    <label for="inputText3" class="col-form-label">Size</label>
                    <select name="size" id="variantSize" class="form-control rounded-pill mb-2">
                        <option value="" disable>Select size</option>
                        <option value="Small" >Small</option>
                        <option value="Medium" >Medium</option>
                        <option value="Large" >Large</option>
                        <option value="Xl" >Extra Large</option>
                        
                    </select>
                </div>
                
                <div class="d-flex justify-content-end align-items-end">
                    <button type="button" class="btn btn-secondary mx-1" id="cancelProductVarintBtn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="updateProductBtn">Update</button>
                </div>
                
               
            </form>
        ',
        'footer' => '
           
        ',
    ])

    {{-- CREATE VARIANT MODAL --}}
    @include('partials.modal', [
        'id' => 'createVariantModal',
        'title' => 'Create Product Variant',
        'body' => '
            <form method="POST" id="createVariantForm" >
        
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Product ID</label>
                    <input readonly type="text" name="product_Id" id="variant_product_id"  class="form-control rounded-pill" placeholder="" >
                </div>
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Product Title</label>
                    <input readonly type="text" name="product_title" id="variant_product_title" class="form-control rounded-pill" placeholder="" >
                </div>
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Color</label>
                    <input type="text" name="color"  class="form-control rounded-pill" placeholder="" >
                </div>
                
                <div class="form-group">
                    <label for="inputText3" class="col-form-label">Size</label>
                    <select name="size" class="form-control rounded-pill mb-2">
                        <option value="" disable>Select size</option>
                        <option value="Small" >Small</option>
                        <option value="Medium" >Medium</option>
                        <option value="Large" >Large</option>
                        <option value="Xl" >Extra Large</option>
                        
                    </select>
                </div>
                
                <div class="form-group">
                        <label for="inputText3" class="col-form-label">Quantity</label>
                        <input type="text" name="quantity"  class="form-control rounded-pill" placeholder="0" >
                </div>
                
                <div class="d-flex justify-content-end align-items-end">
                    <button type="button" class="btn btn-secondary mx-1" id="cancelCreateProductVariantBtn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="createProductBtn">Save</button>
                </div>
                
            
            </form>
        ',
        'footer' => '
        
        ',
    ])
        
        

   <script src="{{ asset('assets/js/products.js') }}"></script>
   <script>
    // EDIT PRODUCT BLADE
    $('#updateProductOpenModal').on('click', function () {
        $('#updateConfirmation').modal('show');
    });

    $('#confirmUpdate').on('click', function () {
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

    let productId = null;
    let variantId = null;


    // Assuming you have a button or link to open the modal
    $(document).ready(function () {
        $('.adjust-btn').on('click', function() {
        
            $('#adjustStockForm')[0].reset(); // Reset form data
            variantId = this.getAttribute('data-id');
            productId = this.getAttribute('data-product-id');
            $('#adjustStockModal').modal('show');
        
        });
        
    });


    $('#cancelUpdateStockBtn').on('click', function () {
            $('#adjustStockModal').modal('hide');
        
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
                        const newStock = response.new_stock; // Assuming the server returns the updated stock value
                        $('#alert-container2').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div>
                        `);

                        $(`tr[data-variant-id="${variantId}"] td:nth-child(4)`).text(newStock);
                        
                        $('#adjustStockModal').modal('hide');
                        
                    } else {
                        $('#alert-container2').html(`
                            <div class="alert alert-danger">
                                Something went wrong. Please try again.
                            </div>
                        `);
                        $('#adjustStockModal').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    $('#adjustStockModal').modal('hide');
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    for (let field in errors) {
                        errorHtml += `<li>${errors[field][0]}</li>`;
                    }
                    errorHtml += '</ul>';
                    $('#alert-container2').html(`
                        <div class="alert alert-danger">
                            ${errorHtml}
                        </div>
                    `);
                    
                }
                
        
                
            });
    });


    // EDIT PRODUCT VARIANT
    $(document).ready(function () {
        $('.edit-btn').on('click', function() {
            const variantId = this.dataset.id;
            const productId = this.dataset.productid;
            const color = this.dataset.color;
            const size = this.dataset.size;
            // $('#updateVariantForm')[0].reset(); // Reset form data
            $('#variantId').val(variantId);
            $('#variantColor').val(color);
            $('#variantSize').val(size);
           
            $('#updateVariantModal').modal('show');
        });
    });
    $('#cancelProductVarintBtn').on('click', function () {
        $('#updateVariantModal').modal('hide');
    });

    $("#updateVariantForm").submit(function(e) {
        const url = `{{ route('admin.update.variant') }}`;
        var form = $(this);
        var formData = form.serialize(); // Serialize the form data
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
                    $('#alert-container2').html(`
                        <div class="alert alert-success">
                            ${response.message}
                        </div>
                    `);
                    const variantId = response.variant_id;
                    const color = response.new_color;
                    const size = response.new_size;
                    $(`tr[data-variant-id="${variantId}"] td:nth-child(2)`).text(color);
                    $(`tr[data-variant-id="${variantId}"] td:nth-child(3)`).text(size);
                    $('#updateVariantModal').modal('hide');
                } else {
                    $('#alert-container2').html(`
                        <div class="alert alert-danger">
                            Something went wrong. Please try again.
                        </div>
                    `);
                    $('#updateVariantModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $('#updateVariantModal').modal('hide');
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                for (let field in errors) {
                    errorHtml += `<li>${errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
                $('#alert-container2').html(`
                    <div class="alert alert-danger">
                        ${errorHtml}
                    </div>
                `);
            }
        });
    });
   
    // DELETE PRODUCT VARIANT
    $(document).ready(function () {
        $('.variantDelete-btn').on('click', function() {
            const variantId = this.dataset.id;
            const url = `/admin/delete/variant/${variantId}`; // Dynamic URL construction

           
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
                        type: "DELETE",
                        url: url,
                        data: {
                            variant_id: variantId
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        success: function(response) {
                            if(response.success == true) {
                                $('#alert-container2').html(`
                                    <div class="alert alert-success">
                                        ${response.message}
                                    </div>
                                `);
                                $(`tr[data-variant-id="${variantId}"]`).remove();
                            } else {
                                $('#alert-container2').html(`
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
                            $('#alert-container2').html(`
                                <div class="alert alert-danger">
                                    ${errorHtml}
                                </div>
                            `);
                        }
                    });
                }
            });
            
        });
    });
   
   //CREATE PRODOCT VARIANT
   $(document).ready(function () {
        $('#addVariantBtn').on('click', function() {
            $('#createVariantForm')[0].reset(); // Reset form data
            const productId = this.getAttribute('data-id');
            const productTitle = this.getAttribute('data-title');
            $('#variant_product_id').val(productId);
            $('#variant_product_title').val(productTitle);

            $('#createVariantModal').modal('show');
        });
    });

    $('#cancelCreateProductVariantBtn').on('click', function () {
        $('#createVariantModal').modal('hide');
    });

    $("#createVariantForm").submit(function(e) {
        const url = `{{ route('admin.create.variant') }}`;
        var form = $(this);
        var formData = form.serialize(); // Serialize the form data
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                if(response.success == true) {
                    $('#alert-container2').html(`
                        <div class="alert alert-success">
                            ${response.message}
                        </div>
                    `);
                    $('#createVariantModal').modal('hide');
                    const newRow = `
                        <tr class="text-center" data-variant-id="${response.id}">
                            <td>${response.id}</td>
                            <td>${response.color}</td>
                            <td>${response.size}</td>
                            <td>${response.stock}</td>
                            <td>
                                <button  class="btn btn-info rounded adjust-btn" data-id="${response.id}">
                                    <i class="fas fa-cogs"></i> Adjust Stock
                                </button>

                                <button class="btn btn-warning rounded edit-btn" title="Edit Variant Data" data-id="${response.id}" data-productid="${response.product_id}" data-color="${response.color}" data-size="${response.size}}" >
                                    <i class="fas fa-edit"></i> 
                                </button>
                                                                   
                               <button class="btn btn-danger rounded variantDelete-btn" title="Delete Variant Data" data-id="${response.id}"  >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    // Append the new row to the table body
                    $('#variants-table tbody').append(newRow);
                } else {
                    $('#alert-container2').html(`
                        <div class="alert alert-danger">
                            Something went wrong. Please try again.
                        </div>
                    `);
                    $('#createVariantModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $('#createVariantModal').modal('hide');
                const errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                for (let field in errors) {
                    errorHtml += `<li>${errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
                $('#alert-container2').html(`
                    <div class="alert alert-danger">
                        ${errorHtml}
                    </div>
                `);
            }
        });
    });
   </script>
@endsection
