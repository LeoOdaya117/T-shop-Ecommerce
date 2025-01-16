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
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Recent Orders</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">#</th>
                                                        <th class="border-0">Image</th>
                                                        <th class="border-0">Product Name</th>
                                                        <th class="border-0">Product Id</th>
                                                        <th class="border-0">Quantity</th>
                                                        <th class="border-0">Price</th>
                                                        <th class="border-0">Order Time</th>
                                                        <th class="border-0">Customer</th>
                                                        <th class="border-0">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="m-r-10"><img src="assets/images/product-pic.jpg" alt="user" class="rounded" width="45"></div>
                                                        </td>
                                                        <td>Product #1 </td>
                                                        <td>id000001 </td>
                                                        <td>20</td>
                                                        <td>$80.00</td>
                                                        <td>27-08-2018 01:22:12</td>
                                                        <td>Patricia J. King </td>
                                                        <td><span class="badge-dot badge-brand mr-1"></span>InTransit </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="9"><a href="#" class="btn btn-outline-light float-right">View Details</a></td>
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
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
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
                            </div>
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
                            
                            <!-- product sales  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <div class="float-right">
                                                <select class="custom-select">
                                                    <option selected>Today</option>
                                                    <option value="1">Weekly</option>
                                                    <option value="2">Monthly</option>
                                                    <option value="3">Yearly</option>
                                                </select>
                                            </div> -->
                                        <h5 class="mb-0"> Product Sales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="ct-chart-product ct-golden-section"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
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

    <script>
        // Generate a random color for each category
        function randomColor() {
            return 'rgba(' + Math.floor(Math.random() * 156 + 100) + ',' + Math.floor(Math.random() * 156 + 100) + ',' + Math.floor(Math.random() * 156 + 100) + ', 1)';
        }
        $(document).ready(function() {
            // Make the AJAX request
            $.ajax({
                url: "{{ route('admin.getSalesAndRevenue') }}", // Your route to the getSalesAndRevenue function
                method: 'GET',
                success: function(response) {
                    // Update the DOM with the data received
                    $('#customer-count').text(response.total_orders);
                    $('#total-revenue').text('₱ ' + response.total_revenue);
                    $('#total-sales').text(response.total_sales);
                    $('#total-customers').text(response.total_customer);
                    
                    let revenue_by_year = response.revenue_by_year;
                    let categories = response.categories;
                    let revenues = response.revenues;

                    renderRevenueByCategory(categories,revenues);
                    renderTotalSales(revenue_by_year);
                    
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred while fetching data: ", error);
                }
            });
        });

        function renderRevenueByCategory(categories,revenues){
            // Assign random colors for backgroundColor and borderColor
            var backgroundColors = categories.map(() => randomColor());
            var borderColors = categories.map(() => randomColor());
            // Create the chart
            var ctx = document.getElementById('revenueByCategoryChart').getContext('2d');
            var revenueByCategoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Revenue by Category',
                        data: revenues,
                        backgroundColor: backgroundColors,  // Dynamic colors for background
                        borderColor: borderColors,          // Dynamic colors for borders
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ₱' + tooltipItem.raw.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        }

        function renderTotalSales(data){


            var morrisData = data.map(item => {
                return {
                    x: item.year.toString(), // Use the year as 'x' value
                    y: item.total_revenue.toFixed(2)     // Use the total revenue as 'y' value
                };
            });

            // Initialize Morris Area Chart with the formatted data
            Morris.Area({
                element: 'morris_totalrevenue',
                behaveLikeLine: true,
                data: morrisData, // Use the formatted data here
                xkey: 'x',
                ykeys: ['y'],
                labels: ['Revenue'],
                lineColors: ['#5969ff'], // Line color
                resize: true
            });

            // Get the current year data
    const currentYear = new Date().getFullYear();
    const currentYearData = data.find(item => item.year === currentYear);
    const previousYearData = data.find(item => item.year === currentYear - 1);

    // Display the current year's revenue
    if (currentYearData) {
        $('#thisYearRevenue').text("₱ " + currentYearData.total_revenue.toFixed(2));
    } else {
        $('#thisYearRevenue').text("Data not available");
    }

    // Calculate and display growth
    if (currentYearData && previousYearData) {
        const currentRevenue = currentYearData.total_revenue;
        const previousRevenue = previousYearData.total_revenue;

        // Calculate the growth percentage
        const growth = ((currentRevenue - previousRevenue) / previousRevenue) * 100;
        
        // Display the growth as percentage
        $('#revenueGrowth').text(growth >= 0 ? `+${growth.toFixed(2)}%` : `${growth.toFixed(2)}%`);
    } else {
        $('#revenueGrowth').text('Data not available');
    }

        }
    </script>
@endsection()
                                