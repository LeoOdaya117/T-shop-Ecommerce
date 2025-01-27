<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "T-shop")</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/image/cart.png') }}">

  
    {{-- <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <style>
        .card, .btn ,li, image {
            cursor: pointer;
        }
      

        .breadcrumb{
            color: #52a8ff;
            align-items: center;

        }
        .breadcrumb-item + .breadcrumb-item::before {
            content: '＞ ';
 
   
        }
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: whitesmoke;
         
        }
        .content {
            flex: 1;
        }
    </style>
    @yield("style")
</head>
<body>
    @include("includes.header")

    @yield("content")

    @include("includes.footer")

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- bootstap bundle js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Include these in your main layout -->

    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init(
                {
                duration: 1000,
                delay: 150,

            }
            );
            
        });
        
    </script>
    @include("includes.scripts")
    @yield("script")

    {{-- @if(isset($error))
        console.error("Login failed: {{ $error }}");
    @endif --}}
</body>
</html>