// Add CSRF token to all AJAX requests globally
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#myTab7 a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // Get the first color option
    let firstColorButton = document.querySelector(".color-option");
    
    if (firstColorButton) {
        let firstColor = firstColorButton.getAttribute("data-color");
        
        // Call updateSizeOptions to select the first color
        updateSizeOptions(firstColor);
    }
});

function addToCart(productId) {
   
    const quantity = document.getElementById('quantity').value;
    const variant_id = document.getElementById('selectedVariantId').value;

    if (!variant_id) {
        Swal.fire({
            icon: 'error',
            title: `No color and size selected!`,
            toast: true,
            position: 'center-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        return;
    }

    $.ajax({
        url: window.routeUrls.addToCart,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            productId: productId,
            quantity: quantity,
            variant_id: variant_id,
        },
        success: function(response) {
            if (response.success) {
                updateCartWishlistItemNumber();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        },
        error: function(xhr, status, error) {
             window.location.href = window.routeUrls.login;
            console.log(error);
        }
    });

   
}

function buyNow(productId) {
   
    const quantity = document.getElementById('quantity').value;
    const variant_id = document.getElementById('selectedVariantId').value;

    if (!variant_id) {
        Swal.fire({
            icon: 'error',
            title: `No color and size selected!`,
            toast: true,
            position: 'center-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        return;
    }

    $.ajax({
        url: window.routeUrls.addToCart,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            productId: productId,
            quantity: quantity,
            variant_id: variant_id,
        },
        success: function(response) {
            if (response.success) {
                updateCartWishlistItemNumber();
                // Swal.fire({
                //     icon: 'success',
                //     title: response.message,
                //     toast: true,
                //     position: 'center-end',
                //     showConfirmButton: false,
                //     timer: 3000,
                //     timerProgressBar: true
                // });
                window.location.href = window.routeUrls.buyNow;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        },
        error: function(xhr, status, error) {
            window.location.href = window.routeUrls.login;
            console.log(error);
        }
    });

   
}

function incrementQuantity() {
    let input = document.getElementById('quantity');
    let currentValue = parseInt(input.value);
    let maxValue = parseInt(input.max);

    if (currentValue < maxValue) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    let input = document.getElementById('quantity');
    let currentValue = parseInt(input.value);
    let minValue = parseInt(input.min);

    if (currentValue > minValue) {
        input.value = currentValue - 1;
    }
}

let selectedColor = '';
let selectedSize = '';
let variant = null;

function updateSizeOptions(color) {
    // Check if the selected color is already the current selected one
    if (selectedColor === color) {
        // Reset size and variant selection if the same color is selected again
        selectedSize = '';
        variant = null;
        document.getElementById('selectedVariantId').value = '';
        document.getElementById('stock-display').textContent = 'Select a size to view stock availability.';

        // Remove the border highlight from all size buttons
        document.querySelectorAll('.size-option').forEach(sizeButton => {
            sizeButton.classList.remove('border-warning', 'border-3'); // Reset the border style
        });
    } else {
        // If a new color is selected, clear the size and variant
        selectedColor = color;
        selectedSize = '';
        variant = null;

        // Remove the border highlight from all size buttons
        document.querySelectorAll('.size-option').forEach(sizeButton => {
            sizeButton.classList.remove('border-warning', 'border-3'); // Reset the border style
        });

       // Remove active class and reset size for all color buttons
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.classList.remove('border-warning', 'border-3'); // Remove highlight
            btn.style.transform = "scale(1)"; // Reset size
        });

        // Highlight the selected color with a vibrant blue border and resize it
        let selectedColorButton = document.querySelector(`[data-color="${color}"]`);
        if (selectedColorButton) {
            selectedColorButton.classList.add('border-warning', 'border-3'); // Add highlight
            selectedColorButton.style.transform = "scale(1.3)"; // Increase size
        }


        // Hide all size selections
        document.querySelectorAll('.sizes').forEach(sizeDiv => {
            sizeDiv.style.display = 'none';
        });

        // Show the sizes for the selected color
        let selectedSizeDiv = document.getElementById(`sizes-for-${color}`);
        if (selectedSizeDiv) {
            selectedSizeDiv.style.display = 'block';
        }

        // Reset variant id input and stock display
        document.getElementById('selectedVariantId').value = '';
        document.getElementById('stock-display').textContent = 'Select a size to view stock availability.';
    }
}

function selectSize(color, size) {
    selectedSize = size;
    variant = window.variantData.find(v => v.color === color && v.size === size);

    // Reset the previously selected size
    document.querySelectorAll('.size-option').forEach(sizeButton => {
        sizeButton.classList.remove('border-warning', 'border-3'); // Reset the border style
    });

    // Highlight the selected size with a vibrant border
    let selectedSizeButton = document.querySelector(`[data-color="${color}"][data-size="${size}"]`);
    if (selectedSizeButton) {
        selectedSizeButton.classList.add('border-warning', 'border-3'); // Add border to selected size
    }

    if (variant) {
        document.getElementById('selectedVariantId').value = variant.id;

        let stockDisplay = document.getElementById('stock-display');
        let stocksMax = document.getElementById('quantity');
        let addToCartButton = document.getElementById('addToCartButton');

        if (variant.stock > 0) {
            stockDisplay.innerHTML = `${variant.stock} stocks available`;
            stocksMax.value = 1;
            stocksMax.max = variant.stock;
            stockDisplay.classList.add('text-success');
            stockDisplay.classList.remove('text-danger');
            addToCartButton.style.display = 'block';
        } else {
            stockDisplay.innerHTML = 'Out of stock';
            stockDisplay.classList.add('text-danger');
            stockDisplay.classList.remove('text-success');
            addToCartButton.style.display = 'none';
        }

        updateWishlistIcon();
    }
}


function toggleWishlist(button, productId, productTitle) {
    if (!variant) {
        Swal.fire({
            icon: 'error',
            title: `No color and size selected!`,
            toast: true,
            position: 'center-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        return;
    }
    console.log(variant);
    let icon = document.getElementById(`wishlist-icon-${productId}`);

    if (icon.classList.contains("text-dark")) {
        addToWishList(productId, productTitle, variant.id);
    } else {
        removeFromWishList(productId, productTitle, variant.id);
    }
}

function addToWishList(product_id, title, variant_id) {
    let icon = document.getElementById(`wishlist-icon-${product_id}`);
    $.ajax({
        type: "POST",
        url: window.routeUrls.addToWishlists,
        data: { product_id, variant_id,  _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: `${title} added to wishlist`,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                icon.classList.remove("text-dark");
                icon.classList.add("text-danger");
                updateCartWishlistItemNumber();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                
            }
        },
        error: function(xhr) {
            // Swal.fire({
            //     icon: 'error',
            //     title: xhr.responseJSON.message || 'An error occurred',
            //     toast: true,
            //     position: 'center-end',
            //     showConfirmButton: false,
            //     timer: 3000,
            //     timerProgressBar: true
            // });
            window.location.href = window.routeUrls.login;
        }
    });
}

function removeFromWishList(product_id, title, variant_id) {
    let icon = document.getElementById(`wishlist-icon-${product_id}`);
    $.ajax({
        type: "DELETE",
        url: window.routeUrls.removeToWishlist,
        data: { product_id, variant_id,  _token: $('meta[name="csrf-token"]').attr('content')  },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'info',
                    title: `${title} removed from wishlist`,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                icon.classList.remove("text-danger");
                icon.classList.add("text-dark");
                updateCartWishlistItemNumber();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: xhr.responseJSON.message || 'An error occurred',
                toast: true,
                position: 'center-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    });
}

function updateWishlistIcon() {
    if (!variant) {
        return;
    }

    // Find the icon element using the data-product-id attribute
    // let icon = document.querySelector(`[data-product-id="${variant.product_id}"] i`);
    let icon = document.getElementById(`wishlist-icon-${variant.product_id}`);

    // Ensure the icon exists before trying to access its class list
    if (icon) {
        let wishlistItems = window.wishlistItems;
        if (wishlistItems.includes(variant.id)) {
            icon.classList.remove("text-dark");
            icon.classList.add("text-danger");
        } else {
            icon.classList.remove("text-danger");
            icon.classList.add("text-dark");
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    updateWishlistIcon();
});

function route(routeUrl) {
    window.location.href = routeUrl;
}