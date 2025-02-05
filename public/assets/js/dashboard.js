var revenueByCategoryChart; // Declare globally


// Get Pusher credentials from the server (Laravel Blade syntax)
var pusherAppKey = window.pusherCredentials.appKey;
var pusherCluster = window.pusherCredentials.cluster;

Pusher.logToConsole = true;
 
// Initialize Pusher with the credentials from .env
var pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    forceTLS: true
});

// Subscribe to the 'dashboard' channel
var channel = pusher.subscribe('dashboard');

// Listen for subscription success
channel.bind('pusher_internal:subscription_succeeded', function() {
    console.log('Successfully subscribed to the dashboard channel.');
});

// Bind to the 'DashboardDataUpdated' event
channel.bind('App\\Events\\DashboardDataUpdated', function(data) {
    console.log('Received DashboardDataUpdated event: ', data);

    // Update the DOM with the real-time data
    document.getElementById('customer-count').innerText = data.total_customer;
    document.getElementById('total-revenue').innerText = '₱ ' + data.total_revenue.toFixed(2);
    document.getElementById('total-sales').innerText = data.total_sales;
    document.getElementById('total-customers').innerText = data.total_customer;
    $('#customer-count').text(data.total_orders);
    $('#total-revenue').text('₱ ' + data.total_revenue.toFixed(2));
    $('#total-sales').text(data.total_sales);
    $('#total-customers').text(data.total_customer);
    // Render the charts
    renderRevenueByCategory(data.categories, data.revenues);
    renderTotalSales(data.revenue_by_year);
    console.log(data.revenue_by_year);
    
});

// Function to fetch data every 5 seconds
function fetchData() {
    $.ajax({
        url: window.routeUrls.getSalesAndRevenue, // Your route to the getSalesAndRevenue function
        method: 'GET',
        success: function(response) {
            // Update the DOM with the data received
            $('#customer-count').text(response.total_orders);
            $('#total-revenue').text('₱ ' + response.total_revenue.toFixed(2));
            $('#total-sales').text(response.total_sales);
            $('#total-customers').text(response.total_customer);

            // Render the charts
            renderRevenueByCategory(response.categories, response.revenues);
            renderTotalSales(response.revenue_by_year);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred while fetching data: ", error);
        }
    });
}

// Helper function to generate a random color
function randomColor() {
    return 'rgba(' + Math.floor(Math.random() * 156 + 100) + ',' + Math.floor(Math.random() * 156 + 100) + ',' + Math.floor(Math.random() * 156 + 100) + ', 1)';
}

// Function to render Revenue by Cateogry
function renderRevenueByCategory(categories, revenues) {
    if (revenueByCategoryChart) {
        revenueByCategoryChart.destroy(); // Destroy the old chart instance
    }

    var backgroundColors = categories.map(() => randomColor());
    var borderColors = categories.map(() => randomColor());

    var ctx = document.getElementById('revenueByCategoryChart').getContext('2d');
    revenueByCategoryChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categories,
            datasets: [{
                label: 'Revenue by Category',
                data: revenues,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
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

// Declare morrisTotalRevenueChart outside the function to keep track of the chart instance
var morrisTotalRevenueChart = null;

// Function to render total sales
function renderTotalSales(data) {
    // Clear the chart container before reinitializing
    $('#morris_totalrevenue').empty(); // This clears the content of the container

    // Prepare the data for the chart
    var morrisData = data.map(item => {
        return {
            x: item.year.toString(), // Use the year as 'x' value
            y: item.total_revenue.toFixed(2) // Use the total revenue as 'y' value
        };
    });

    // Destroy the existing chart if it exists
    if (morrisTotalRevenueChart && typeof morrisTotalRevenueChart.destroy === 'function') {
        morrisTotalRevenueChart.destroy();
    }

    // Initialize Morris Area Chart with the formatted data
    morrisTotalRevenueChart = Morris.Area({
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



// Function to handle order status update
function orderStatus(orderId, status) {
    $.ajax({
       
        url: window.routeUrls.orderStatus,
        method: 'PUT',
        data: {
            order_id: orderId,
            order_status: status
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
        },
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: response.message,
            });
            $(`tr[data-order-id="${response.order_id}"]`).remove();
        },
        error: function(xhr, status, error) {
            console.error("An error occurred while accepting the order: ", error);
        }
    });
}

// Call fetchData to populate initial data
fetchData();