@section('style')
    <style>
        .small-navbar {
            padding: 0.5rem 1rem; /* Adjust the padding as needed */
        }

        .small-navbar .navbar-brand,
        .small-navbar .navbar-nav .nav-link {
            font-size: 0.875rem; /* Adjust the font size as needed */
        }

    </style>
@endsection
<style>
    .small-navbar {
            padding: 0.5rem 1rem; /* Adjust the padding as needed */
        }

        .small-navbar .navbar-brand,
        .small-navbar .navbar-nav .nav-link {
            font-size: 1rem; /* Adjust the font size as needed */
        }

    /* Default styles for <a> tag */
    .nav-link {
        position: relative; /* Ensures proper positioning for the badge */
        transition: all 0.3s ease; /* Smooth transition */
    }

    /* Hover effect for nav link */
    .nav-link:hover {
        background-color: #c6cdff; /* Light background on hover */
        color: #0d6efd; /* Change color to blue */
        transform: scale(1.05); /* Slight zoom effect */
    }

    /* Active (clicked) state */
    .nav-link:active {
        background-color: #0d6efd; /* Blue background when clicked */
        color: white; /* White text on active */
        transform: scale(0.98); /* Slight shrink effect */
    }

    /* Badge inside the nav link */
    .nav-link .badge {
        position: absolute; /* Absolutely position the badge */
        top: -5px; /* Adjust badge position */
        right: -5px;
        transform: scale(0.8); /* Initially smaller */
        transition: transform 0.3s ease, background-color 0.3s ease;
        z-index: 10;
    }

    /* Hover effect on badge */
    .nav-link:hover .badge {
        background-color: #0d6efd; /* Change badge background on hover */
        transform: scale(1); /* Enlarge the badge slightly */
    }

    /* Ensuring the badge text is properly visible */
    .nav-link .badge span {
        font-size: 0.7rem; /* Adjust size of the badge number */
    }

    /* Active state for cart icon */
    .nav-link .badge {
        display: inline-block;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top small-navbar">

  <div class="container">
      
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fa-solid fa-cart-shopping fa-lg"></i>
            T-Shop
        </a>

        

      <!-- Toggler Button for Mobile View -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Content -->
      <div class="collapse navbar-collapse " id="navbarText">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">
                
                        Men
                    </a>
                   
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">
                
                        Women
                    </a>
                   
                </li>
            </ul>

            

        <!-- Right-aligned Nav Links -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-0">
            <li class="nav-item">
                <div class="nav_search" id="nav_search" style="width: 100%;">
                    <form action="{{ route('shop') }}" method="GET" class="d-flex w-100">
                        <div class="input-group">
                            <!-- Search Input -->
                            <input class="form-control me-2" type="search" name="search" placeholder="Search products..." aria-label="Search" style="border-radius: 10px;">
                            <!-- Search Button -->
                            <button class="btn rounded-circle" type="submit">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link active mx-1 " href="{{ route('user.wishlist') }}" title="Wishlist">
                    <i class="fa-solid fa-heart"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active  align-items-center" href="{{ route('cart.show') }}" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <!-- Cart Badge -->
                    <span class="badge bg-dark text-white rounded-pill " id="cart-item-number">{{ Session::get('cartItemCount', 0) }}</span>
                </a>
            </li>

            @auth
            <li class="nav-item">
                <a class="nav-link active " href="{{ route('user.profile') }}" title="Profile">
                    <i class="fa-solid fa-user"></i>
                </a>
            </li>
            @endauth

            @guest
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('login') }}">Login</a>
            </li>
            @endguest
        </ul>


      </div>
  </div>
</nav>