@section('style')
    <style>
        .small-navbar {
            padding: 0.5rem 1rem; /* Adjust padding */
        }

        .small-navbar .navbar-brand,
        .small-navbar .navbar-nav .nav-link {
            font-size: 0.875rem; /* Adjust font size */
        }

        /* Mobile View Fix */
        @media (max-width: 991px) {
            .navbar-collapse {
                display: flex;
                flex-direction: column;
                align-items: flex-end; /* Align items to the right */
            }

            .nav_search {
                width: 100%;
                order: 2; /* Moves search bar below toggler */
            }

            .navbar-nav {
                width: 100%;
                display: flex;
                justify-content: flex-end; /* Aligns nav links to the right */
                order: 3;
            }
        }
    </style>
@endsection

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top small-navbar">
  <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="{{ route('home') }}">
          <i class="fa-solid fa-cart-shopping fa-lg"></i>
          T-Shop
      </a>

      <!-- Toggler Button for Mobile View (Aligned Right) -->
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Content -->
      <div class="collapse navbar-collapse" id="navbarText">
          
          <!-- Search Bar (Now Right-Aligned on Mobile) -->
          <div class="d-flex ms-lg-auto nav_search" id="nav_search" style="width: 50%;">
              <form action="{{ route('search.product') }}" method="GET" class="d-flex w-100">
                  <input class="form-control me-2" type="search" name="search" placeholder="Search products..." aria-label="Search">
                  <button class="btn btn-outline-dark" type="submit">Search</button>
              </form>
          </div>

          <!-- Right-Aligned Nav Links -->
          <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="btn btn-outline-dark text-dark bg-transparent" href="{{ route('cart.show') }}">
                      <i class="fa-solid fa-cart-shopping"></i>
                      <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-item-number">{{ Session::get('cartItemCount', 0) }}</span>
                  </a>
              </li>
              @auth
                <li class="nav-item">
                    <a class="nav-link active rounded-circle mx-1 btn" href="{{ route('user.profile') }}" title="Profile">
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
