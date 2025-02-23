@extends('layouts.default')
@section('title', 'Order History')
@section('style')
<style>
    
    .btn-menu {
        display: flex;
        align-items: center;
        gap: 10px; /* Space between icon and text */
        padding: 10px;
        width: 100%; /* Full width for menu items */
        background-color: #f8f9fa; /* Light background */
        color: #000; /* Dark text */
        border: 1px solid #ddd; /* Border for separation */
        border-radius: 5px;
        margin-bottom: 5px; /* Spacing between buttons */
        text-align: left; /* Align text to the left */
        font-weight: 500; /* Slightly bold text for visibility */
        transition: background-color 0.3s;
    }
    .btn-menu:hover {
        background-color: #e2e6ea; /* Slightly darker hover effect */
        color: #000;
    }
    .btn-menu i {
        font-size: 18px; /* Icon size */
        color: #6c757d; /* Icon color */
    }

    /* Media query for smaller screens */
    @media (max-width: 768px) {
        .btn-menu {
            font-size: 14px; /* Reduce font size for smaller screens */
            padding: 8px; /* Adjust padding */
        }

        #my-account-menu h5 {
            font-size: 16px; /* Reduce heading size */
        }
    }
</style>
@endsection
@section('content')

<main class="container pt-5 mb-5">
    <section class="pt-4">
        <div class="container">
            <h3>My Account</h3>
            <div class="row justify-content-center align-items-start g-3">
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="container p-3">
                            <div class="card-body d-flex flex-column text-start" id="my-account-menu">
                                <h5>Welcome, {{ auth()->user()->name }}</h5>
                                <a class="btn btn-menu" href="{{ route('user.profile') }}">
                                    <i class="fa-solid fa-user"></i> Profile
                                </a>
                                <a class="btn btn-menu" href="{{ route('order.history') }}">
                                    <i class="fa-solid fa-box"></i> Orders
                                </a>
                                <a class="btn btn-menu" href="{{ route('user.wishlist') }}">
                                    <i class="fa-solid fa-heart"></i> Wishlist
                                </a>
                              
                                <a class="btn btn-menu" href="{{ route('user.change-password') }}">
                                    <i class="fa-solid fa-key"></i> Change Password
                                </a>
                                <a class="btn btn-menu" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <!-- Content for the right column -->
                    <div class="card p-3">
                        @yield('my-account')
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function route(routeUrl) {
        window.location.href = routeUrl;
    }
</script>
@endsection
