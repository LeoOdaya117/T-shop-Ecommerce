@extends('layouts.default')
@section('title', 'Order History')
@section('style')
    <style>
       .date {
            font-size: 11px;
            color: #555;
        }

        .progress-container {
            position: relative;
            width: 100%;
            height: 4px;
            background-color: #ddd;
            margin: 20px 0;
        }

        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background-color: green;
            transition: width 0.3s ease;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin: 0 10px;
            background-color: #ddd;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }

        .dot.active {
            background-color: green;
        }

        .big-dot {
            height: 25px;
            width: 25px;
            margin: 0 10px;
            background-color: green;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .big-dot i {
            font-size: 12px;
            color: white;
        }

        .label {
            font-size: 12px;
            color: #555;
            text-align: center;
        }
        .table td, .table th {
    white-space: nowrap; /* Prevent text wrapping */
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

    </style>
@endsection
@section('content')
    <div class="bg-dark text-light">
        <div class=" container ">
            <nav aria-label="breadcrumb" class="pt-5 mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" onclick="route('{{ route('home') }}')">Home</li>
                    <li class="breadcrumb-item" onclick="route('{{ route('order.history',['status'=> 'all']) }}')">Order History</li>
                    <li class="breadcrumb-item active" aria-current="page">Track Order</li>

                </ol>
            </nav>
            
        </div>
    </div>
    <main class="container mb-5">
        <section class="pt-3">
            <div class="container mb-3">
                <h2>Order #<span id="order_id">{{ $order->id }}</span></h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5>Order Tracking #: <span id="tracking_number">{{ $order->tracking_id }}</span></h5>
                            </div>
                            <div class="card-body">
                                
                                    

                                <div class="bg-white p-2 border rounded px-3">
                                    @php
                                        // Get the latest track record
                                        $latestTrack = $order->tracking->sortByDesc('updated_at')->first();
                                    @endphp
                                    
                                    @if ($latestTrack)
                                        <div class="d-flex flex-row justify-content-between align-items-center order">
                                            <div class="d-flex flex-column order-details">
                                                <span>Your Order has been {{ $latestTrack->status }}</span>
                                                <span class="date">
                                                    @if($latestTrack->updated_at)
                                                        {{ $latestTrack->updated_at->format('d M, Y') }}
                                                    @else
                                                        No update date available
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="tracking-details">
                                                @php
                                                    // Define button classes based on status
                                                    $buttonClass = match($latestTrack->status) {
                                                        'Delivered' => 'btn-outline-success',
                                                        'Shipped' => 'btn-outline-info',
                                                        'Processing' => 'btn-outline-warning',
                                                        'Cancelled' => 'btn-outline-danger',
                                                        default => 'btn-outline-secondary',
                                                    };
                                    
                                                    // Define button label based on status
                                                    $buttonLabel = $latestTrack->status;
                                                @endphp
                                    
                                                <button class="btn {{ $buttonClass }} btn-sm fw-bold" type="button">{{ $buttonLabel }}</button>
                                            </div>
                                        </div>
                                        <hr class="divider mb-4">
                                    @else
                                        <p>No tracking information available.</p>
                                    @endif
                                    @php
                                        $steps = ['Order Placed', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered'];
                                        $latestTrack = $order->tracking->sortByDesc('updated_at')->first();
                                        $latestStatus = $latestTrack->status ?? null;

                                        $currentStepIndex = array_search($latestStatus, $steps);
                                        $progressPercentage = $currentStepIndex !== false
                                            ? (($currentStepIndex / (count($steps) - 1)) * 100)
                                            : 0;

                                        $dates = $order->tracking->pluck('updated_at', 'status')->toArray();
                                    @endphp

                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: {{ $progressPercentage }}%;"></div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        @foreach ($steps as $index => $step)
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="dot {{ $index <= $currentStepIndex ? 'active' : '' }} {{ $index === $currentStepIndex ? 'big-dot' : '' }}">
                                                    @if ($index === $currentStepIndex)
                                                        <i class="fa fa-check"></i>
                                                    @endif
                                                </span>
                                                <span class="label">{{ $step }}</span>
                                                <span class="date">
                                                    {{ isset($dates[$step]) ? \Carbon\Carbon::parse($dates[$step])->format('d M, Y') : '' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">

                        {{-- Shipping INFORMATION --}}
                        <div class="card mb-2">
                            <div class="card-body">
                                <div
                                    class="row justify-content-center align-items-center g-2"
                                >
                                    <div class="col">
                                        <p class="m-0 text-muted"><strong>Shipping Address</strong></p>
                                        <p class="m-0">{{ $order->fname }} {{ $order->lname }}</p>
                                        <p class="m-0">{{ $order->phone ?? 'N/A'}}</p>
                                        <p class="m-0">{{ $order->address }} 
                                            @if ($order->address2)
                                                {{ $order->address2 }}
                                            @endif
                                            {{ $order->city }}, {{ $order->state }} {{ $order->pincode }} {{ $order->country }}
                                        </p>
                                    </div>
                                    
                                </div>
                                
                               
                            </div>
                        </div>

                        {{-- PAYMENT INFORMATION --}}
                        <div class="card mb-2">
                            <div class="card-body">
                                <!-- Customer Info -->
                                <div
                                    class="row justify-content-center align-items-center g-2"
                                >
                                    <div class="col">
                                        <p class="m-0 text-muted"><strong>Payment Information</strong></p>
                                        <p class="m-0 ">Payment ID: {{ $order->payment_id ?? 'N/A' }}</p>
                                        <p class="m-0 ">Payment Method: {{ $order->payment_method ?? 'N/A' }}</p>
                                        <p class="m-0">Status: {{ $order->payment_status ?? 'N/A'  }}</p>
                                        @if ($order->payment_status == 'Complete')
                                            <p class="m-0">Paid Date:     
                                                {{ $order->payment_date ? \Carbon\Carbon::parse($order->payment_date)->format('M d, Y h:i A') : 'N/A' }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                                
                            </div>
                        </div>
                        {{-- ORDERED ITEMS --}}
                        <div class="card">
                            <div class="container-fluid table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ordered_items as $item)
                                            <tr>
                                                <td class="d-flex align-items-start gap-2">
                                                    <img
                                                        src="{{ $item['image'] }}"
                                                        class="img-fluid rounded"
                                                        alt="Product Image"
                                                        width="50px"
                                                        height="50px"
                                                        style="object-fit: cover;"
                                                    />
                                                    <div class="text-start">
                                                        <span class="fw-bold">{{ $item['product_name'] }}</span>
                                                        <p class="mb-0 text-muted d-flex gap-1">
                                                            <small>{{ $item['variant']['color'] ?? '' }}</small><br>
                                                            <small>{{ $item['variant']['size'] ?? '' }}</small>
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">₱ {{ number_format($item['price'], 2) }}</td>
                                                <td class="text-center align-middle">{{ $item['quantity'] }}</td>
                                                <td class="text-center align-middle">₱ {{ number_format($item['subtotal'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-end fw-bold">Subtotal:</td>
                                            <td class="text-end">₱ {{ number_format($order->total_price - $order->shipping_fee, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-end fw-bold">Shipping:</td>
                                            <td class="text-end">₱ {{ number_format($order->shipping_fee, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-end"><h5>Grand Total:</h5></td>
                                            <td class="text-end"><h5>₱ {{ number_format($order->total_price, 2) }}</h5></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
