@extends('admin.layouts.default')
@section('title', 'Products')
@section('style')

@endsection
@section('content')
    <main >
         <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Manage Products </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Products</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}" class="breadcrumb-link">Manage Products</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                     <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header ">
                               Product Form
                                
                            </h5>
                            
                            <div class="card-body">
                                <div class="container">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form action="" method="POST" style="color: black;">
                                        @csrf
                                        @method('PUT')
                                        <div class="row  g-0">
                                            
                                            <div class="col">
                                                <div class="row d-block">
                                                    <div class="col">
                                                        <h5 for="inputText3" class="col-form-label">Product Image</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <img class="border border-dark" id="image-container" src="{{ asset('assets/image/no-product-image.png') }}" alt="" height="200" width="100%">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input name="image" id="image-url"  type="text" class="form-control" " placeholder="Image URL">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Title</label>
                                                            <input name="title" id="title"  type="text" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputText3" class="col-form-label" style="color: black;">Slug</label>
                                                            <input name="slug" id="slug"  type="text" class="form-control" readonly>
                                                        </div>
                                                       
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label" style="color: black;">SKU</label>
                                                    <input name="sku"  type="text" class="form-control">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Category</label>
                                                    <select name="category" class="form-control" id="input-select">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" >
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Brand</label>
                                                    <input name="brand"  type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Color</label>
                                                    <input name="color"  type="text" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Size</label>
                                                    <select name="size" class="form-control">
                                                        <option value="S" >Small</option>
                                                        <option value="M" >Medium</option>
                                                        <option value="L" >Large</option>
                                                        <option value="XL" >XL</option>
                                                        <option value="XXL" >XXL</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Price</label>
                                                    <input name="price" type="text" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active" >Active</option>
                                                        <option value="inactive" >Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputText3" class="col-form-label">Description</label>
                                                    <textarea class="form-control" name="description" rows="11"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success rounded" type="submit">Update</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                </div>
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </main>
    <script></script>
   <script>
    document.getElementById('image-url').addEventListener('change', function() {
        const newImageUrl = this.value;
        const imageElement = document.getElementById('image-container');
        console.log('Change');
        if (newImageUrl) {
            imageElement.src = newImageUrl;
        } else {
            imageElement.src = "{{ asset('assets/image/no-product-image.png') }}";
        }
    });
    document.getElementById('title').addEventListener('change', function() {
        const newTitle = this.value;
        const slugElement = document.getElementById('slug');
        

        if (newTitle) {
            slugElement.value = createSlug(newTitle);
        } else {
            slugElement.value = "";
        }
    });


    function createSlug(title){

        return title.replace(/ /g,"-").toLowerCase();

    }

    function generateSKU(category, color, size, brand, productId) {

        const sku = `${category.toUpperCase()}-${color.toUpperCase()}-${size.toUpperCase()}-${brand.toUpperCase()}-${productId}`;
        return sku;

    }
   
   </script>
@endsection

