<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "T-shop")</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/image/cart.png') }}">
    <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    @yield("style")
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

    @yield("content")

    <script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
    @yield("script")

    @if(isset($error))
        console.error("Login failed: {{ $error }}");
    @endif
    
</body>
</html>