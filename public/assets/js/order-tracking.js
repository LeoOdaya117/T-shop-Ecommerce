// Pusher.logToConsole = true;
// Initialize Pusher
const pusher = new Pusher('5e0f5df8b31983965bc4', {
    cluster: 'ap1'
});

const orderId = document.getElementById('order_id').innerText;

// Subscribe to the Pusher channel
const channel = pusher.subscribe('order.' + orderId);

// Listen to the 'OrderStatusUpdated' event
// Listen for the 'OrderStatusUpdated' event
channel.bind('App\\Events\\OrderStatusUpdated', function(event) {
    console.log('Received event:', event);  // Log event to verify the structure

    if (event) {
        const tracking_id = event.tracking_id;
        const status = event.status;
        const updated_at = event.updated_at;

        // Ensure tracking_id and status exist before updating DOM
        if (tracking_id) {
            document.getElementById('tracking_number').textContent = tracking_id;
        }

        if (status) {
            document.querySelector('.order-details span').textContent = `Your Order has been ${status}`;
        }

        // Update the button dynamically based on the status
        const statusButton = document.querySelector('.tracking-details .btn');
        if (statusButton) {
            // Define button classes based on status
            const buttonClass = {
                'Delivered': 'btn-outline-success',
                'Out for Delivery': 'btn-outline-primary',
                'Shipped': 'btn-outline-info',
                'Processing': 'btn-outline-warning',
                'Cancelled': 'btn-outline-danger',
                default: 'btn-outline-secondary'
            }[status] || buttonClass.default;

            // Update button class and label
            statusButton.className = `btn ${buttonClass} btn-sm fw-bold`;  // Update the button class
            statusButton.textContent = status;  // Update the button label with the current status
        }
        // Update progress bar dynamically based on the order status
        const steps = ['Order Placed', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered'];
        const currentStepIndex = steps.indexOf(status);

        if (currentStepIndex !== -1) {
            const progressPercentage = (currentStepIndex / (steps.length - 1)) * 100;
            
            document.querySelector('.progress-bar').style.width = progressPercentage + '%';
        }

        // 🔥 Remove old check icons before updating
        document.querySelectorAll('.dot i.fa-check').forEach(icon => icon.remove());

        // Update dot classes
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            dot.classList.remove('active', 'big-dot');  // Reset all dots

            // Add active and big-dot classes
            if (index < currentStepIndex) {
                dot.classList.add('active');
            } else if (index === currentStepIndex) {
                dot.classList.add('big-dot');
                
                // ✅ Ensure only one check icon is added
                if (!dot.querySelector('i.fa-check')) {
                    const checkIcon = document.createElement('i');
                    checkIcon.className = 'fa fa-check';
                    dot.appendChild(checkIcon);
                }

                // Update the date for the current step
                const dateElement = document.getElementById(`step-${index}-date`);
                if (dateElement && updated_at) {
                    // Format the updated_at date and display it
                    // Format the updated_at date as "31 Jan, 2025"
                    const formattedDate = new Date(updated_at).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                    dateElement.textContent = `${formattedDate}`;
                }
            }
        });
    } else {
        console.error('Event data is missing:', event);
    }
});


function route(routeUrl) {
        window.location.href = routeUrl;
}
