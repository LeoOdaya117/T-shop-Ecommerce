@extends('layouts.default')
@section('title', 'Order History')
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
    <main class="container  mb-5">
        <section class="pt-3">
            <div class="row d-flex align-items-center align-content-center justify-content-between mb-2 w-auto">
                <div class="col-auto">
                    <h5>Order History</h5>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter by Status
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'all']) }}">All</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'Delivered']) }}">Delivered</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'Shipped']) }}">Shipped</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'Processing']) }}">Processing</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'Cancelled']) }}">Cancelled</a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch" >
                        <div class="card w-100" style="font-size: 0.875rem;"> <!-- Smaller font size -->
                            <div class="card-body d-flex flex-column p-3"> <!-- Smaller padding -->
                                <strong class="card-title" style="font-size: 17px">Order ID # {{ $order->id }}</strong>
                                <hr>
                                <p class="card-text"><strong>Payment ID:</strong> {{ $order->payment_id ?? 'N/A' }}</p>
                                <p class="card-text"><strong>Date:</strong> {{ $order->created_at->format('M d Y h:i A') }}</p>
                                <p class="card-text"><strong>Total Price: ₱ </strong> {{ $order->total_price }}</p>
                                <p class="card-text">
                                    <strong>Status:</strong> 
                                    <span class="
                                        @if($order->order_status == 'Delivered')
                                            bg-success text-white
                                        @elseif($order->order_status == 'Shipped')
                                            bg-info text-dark
                                        @elseif($order->order_status == 'Processing')
                                            bg-warning text-dark

                                        @elseif($order->order_status == 'Cancelled')
                                            bg-danger text-white
                                        @else
                                            bg-secondary text-white
                                        @endif
                                        p-1 rounded
                                    " >
                                        {{ $order->order_status }}
                                    </span>
                                </p>
                                <a href="{{ route('user.order.tracking', $order->id) }}" class="btn btn-info">View</a>
                                {{-- <a href="{{ route('order.details', $order->id) }}" class="btn btn-primary btn-sm mt-auto">View</a> --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            No orders found.
                        </div>
                    </div>
                @endforelse
            </div>
            
        </section>
        <div class="row pt-1">
            <div class="col-12">
                {{ $orders->links('pagination::bootstrap-5') }} <!-- Pagination links -->
            </div>
        </div>
    </main>
@endsection