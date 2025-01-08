@extends('layouts.default')
@section('title', 'Order History')
@section('content')
    <main class="container w-75 mb-5">
        <section class="pt-5">
            <div class="row pt-4 d-flex align-items-center align-content-center justify-content-between mb-2 w-auto">
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
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'completed']) }}">Completed</a></li>
                            <li><a class="dropdown-item" href="{{ route('order.history', ['status' => 'cancelled']) }}">Cancelled</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-md-4 mb-4 d-flex align-items-stretch">
                        <div class="card" style="font-size: 0.875rem;"> <!-- Smaller font size -->
                            <div class="card-body p-2"> <!-- Smaller padding -->
                                <strong class="card-title">Order ID: {{ $order->id }}</strong>
                                <p class="card-text"><strong>Payment ID:</strong> {{ $order->payment_id }}</p>
                                <p class="card-text"><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                                <p class="card-text"><strong>Total Price: ₱ </strong> {{ $order->total_price }}</p>
                                <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-primary btn-sm">View</a>
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
            <div class="row pt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }} <!-- Pagination links -->
                </div>
            </div>
        </section>
    </main>
@endsection