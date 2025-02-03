@extends('layouts.my-account-layout')
@section('title', 'My Wishlist')
@section('my-account')
    
    <main class="container  mb-5">
        <section class="">
            <div class="row d-flex align-items-center align-content-center justify-content-between mb-2 w-auto">
                <div class="col-12">
                    <h5>My Wishlist</h5>


                    <div class="container pt-3">
                        <div class="row table-responsive">

                            <table class="table ">
                                <thead class="text-center">
                                    <th></th>
                                    <th >Product</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @forelse ( $wishlist as $item)

                                        <tr class="align-middle text-center" data-wishlist-id="{{ $item->id }}">
                                            <td class="justify-items-center align-items-center" title="Remove">
                                                <button class="btn removeWishlistBtn" type="button" data-wishlist-id="{{ $item->id }}">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>                                                
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 text-center justify-items-center align-items-center">
                                                    <img src="{{ $item->product->image }}" alt="" width="50px" height="50px">
                                                    <div class="text-start justify-content-center">
                                                        {{$item->product->title}}
                                                        <p class="text-muted">{{ $item->variant->color }} {{ $item->variant->size }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>₱ {{$item->product->price}}</td>
                                            <td>
                                                @if ($item->variant->stock >0)
                                                    In Stock
                                                @else
                                                    Out of Stock
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->variant->stock >0)   
                                                    <button href="" class="btn btn-success rounded moveToCartBtn" data-wishlist-id="{{ $item->id }}" data-product-id="{{ $item->product->id }}" data-variant-id="{{ $item->variant->id }}">move to cart</button>
                                               
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5">No record found.</td>
                                        </tr>
                                    @endforelse
                                   
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div>

                
            </div>
           
        </section>
        
    </main>
@endsection

@section('script')
    <script>
        window.routeUrls = {
            moveToCart: "{{ route('wishlist.move.to.cart') }}",
            removeToWishlist: "{{ route('delete.wishlist') }}",
        };
        
    </script>
    <script src="{{ asset('assets/js/wishlist.js') }}"></script>

@endsection

