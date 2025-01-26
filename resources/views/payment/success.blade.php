@extends('layouts.default')
@section('title', 'T-Shop - Payment Success')
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
            <h1 class="text-success fw-bold" style="font-size: 50px;"><i class="fa-solid fa-check"></i></h1>
            <h1>Payment Successful</h1>
            <p>Thank you for your purchase. Your order is being processed.</p>
            <div class="d-flex gap-1 align-items-center justify-content-center text-center align-content-center">
                
                <p>
                    <a href="{{ route('user.order.tracking', $order_id) }}" class="fw-bold">View Order</a>
                    or 
                    <a href="{{ route('home') }}" class="fw-bold">Continue Shopping</a>
                </p>
                
            </div>
            {{-- <p style="font-size: 13px">Redirecting to the cart in <span id="countdown">10</span> seconds...</p> --}}
        </section>
    </main>
@endsection

@section('script')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
           
            var countdownElement = document.getElementById('countdown');
            var countdown = 10; // Countdown time in seconds

            console.log('Countdown started');

            var interval = setInterval(function () {
                countdown--;
                countdownElement.textContent = countdown;
                console.log('Countdown: ' + countdown);

                if (countdown <= 0) {
                    clearInterval(interval);
                    console.log('Redirecting to cart');
                    window.location.href = "{{ route('cart.show') }}"; // Redirect to the cart page
                }
            }, 1000);
        });
    </script> --}}
@endsection