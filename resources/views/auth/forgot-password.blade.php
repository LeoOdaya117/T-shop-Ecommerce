@extends('layouts.auth')
@section('title', 'Forgot Password')
@section("content")

<!-- Email Input Form (Step 1) -->
<div class="splash-container" id="emailForm">
    <div class="card">
        <div class="card-header text-center">
            <a href="{{ route('home') }}">
                <div class="logo-img">
                    <i class="fa-solid fa-cart-shopping fa-lg"> T-Shop</i>
                </div>
            </a>
            <span class="splash-description">Please enter your email.</span>
        </div>
        <div class="card-body">
            <form id="sendOtpForm">
                @csrf
                <p>Don't worry, we'll send you an OTP to reset your password.</p>
                <div id="alert-container1"></div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" id="email" required placeholder="Your Email" autocomplete="off">
                </div>
                <div class="form-group pt-1">
                    <button class="btn btn-block btn-primary btn-xl" type="submit" id="sendOtpBtn">Send OTP</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OTP Verification Form (Step 2) -->
<div class="splash-container d-none" id="otpForm">
    <div class="card">
        <div class="card-header text-center">
            <a href="{{ route('home') }}">
                <div class="logo-img">
                    <i class="fa-solid fa-cart-shopping fa-lg"> T-Shop</i>
                </div>
            </a>
            <span class="splash-description">Enter the OTP sent to your email.</span>
        </div>
        <div class="card-body">
            <div id="alert-container2"></div>
            <form id="verifyOtpForm">
                @csrf
                <input type="hidden" name="email" id="otpEmail">
                <p>We've sent you a one-time password (OTP) to reset your password.</p>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="otp" id="otp" required placeholder="Enter OTP" autocomplete="off">
                </div>
                <div class="form-group pt-1">
                    <button type="submit" class="btn btn-block btn-primary btn-xl" id="verifyOtpBtn">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Reset Form (Step 3) -->
<form class="splash-container d-none" id="resetPasswordForm">
    @csrf
    <input type="hidden" name="email" id="resetEmail">
    <input type="hidden" name="otp" id="resetOtp">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1">Update Password</h3>
            <p>Please enter your new password.</p>
        </div>
        <div class="card-body">
            <div id="alert-container3"></div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="password" type="password" name="password" required placeholder="Password">
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="confirm-password" type="password" name="password_confirmation" required placeholder="Confirm Password">
            </div>
            <div class="form-group pt-2">
                <button class="btn btn-block btn-primary" type="submit" id="resetPasswordBtn">Update Password</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.routeUrls = {
        sendOtp: "{{ route('forgot.password.send.otp') }}",
        verifyOtp: "{{ route('forgot.password.verify') }}",
        resetPassword: "{{ route('forgotpassword.post') }}",
        login: "{{ route('login') }}"
    };
</script>
<script src="{{ asset('assets/js/forgotpassword.js') }}"></script>
@endsection
