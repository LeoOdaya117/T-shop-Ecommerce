@extends('admin.layouts.default')
@section('title', 'Dashboard')
@section('content')
    <main >
         <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Overview </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Sales Dashboard</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Revenue</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="total-revenue">Loading...</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Sales</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="total-sales">Loading...</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Orders</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="customer-count">Loading...</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Customers</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="total-customers">Loading...</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <!-- ============================================================== -->
                            <!-- end total orders  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Recent Orders</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="text-center">
                                                        <th class="">#</th>
                                                        <th class="">Order ID</th>
                                                        <th class="">Total Price</th>
                                                        <th class="">Customer</th>
                                                        <th class="">Order Time</th>
                                                        <th class="">Status</th>
                                                        <th class="">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($recentOrders->count() > 0)
                                                        @foreach ($recentOrders as $recentOrder)
                                                            <tr class="text-center" data-order-id="{{  $recentOrder->id  }}">
                                                                <td>{{ $loop->iteration }}</td>
                                                                
                    
                                                                <td>{{ $recentOrder->id }}</td>
                                                                <td>₱ {{ $recentOrder->total_price }}</td>
                                                                <td>{{ $recentOrder->fname }} {{ $recentOrder->lname }}</td>
                                                                <td>{{ $recentOrder->created_at }}</td>

                                                                <td class="
                                                                    @if ($recentOrder->order_status == "Delivered")
                                                                        text-success
                                                                    @elseif($recentOrder->order_status == "Order Placed")
                                                                    text-info
                                                                    @elseif($recentOrder->order_status == "Pending")
                                                                    text-warning
                                                                    @elseif($recentOrder->order_status == "Shipped")
                                                                    text-primary
                                                                    @else
                                                                        text-danger
                                                                    @endif
                                                                ">{{ $recentOrder->order_status }}</td>
                                                                <td>
                                                                    <button class="btn  btn-sm btn-success" onclick="orderStatus('{{ $recentOrder->id }}','Processing')">Accept</button>
                                                                    <button class="btn  btn-sm btn-danger" onclick="orderStatus('{{ $recentOrder->id }}','Cancelled')">Decline</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr >
                                                            <td colspan="6" class="text-center">
                                                                <p>No data found</p>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                   
                                                    
                                                   
                                                    <tr>
                                                        <td colspan="9"><a href="{{ route('admin.orders') }}" class="btn btn-outline-light float-right">View Details</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->

    
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                            {{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Customer Acquisition</h5>
                                    <div class="card-body">
                                        <div class="ct-chart ct-golden-section" style="height: 354px;"></div>
                                        <div class="text-center">
                                            <span class="legend-item mr-2">
                                                    <span class="fa-xs text-primary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">Returning</span>
                                            </span>
                                            <span class="legend-item mr-2">

                                                    <span class="fa-xs text-secondary mr-1 legend-tile"><i class="fa fa-fw fa-square-full"></i></span>
                                            <span class="legend-text">First Time</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- ============================================================== -->
                            <!-- end customer acquistion  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Revenue by Category</h5>
                                    <div class="card-body">
                                        <canvas id="revenueByCategoryChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->
                            

                            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Total Revenue</h5>
                                    <div class="card-body">
                                        <div id="morris_totalrevenue"></div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="display-7 font-weight-bold"><span class="text-primary d-inline-block" id="thisYearRevenue">Loading...</span><span class="text-success float-right" id="revenueGrowth">Loading...</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                           
                            <!-- ============================================================== -->
                            
                        </div>


                        
                        
                    </div>
                </div>
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>

    <script>
        window.routeUrls = {
            getSalesAndRevenue: "{{ route('admin.getSalesAndRevenue') }}",
            orderStatus:  "{{ route('admin.orders.orderStatus') }}"
           
        };
        window.pusherCredentials = {
            appKey: "{{ env('PUSHER_APP_KEY') }}",
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        };
        
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}">

      
        
    </script>
    

@endsection()
                                