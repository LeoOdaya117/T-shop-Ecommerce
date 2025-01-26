<!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light mt-5 mt-md-0">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            {{-- DASHBOARD --}}
                            <li class="nav-item ">
                                <a class="nav-link active" href="{{ route('admin.dashboard') }}"  aria-expanded="false" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                               
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('home') }}" aria-expanded="false" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Shop</a>                            </li>
                          

                           
                            {{-- FEATURES --}}
                            <li class="nav-divider">
                                Features
                            </li>
                            <li class="nav-item">
                                
                                {{-- PRODUCTS MENU--}}
                                <li class="nav-item ">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#product-menu" aria-controls="submenu-1"><i class="fas fa-shopping-bag"></i>Products <span class="badge badge-success">6</span></a>
                                    <div id="product-menu" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.products') }}">Manage Product</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.categories') }}">Categories</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.brands') }}">Brands</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.inventory.inventory_logs') }}">Inventory</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.bulk-upload') }}">Bulk Upload</a>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                </li>
                                {{-- PAYMENT MENU --}}
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#payment-menu" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Payment </a>
                                    <div id="payment-menu" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Payment Logs</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Failed Payment</a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </li> --}}
                                {{-- ORDERS MENU --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.orders') }}" aria-expanded="false"  aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Orders </a>
                                   
                                </li>
                                {{-- USERS MENU --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#users-menu" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Users </a>
                                    <div id="users-menu" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.customers') }}">Customer</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admins</a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </li>
                            </li>



                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#reports-menu" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Reports </a>
                                <div id="reports-menu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Sales Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Customer Reports</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Inventory Reports</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                            
                            {{-- SETTINGS --}}
                            <li class="nav-divider">
                                Settings
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Pages </a>
                                <div id="submenu-6" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Site Settings</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->