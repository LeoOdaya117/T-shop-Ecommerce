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

  <div class="container-fluid">
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
          <form class="d-flex ms-auto" action="" method="GET" style="width: 50%;">
              <input class="form-control me-2" type="search" name="query" placeholder="Search products..." aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
          </form>

          <!-- Right-aligned Nav Links -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Products</a>
              </li>
              <li class="nav-item">
                  <div class="col-6 d-flex">
                      <a class="nav-link" href="{{ route('cart.show') }}"><i class="fa-solid fa-cart-shopping"></i></a>
                      <span name="cart_number" class="fs-6 ms-n5 mx-1">{{ Session::get('cartTotal', 0) }}</span>
                  </div>
              </li>
              @auth
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <strong> {{ auth()->user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('order.history', ['status'=> 'completed'] ) }}">Order History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
              @endauth
              @guest
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>
