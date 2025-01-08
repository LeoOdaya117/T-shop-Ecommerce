@extends("layouts.default")
@section("title", "T-Shop - Home")
@section('style')
    <style>
        .card,.btn {
            cursor: pointer;
        }
        .card:hover {
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for a 3D effect */
            background-color: #f8f9fa; /* Optional: Change background color */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }
        
    </style>
@endsection()
@section("content")
    <main class="container w-100 mb-5">
        <section class="pt-5">
            
            <div class="container w-50">
                <h2 class="text-center mb-4 mt-3">Checkout</h2>

                @if (session()->has("success"))
                    <div class="alert alert-success">
                        {{session()->get("success")}}
                    </div>
                
                @endif
                @if (session("error"))
                    <div class="alert alert-danger">
                        {{session("error")}}
                    </div>
                
                @endif
                <form method="POST" action="{{ route('checkout.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pin Code</label>
                        <input required type="text" class="form-control" id="pincode" name="pincode" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input required type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea required type="text" class="form-control" id="address" name="address" aria-describedby="emailHelp">
                        </textarea>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            
        </section>
    </main>
@endsection()


