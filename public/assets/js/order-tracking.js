Pusher.logToConsole = true;
// Initialize Pusher
const pusher = new Pusher('5e0f5df8b31983965bc4', {
    cluster: 'ap1'
});

const orderId = document.getElementById('order_id').innerText;

// Subscribe to the Pusher channel
const channel = pusher.subscribe('order.' + orderId);

// Listen for the 'OrderStatusUpdated' event
channel.bind('App\\Events\\OrderStatusUpdated', function(event) {
    console.log('Received event:', event);  // Log event to verify the structure

    if (event) {
        const tracking_id = event.tracking_id;
        const status = event.status;
        const updated_at = event.updated_at;
        const min_days = event.min_days; // Assuming min_days and max_days are sent with the event
        const max_days = event.max_days;

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
            const buttonClass = {
                'Delivered': 'btn-outline-success',
                'Out for Delivery': 'btn-outline-primary',
                'Shipped': 'btn-outline-info',
                'Processing': 'btn-outline-warning',
                'Cancelled': 'btn-outline-danger',
                default: 'btn-outline-secondary'
            }[status] || buttonClass.default;

            statusButton.className = `btn ${buttonClass} btn-sm fw-bold`;
            statusButton.textContent = status;
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
            dot.classList.remove('active', 'big-dot');

            if (index < currentStepIndex) {
                dot.classList.add('active');
            } else if (index === currentStepIndex) {
                dot.classList.add('big-dot');
                
                if (!dot.querySelector('i.fa-check')) {
                    const checkIcon = document.createElement('i');
                    checkIcon.className = 'fa fa-check';
                    dot.appendChild(checkIcon);
                }

                const dateElement = document.getElementById(`step-${index}-date`);
                if (dateElement && updated_at) {
                    const formattedDate = new Date(updated_at).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                    dateElement.textContent = `${formattedDate}`;
                }
            }
        });

        // Update delivery dates dynamically based on status
        const orderDate = new Date(updated_at);
        let minDeliveryDate, maxDeliveryDate;

        if (status === 'Out for Delivery') {
            // If "Out for Delivery", set the estimated delivery date to today and the next day
            minDeliveryDate = new Date(orderDate);
            maxDeliveryDate = new Date(orderDate);
            maxDeliveryDate.setDate(orderDate.getDate() + 1); // Next day
        } else if (status === 'Delivered') {
            // If "Delivered", use the current delivery date
            minDeliveryDate = new Date(orderDate);
            maxDeliveryDate = new Date(orderDate);
        } else {
            // Otherwise, use min_days and max_days from event
            minDeliveryDate = new Date(orderDate);
            minDeliveryDate.setDate(orderDate.getDate() + min_days);
            maxDeliveryDate = new Date(orderDate);
            maxDeliveryDate.setDate(orderDate.getDate() + max_days);
        }

        // Format min and max delivery dates
        const formattedMinDeliveryDate = minDeliveryDate.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const formattedMaxDeliveryDate = maxDeliveryDate.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });

        // Update delivery date display
        const minDeliveryElement = document.getElementById('min-delivery-date');
        const maxDeliveryElement = document.getElementById('max-delivery-date');
        
        if (minDeliveryElement && maxDeliveryElement) {
            minDeliveryElement.textContent = formattedMinDeliveryDate;
            maxDeliveryElement.textContent = formattedMaxDeliveryDate;
        }
    } else {
        console.error('Event data is missing:', event);
    }
});

function route(routeUrl) {
    window.location.href = routeUrl;
}
