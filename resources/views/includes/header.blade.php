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

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top small-navbar">

  <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="{{ route('home') }}">
          <i class="fa-solid fa-cart-shopping fa-lg"></i>
          T-Shop
      </a>

      <!-- Toggler Button for Mobile View -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Content -->
      <div class="collapse navbar-collapse" id="navbarText">
          <!-- Center Search Bar -->
        <!-- filepath: /c:/Users/Leo/Desktop/Laragon/Laragon/www/Ecommerce-app/resources/views/includes/header.blade.php -->
        <div class="d-flex ms-auto" style="width: 50%;">
            <form action="{{ route('search.product') }}" method="GET" class="d-flex w-100">
                <input class="form-control me-2" type="search" name="search" placeholder="Search products..." aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">
                    Search
                </button>
            </form>
        </div>

          <!-- Right-aligned Nav Links -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              
              <li class="nav-item">
                  
                <a class="btn btn-outline-dark text-dark bg-transparent" type="submit" href="{{ route('cart.show') }}">
                  <i class="fa-solid fa-cart-shopping"></i>
                  {{-- Cart --}}
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
