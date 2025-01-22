@if (!auth()->user()->is_admin)
    <script>
       
        window.location.href = "{{ route('home') }}";
    </script>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
   

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link href="{{ asset('admin/assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
 
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/datatables/css/select.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/vendor/datatables/css/fixedHeader.bootstrap4.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- DATA TABLES CSS
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css"> --}}
    <style>

        .col-form-label{
            color: black;
        }
    </style>
    <title>T-SHOP ADMIN</title>
</head>
<body>
    <div class="dashboard-main-wrapper">
        @include("admin.includes.header")
        @include("admin.includes.sidebar")
        @yield("content")
    </div>
    
    


        <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    {{-- DATA TABLES JS LINKS
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script> --}}


 
    <script src="{{ asset('admin/assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- bootstap bundle js -->
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>




    <!-- slimscroll js -->
    <script src="{{ asset('admin/assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('admin/assets/libs/js/main-js.js') }}"></script>
    <!-- chart chartist js -->
    <script src="{{ asset('admin/assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <!-- sparkline js -->
    <script src="{{ asset('admin/assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- morris js -->
    <script src="{{ asset('admin/assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <!-- chart c3 js -->
    <script src="{{ asset('admin/assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/js/dashboard-ecommerce.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    {{-- BASIC TABLE --}}
    <script src="{{ asset('admin/assets/vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>


     @yield('script')
</body>
</html>