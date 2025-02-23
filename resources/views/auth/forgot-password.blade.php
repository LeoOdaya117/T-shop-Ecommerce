@extends('layouts.auth')
@section('title', 'Forgot Password')
@section("content")
<!-- forgot password  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center">
                <a href="{{ route("home") }}">
                    <div class="logo-img">
                        <i class="fa-solid fa-cart-shopping fa-lg "> T-Shop</i>
                    </div>
                </a>
                <span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
                <form method="get" action="{{ route('forgot.password.otp') }}">
                    <p>Don't worry, we'll send you an otp to reset your password.</p>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="email" name="email" required="" placeholder="Your Email" autocomplete="off">
                    </div>
                    <div class="form-group pt-1"><button class="btn btn-block btn-primary btn-xl" type="submit" >Send OTP</button></div>
                </form>
            </div>
            <div class="card-footer text-center">
                <span>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></span>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end forgot password  -->
@endsection()