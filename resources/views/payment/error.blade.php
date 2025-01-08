@extends('layouts.default')
@section('title', 'T-Shop - Payment Unsuccessful')
@section('style')
    <style>
        .full-height {
            height: 90vh;
            display: grid;
            place-items: center;
            text-align: center;
        }

        .content-box {
            max-width: 600px; /* Adjust the width as needed */
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <main class="container full-height">
        <section class="content-box">
            <h1>Payment Unsuccessful</h1>
            <p>We're sorry, but your payment could not be processed at this time.</p>
            <p>Please try again or contact our customer support for assistance.</p>
            <p>If you have any questions, feel free to reach out to us at <a href="mailto:support@example.com">support@example.com</a>.</p>
            {{-- <p style="font-size: 13px">Redirecting to the cart in <span id="countdown">10</span> seconds...</p> --}}
        </section>
    </main>
@endsection

@section('script')
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     var countdownElement = document.getElementById('countdown');
        //     var countdown = 10; // Countdown time in seconds

        //     console.log('Countdown started');

        //     var interval = setInterval(function () {
        //         countdown--;
        //         countdownElement.textContent = countdown;
        //         console.log('Countdown: ' + countdown);

        //         if (countdown <= 0) {
        //             clearInterval(interval);
        //             console.log('Redirecting to cart');
        //             window.location.href = "{{ route('cart.show') }}"; // Redirect to the cart page
        //         }
        //     }, 1000);
        // });
    </script>
@endsection