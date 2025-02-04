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
                                <h2 class="pageheader-title">Add New Shipping Option</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Shipping</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.shipping') }}" class="breadcrumb-link">Shipping Options</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Add New Shipping Option</li>
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
                               Shipping Option Form
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                            

                                    <div id="alert-container"></div>

                                    <form action="{{ route('admin.shipping.store') }}" method="POST" id="createShippingOption" style="color: black;">
                                        @csrf
                                        @method('POST')
                                        <div class="row  g-0">
                                            
                                            
                                                   
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Shipping Option Name</label>
                                                    <input name="name" id="name"  type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Carrier</label>
                                                    <input  name="carrier" id="carrier" type="text" class="form-control">
                                                </div>
                                                
                                                <div class="row gap-3">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Minimum Day</label>
                                                            <input  name="min_days" id="min_days" type="number" class="form-control"  placeholder="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Maximum Day</label>
                                                            <input  name="max_days" id="max_days" type="number" class="form-control"  placeholder="0">
                                                        </div>
                                                    </div>

                                                </div>

                                                
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">Cost</label>
                                                    <input name="cost" id="cost"  type="number" class="form-control"  placeholder="0.00">

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



@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery --> --}}

    <script>

       
        $("#createShippingOption").submit(function (e) {
            e.preventDefault();
            var form = $(this);
            const formData = new FormData(form[0]);

            // Show SweetAlert confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to save this shipping option?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, save it!"
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
                                <div class="spinner-border text-primary"></div> Saving...
                            `);
                        },
                        success: function (response) {
                            

                            $('#alert-container').html(`
                                <div class="alert alert-success">
                                    ${response.message}
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
                                Swal.fire("Error!", "Something went wrong. Please try again.", "error");
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

