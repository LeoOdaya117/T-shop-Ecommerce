document.addEventListener("DOMContentLoaded", function() {
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('input', function() {
            const cartItem = this.closest('.cart-item');
            const itemId = cartItem.getAttribute('data-id');
            const quantity = parseInt(this.value);
            const price = parseFloat(this.getAttribute('data-price'));
            const discount = parseFloat(this.getAttribute('data-discount'));

            const itemTotal = quantity * (price - discount);
            const itemTotalElement = this.closest('.cart-item').querySelector('.item-total-price');
            const subtotalPriceElement = document.getElementById('subtotal-price');
            const totalPriceElement = document.getElementById('total-price');
            const shippingFee = parseFloat(document.getElementById('shipping-price').textContent.replace('₱', '').trim());

            // Update item total
            itemTotalElement.textContent = `₱ ${itemTotal.toFixed(2)}`;

            // Recalculate the subtotal price of the cart
            let subtotalPrice = 0;
            document.querySelectorAll('.item-total-price').forEach(item => {
                subtotalPrice += parseFloat(item.textContent.replace('₱', '').trim());
            });

            // Update the subtotal price of the cart
            subtotalPriceElement.textContent = `${subtotalPrice.toFixed(2)}`;

            // Calculate the total price (subtotal + shipping)
            const totalPrice = subtotalPrice + shippingFee;

            // Update the total price of the cart
            totalPriceElement.textContent = `${totalPrice.toFixed(2)}`;

            // Send AJAX request to update the quantity on the server
            $.ajax({
                url: window.routeUrls.updateQuantity.replace(':id', itemId).replace(':quantity', quantity),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        console.log(response.success);
                    } else {
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });

    // Optional: Remove item from cart (you can handle backend logic here)
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const itemId = cartItem.getAttribute('data-id');

            // Remove the cart item from the DOM
            cartItem.remove();
            updateCartItemNumber();
            // Recalculate subtotal and total price after removing an item
            let subtotalPrice = 0;
            document.querySelectorAll('.item-total-price').forEach(item => {
                subtotalPrice += parseFloat(item.textContent.replace('₱', '').trim());
            });

            // Update the subtotal price of the cart
            document.getElementById('subtotal-price').textContent = `${subtotalPrice.toFixed(2)}`;

            // Calculate the total price (subtotal + shipping)
            const shippingFee = parseFloat(document.getElementById('shipping-price').textContent.replace('₱', '').trim());
            const totalPrice = subtotalPrice + shippingFee;

            // Update the total price of the cart
            document.getElementById('total-price').textContent = `${totalPrice.toFixed(2)}`;

            $.ajax({
                url: window.routeUrls.removeToCart.replace(':id', itemId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        console.log(response.success);
                    } else {
                        console.log(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

            updateCartItemNumber();
        });
    });
});

function clickProduct(routeUrl) {
    window.location.href = routeUrl;
}
function route(routeUrl) {
    window.location.href = routeUrl;
}
