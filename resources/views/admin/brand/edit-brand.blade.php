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
                                <h2 class="pageheader-title">Brands </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Products</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.brands') }}" class="breadcrumb-link">Brands List</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit Brand</li>
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
                                Edit {{ $brandInfo->name }}
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                            

                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.update.brand', $brandInfo->id) }}" method="POST" id="UpdateBrandForm" style="color: black;">
                                        @csrf
                                        @method('PUT')
                                        <div class="row  g-0">
                                            
                                            <div class="col-3">
                                                <div class="row d-block">
                                                    <div class="col">
                                                        <h5 for="inputText3" class="col-form-label">Brand Image</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <img class="border border-dark" id="image-container" src="{{ $brandInfo->image ?? asset('assets/image/no-product-image.png')}}" alt="" height="200" width="200">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                                   
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Brand Name</label>
                                                    <input name="name" id="name"  type="text" class="form-control" value="{{ $brandInfo->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Slug</label>
                                                    <input readonly name="slug" id="slug" type="text" class="form-control" value="{{ $brandInfo->slug }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active" {{ $brandInfo->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $brandInfo->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Image URL</label>
                                                    <input name="image" id="image-url"  type="text" class="form-control"  placeholder="Image URL" value="{{ $brandInfo->image }}">

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
        'title' => 'Update Brand Confirmation',
        'body' => '
            <p>Are you sure you want to save this brand? This action cannot be undone.</p>
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
           
            $('#createConfirmation').modal('show');
        });
       
        $('#image-url').on('change', function () {
            const newImageUrl = $(this).val();
            $('#image-container').attr('src', newImageUrl || "{{ asset('assets/image/no-product-image.png') }}");
        });

        $('#name').on('change', function () {
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
            const form = $('#UpdateBrandForm');
            const formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#alert-container').html(`
                        <div class="spinner-border text-primary">
                            Saving...</div> 
                    `);
                },
                success: function (response) {
                    $('#alert-container').html(`
                        <div class="alert alert-success">
                            ${response.success}
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

