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
                        <i class="fa-solid fa-cart-shopping fa-lg"> T-Shop</i>
                    </div>
                </a>
                <span class="splash-description">Enter the OTP sent to your email.</span>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    @csrf
                    <p>We've sent you a one-time password (OTP) to reset your password.</p>
                  
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="otp" required placeholder="Enter OTP" autocomplete="off">
                    </div>
                    <div class="form-group pt-1">
                        <button type="submit" class="btn btn-block btn-primary btn-xl">Verify OTP</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <span>Didn't receive an OTP? <a href="">Resend OTP</a></span>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end forgot password  -->
@endsection