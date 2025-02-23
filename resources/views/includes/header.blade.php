<link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
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
                <a class="nav-link active mx-1 rounded-circle" href="{{ route('user.wishlist') }}" title="Wishlist">
                    <i class="fa-solid fa-heart text-danger"></i>
                    <span class="badge bg-danger text-white rounded-pill " id="wishlist-item-number">{{ Session::get('wishistItemCount', 0) }}</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active  align-items-center rounded-circle" href="{{ route('cart.show') }}" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <!-- Cart Badge -->
                    <span class="badge bg-dark text-white fw-bolder rounded-circle" id="cart-item-number">{{ Session::get('cartItemCount', 0) }}</span>
                </a>
            </li>

            @auth
            <li class="nav-item">
                <a class="nav-link active rounded-circle" href="{{ route('user.profile') }}" title="Profile">
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