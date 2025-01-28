@extends('layouts.my-account-layout')
@section('title', 'Order History')
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
                                    <th>Product name</th>
                                    <th>Unit Price</th>
                                    <th>Stock status</th>
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
                                                    {{$item->product->title}}
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
                                                <a href="" class="btn btn-success rounded">move to cart</a>
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
        $(document).on('click', '.removeWishlistBtn', function() {
            const wishlistId = $(this).data('wishlist-id'); 
            const url = "{{ route('delete.wishlist') }}";
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    wishlist_id: wishlistId,   
                    
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    const wishlist_id = response.wishlist_id;
                    if(response.success) {
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

    </script>
@endsection

