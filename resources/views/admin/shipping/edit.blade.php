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
                                <h2 class="pageheader-title">Edit Shipping Option</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Shipping</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.shipping') }}" class="breadcrumb-link">Shipping Options</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Edit {{ $shipping_option_info->name }}</li>
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
                               Shipping Option Edit Form
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                            

                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.shipping.update') }}" method="POST" id="updateShippingOption" style="color: black;">
                                        @csrf
                                        @method('PUT')
                                        <div class="row  g-0">
                                            
                                            
                                                   
                                            <div class="col-12">
                                                <div class="form-group" hidden>
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Shipping Option ID</label>
                                                    <input name="id" id="id"  type="number" class="form-control" value="{{ $shipping_option_info->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Shipping Option Name</label>
                                                    <input name="name" id="name"  type="text" class="form-control" value="{{ $shipping_option_info->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Carrier</label>
                                                    <input  name="carrier" id="carrier" type="text" class="form-control"  value="{{ $shipping_option_info->carrier }}">
                                                </div>
                                                
                                                <div class="row gap-3">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Minimum Day</label>
                                                            <input  name="min_days" id="min_days" type="number" class="form-control"  value="{{ $shipping_option_info->min_days }}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Maximum Day</label>
                                                            <input  name="max_days" id="max_days" type="number" class="form-control"   value="{{ $shipping_option_info->max_days }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row gap-3">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Cost</label>
                                                            <input name="cost" id="cost"  type="number" class="form-control"   value="{{ $shipping_option_info->cost }}">
        
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="active" {{ $shipping_option_info->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $shipping_option_info->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                
                                                
                                               
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success rounded" type="submit" id="openModal">Save</button>

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
        'title' => 'Create Category Confirmation',
        'body' => '
            <p>Are you sure you want to save this category? This action cannot be undone.</p>
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

       
        $("#updateShippingOption").submit(function (e) {
            e.preventDefault(); // Prevent page reload
            var form = $(this);
            const formData = new FormData(form[0]);


            // Show SweetAlert confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to update this shipping option?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
                        },
                        beforeSend: function () {
                            $('#alert-container').html(`
                                <div class="spinner-border text-primary m-2"></div> Updating.....
                            `);
                        },
                        success: function (response) {
                            

                            $('#alert-container').html(`
                                <div class="alert alert-success">
                                    ${response.message}
                                </div>
                            `);
                           
                          
                        },
                        error: function (xhr) {
                           
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
                }
            });
        });



   </script>
   
@endsection

