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
                                <h2 class="pageheader-title">Category </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}" class="breadcrumb-link">Category</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.categories') }}" class="breadcrumb-link">Category list</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
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
                               Edit {{ $categoryInfo->name }}
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                                    
                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.update.product', $categoryInfo->id) }}" method="POST" style="color: black;" id="productUpdateForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row  g-0">
                                            
                                            <div class="col-3">
                                                <div class="row d-block">
                                                    <div class="col">
                                                        <h5 for="inputText3" class="col-form-label">Product Image</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <img class="border border-dark" id="image-container" src="{{ $categoryInfo->image ?? asset('assets/image/no-product-image.png')}}" alt="{{ $categoryInfo->name }}" height="200" width="auto">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                                   
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Title</label>
                                                    <input name="name" id="name"  type="text" class="form-control" value="{{ $categoryInfo->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Slug</label>
                                                    <input readonly name="slug" id="slug" type="text" class="form-control" value="{{ $categoryInfo->slug }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active" {{ $categoryInfo->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $categoryInfo->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Image URL</label>
                                                    <input name="image" id="image-url"  type="text" class="form-control" value="{{ $categoryInfo->image }}" placeholder="Image URL">

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
            <p>Are you sure you want to update this category? This action cannot be undone.</p>
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
            url: "{{ route('admin.update.category', $categoryInfo->id) }}",
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

