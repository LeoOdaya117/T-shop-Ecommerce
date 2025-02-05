$(document).on('click', '.removeWishlistBtn', function() {
    const wishlistId = $(this).data('wishlist-id'); 
    const url = window.routeUrls.removeToWishlist;
    $.ajax({
        type: "DELETE",
        url: url,
        data: {
            wishlist_id: wishlistId,   
            
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token

        },
        success: function(response) {
            const wishlist_id = response.wishlist_id;
            if(response.success) {
                updateCartWishlistItemNumber();
                $(`tr[data-wishlist-id="${wishlist_id}"]`).remove();
                Swal.fire({
                    icon: 'success',
                    title: response.message,  // Corrected typo in title
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: response.message,
                    toast: true,
                    position: 'center-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }
        }
    });

});

// MOVE TO CART FUNCTION
$('.moveToCartBtn').on('click', function(){

    const wishlistId = $(this).data('wishlist-id');
    const productId = $(this).data('product-id');
    const variantId = $(this).data('variant-id');
    var url = "{{ route('wishlist.move.to.cart') }}";

    if (!wishlistId || !productId || !variantId) {
        console.error("Missing required parameters:", { wishlistId, productId, variantId });
        return;
    }
   
    $.ajax({
        type: "POST",
        url: window.routeUrls.moveToCart,
        data: {
            wishlist_id: wishlistId,
            product_id: productId,
            variant_id: variantId
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Dynamically fetch CSRF token
        },
        success: function(response) {
            const wishlist_id = response.wishlist_id;
            updateCartWishlistItemNumber();
            $(`tr[data-wishlist-id="${wishlist_id}"]`).remove();
            Swal.fire({
                icon: 'success',
                title: response.message,  // Corrected typo in title
                toast: true,
                position: 'center-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        }
    });
    
});

