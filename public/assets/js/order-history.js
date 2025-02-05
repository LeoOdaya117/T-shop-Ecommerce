function route(routeUrl) {
    window.location.href = routeUrl;
}
$("#cancelOrderForm").submit(function(e) {
   
    var form = $(this);
    var formData = form.serialize(); // Serialize the form data
    var url = form.attr('action'); 
    e.preventDefault();
    $.ajax({
        type: "PUT",
        url: url,
        data: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
            if(response.success == true) {
                $('#alert-container').html(`
                    <div class="alert alert-success">
                        ${response.message}
                    </div>
                `);
               location.reload();
                // $(`tr[data-variant-id="${variantId}"] td:nth-child(2)`).text(color);
                // $(`tr[data-variant-id="${variantId}"] td:nth-child(3)`).text(size);

            } else {
                $('#alert-container').html(`
                    <div class="alert alert-danger">
                        Something went wrong. Please try again.
                    </div>
                `);
               
            }
        },
        error: function(xhr, status, error) {
           
            const errors = xhr.responseJSON.errors;
            let errorHtml = '<ul>';
            for (let field in errors) {
                errorHtml += `<li>${errors[field][0]}</li>`;
            }
            errorHtml += '</ul>';
            $('#alert-container').html(`
                <div class="alert alert-danger">
                    ${errorHtml}
                </div>
            `);
        }
    });
});

let orderData = null;
$('.writeReviewBtn').on('click',function(){
    orderData = $(this).data('order');
    
    // alert('ORDER ID: '+ orderData.id + "PRODUCT ID: "+ orderData.product_id);
    $('#submitReviewModal').modal('show');

});   
$(document).ready(function() {
    var rating = 0; // Initialize rating to 0
   
    // Hover effect for stars
    $('.submit_star').on('mouseenter', function() {
        var rating = $(this).data('rating');
        for (var i = 1; i <= rating; i++) {
            $('#submit_star_' + i).addClass('text-warning'); // Highlight stars on hover
        }
    });

    

    // Set the rating when a star is clicked
    $('.submit_star').on('click', function() {
        rating = $(this).data('rating'); // Save the rating value
        for (var i = 1; i <= 5; i++) {
            $('#submit_star_' + i).removeClass('text-warning'); // Reset all stars
        }
        for (var i = 1; i <= rating; i++) {
            $('#submit_star_' + i).addClass('text-warning'); // Highlight selected stars
        }
        $('#rate').val(rating); // Set the value of the input
    });

    $('#productReviewForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);  // 'this' refers to the form element

        // Create a new array to hold the product IDs
        var productArray = [];
        
        // Check if orderData.product_id is already an array, if not, make it an array
        if (Array.isArray(orderData.product_id)) {
            productArray = orderData.product_id;
        } else {
            // If it's a string, parse it into an array
            productArray = JSON.parse(orderData.product_id);
        }

        // Append each product ID individually to the new array
        productArray.forEach(function(product) {
            formData.append('products[]', product); // Appends each product ID as an individual item
        });

        formData.append('order_id', orderData.id);

        var url = window.routeUrls.reviewRoute; // Corrected to match the defined window.routeUrls

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,  // Prevent jQuery from automatically transforming the data into a query string
            contentType: false,  // Don't set a content-type header; let the browser set it correctly for FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
            },
            success: function(response) {
                if(response.success == true) {
                    location.reload();
                    Swal.fire("Saved!", response.message, "success");
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                const errors = xhr.responseJSON.errors;
                let errorHtml = '';
                for (let field in errors) {
                    errorHtml += `${errors[field][0]}<br>`;  // Added <br> for better error formatting
                }

                Swal.fire("Error!", errorHtml, "error");  // Correct string interpolation here
            }
        });
    });

});

// Pusher.logToConsole = true;

// Initialize Pusher
const pusher = new Pusher('5e0f5df8b31983965bc4', {
    cluster: 'ap1'
});

// Ensure the order_id element exists before accessing innerText
const orderIdElement = document.getElementById('order_id');
if (!orderIdElement) {
    console.error('Order ID element not found.');
} else {
    const orderId = orderIdElement.innerText;

    // Subscribe to the Pusher channel
    const channel = pusher.subscribe('order.' + orderId);

    // Listen for the 'OrderStatusUpdated' event
    channel.bind('App\\Events\\OrderStatusUpdated', function(event) {
        console.log('Received event:', event);  // Log event to verify the structure

        if (event && event.status) {
            const status = event.status;
            const statusElement = document.querySelector('#order_status');
            const cancelButton =    document.querySelector('#cancelOrderForm');
            if (statusElement) {
                // Update text content
                statusElement.textContent = status;

                // Remove old status class
                statusElement.classList.remove('text-success', 'text-info', 'text-warning', 'text-primary', 'text-secondary');

                // Add new status class
                if (status === 'Delivered') {
                    statusElement.classList.add('text-success');
                    location.reload();
                } else if (status === 'Shipped') {
                    statusElement.classList.add('text-info');
                    cancelButton.classList.add('d-none');
                } else if (status === 'Processing') {
                    statusElement.classList.add('text-warning');
                    cancelButton.classList.add('d-none');
                } else if (status === 'Out for Delivery') {
                    statusElement.classList.add('text-primary');
                    cancelButton.classList.add('d-none');
                } else {
                    statusElement.classList.add('text-secondary'); // Default color
                }
            }
        } else {
            console.error('Event data is missing:', event);
        }
    });
}
