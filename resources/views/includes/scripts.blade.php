<!-- filepath: /c:/Users/Leo/Desktop/Laragon/Laragon/www/Ecommerce-app/resources/views/includes/scripts.blade.php -->
<script>
    function updateCartWishlistItemNumber() {
        var cartItemNumber = document.getElementById('cart-item-number');
        var wishlistItemNumber = document.getElementById('wishlist-item-number');
        // Send AJAX request to update the quantity on the server
        $.ajax({
            url: '{{ route("cart.item.number") }}',
            type: 'GET',
            success: function(response) {
                // console.log(response);
                cartItemNumber.textContent  = response.cartTotal;
                wishlistItemNumber.textContent  = response.wishlistTotal;
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
   

    document.addEventListener('DOMContentLoaded', function() {
        updateCartWishlistItemNumber();
       
    });

    if (window.location.pathname == "/shop") {
      
        document.getElementById('nav_search').classList.add('d-none');
        
    } else {
        document.getElementById('nav_search').classList.remove('d-none');

       
    }

    


</script>