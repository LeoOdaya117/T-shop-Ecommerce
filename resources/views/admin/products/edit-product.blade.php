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

                                    <form action="{{ route('admin.update.product', $productInfo->id) }}" method="POST" style="color: black;" id="productUpdateForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row  g-0">
                                            
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
                                                            <input name="image" id="image-url"  type="text" class="form-control" value="{{ $productInfo->image }}" placeholder="Image URL">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Title</label>
                                                            <input name="title" id="title"  type="text" class="form-control" value="{{ $productInfo->title }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Slug</label>
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
                                                    <label for="inputText3" class="col-form-label">Color</label>
                                                    <input name="color"  type="text" class="form-control" value="{{ $productInfo->color }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Size</label>
                                                    <select name="size" class="form-control">
                                                        <option value="S" {{ $productInfo->size == 'S' ? 'selected' : '' }}>S</option>
                                                        <option value="M" {{ $productInfo->size == 'M' ? 'selected' : '' }}>M</option>
                                                        <option value="L" {{ $productInfo->size == 'L' ? 'selected' : '' }}>L</option>
                                                        <option value="XL" {{ $productInfo->size == 'XL' ? 'selected' : '' }}>XL</option>
                                                        <option value="XXL" {{ $productInfo->size == 'XXL' ? 'selected' : '' }}>XXL</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                
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
   </script>
@endsection

