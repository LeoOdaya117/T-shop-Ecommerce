<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "T-shop")</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/image/cart.png') }}">
    <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/libs/css/style.css">
    <link rel="stylesheet" href="admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
    @yield("style")
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

    @yield("content")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
    @yield("script")

    {{-- @if(isset($error))
        console.error("Login failed: {{ $error }}");
    @endif --}}
    
</body>
</html>