@php
    use App\Models\Product;
    $cartItemsCounter = 0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-8 ">
            @foreach ($cartItems as $index => $item)
                @php
                    $product = Product::find($item->product_id);
                    $cartItemsCounter++;
                @endphp
                <div class="sm:col-span-4 lg:col-span-3 xl:col-span-2 h-fit">
                    <div class="m-2 product-card">
                        <a href="/product/details/{{ $product['id'] }}">
                            <div class="card-heading">
                                <h1 class="p-3 border-b border-b-gray-300 bolder">{{ $product['name'] }} (Rs.
                                    {{ $product['price'] }})</h1>
                            </div>
                            <div class="card-body border-b border-b-gray-300">
                                <center>
                                    <img src="{{ asset($product['image']) }}" class="max-h-96 object-cover w-full" alt="" />
                                </center>
                            </div>
                            <div class="card-footer p-0 m-0 w-full flex">
                                {{-- <center> --}}
                                <a class="secondary-btn w-[50%] m-0 p-0"
                                    href="/user/cart/remove/{{ $product['id'] }}">Remove</a>
                                {{-- <button type="submit" class="primary-btn">Buy Now</button> --}}
                                <a class="primary-btn w-[50%] m-0 p-0" href="/product/details/{{ $product['id'] }}">View
                                    Details</a>
                                {{-- </center> --}}
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($cartItemsCounter > 0)
            <div class="m-5 py-10 border-t border-t-gray-300">
                <a href="/user/cart/checkout" class="btn info-btn px-10">Proceed to Checkout</a>
            </div>
        @else
            <div class="min-h-screen">
                <p class="text-center text-gray-600 my-5 text-xl text-bold font-bold ">Sorry! There is no any product in
                    your cart to order, browse
                    our product add them to cart and order collectively</p>
            </div>
        @endif
    </div>
    @include('footer')
</body>

</html>
