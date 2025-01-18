@extends('admin.layouts.default')
@section('title', 'Products')
@section('style')

@endsection
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
                                <h2 class="pageheader-title">Products </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Products</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Product List</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
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
                               Product Form
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                                    {{-- @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif --}}

                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.product.create') }}" method="POST" id="createProductForm" style="color: black;">
                                        @csrf
                                        @method('POST')
                                        <div class="row ">
                                            
                                            <div class="col">
                                                <div class="row d-block">
                                                    <div class="col">
                                                        <h5 for="inputText3" class="col-form-label">Product Image</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <img class="border border-dark" id="image-container" src="{{ asset('assets/image/no-product-image.png') }}" alt="" height="200" width="100%">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input name="image" id="image-url"  type="text" class="form-control" " placeholder="Image URL">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Title</label>
                                                            <input name="title" id="title"  type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Slug</label>
                                                            <input name="slug" id="slug"  type="text" class="form-control" readonly>
                                                        </div>
                                                       
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Price</label>
                                                    <input name="price" type="text" class="form-control" placeholder="0.00">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Category</label>
                                                    <select name="category" class="form-control" id="input-select">
                                                        <option selected disabled>Choose Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" >
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Brand</label>
                                                    <select name="brand" class="form-control" id="input-select">
                                                        <option selected disabled>Choose Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}" >
                                                                {{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Color</label>
                                                    <input name="color"  type="text" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Size</label>
                                                    <select name="size" class="form-control">
                                                        <option selected disabled>Choose Size</option>
                                                        <option value="S" >Small</option>
                                                        <option value="M" >Medium</option>
                                                        <option value="L" >Large</option>
                                                        <option value="XL" >XL</option>
                                                        <option value="XXL" >XXL</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option selected disabled>Choose Status</option>
                                                        <option value="active" >Active</option>
                                                        <option value="inactive" >Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Discount</label>
                                                    <input name="discount" type="text" class="form-control" placeholder="0.00" value="0">
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Description</label>
                                                    <textarea class="form-control" name="description" rows="9"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success rounded" type="button" id="openModal">Save</button>

                                        </div>
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

    @include('partials.modal', [
        'id' => 'createConfirmation',
        'title' => 'Create Product Confirmation',
        'body' => '
            <p>Are you sure you want to save this product? This action cannot be undone.</p>
        ',
        'footer' => '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-warning" id="confirmSave">Yes</button>
        ',
    ])
    
@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery --> --}}

    <script>

        $('#openModal').on('click', function () {
            console.log('Modal open button clicked');
            $('#createConfirmation').modal('show');
        });
       
        $('#image-url').on('change', function () {
            const newImageUrl = $(this).val();
            $('#image-container').attr('src', newImageUrl || "{{ asset('assets/image/no-product-image.png') }}");
        });

        $('#title').on('change', function () {
            const newTitle = $(this).val();
            $('#slug').val(newTitle ? createSlug(newTitle) : '');
        });

        function createSlug(title) {
            return title
                .trim()
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with dashes
                .replace(/-+/g, '-'); // Collapse multiple dashes
        }

        $('#confirmSave').on('click', function () {
            const form = $('#createProductForm');
            const formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#alert-container').html(`
                        <div class="spinner-border text-primary"></div> Saving...
                    `);
                },
                success: function (response) {
                    $('#alert-container').html(`
                        <div class="alert alert-success">
                            Product updated successfully!
                        </div>
                    `);
                    $('#createConfirmation').modal('hide');
                    form.trigger('reset');
                },
                error: function (xhr) {
                    $('#createConfirmation').modal('hide');
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
                },
            });
        });




   </script>
   
@endsection

