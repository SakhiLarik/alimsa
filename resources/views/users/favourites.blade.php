@php
use App\Models\Product;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class=" container">
        <div class="welcome">
            <h1 class="text-2xl bolder">Welcom {{ $user['name'] }}</h1>
            <hr class="bg-gray-400 border-gray-400" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-8 ">
            @foreach ($favourites as $index => $item)
                @php
                    $product = Product::find($item->product_id);
                @endphp
                <div class="sm:col-span-4 lg:col-span-3 xl:col-span-2 h-fit" >
                    <div class="product-card m-5">
                        <a href="/product/details/{{ $product['id'] }}">
                            <div class="card-heading">
                                <h1 class="p-3 border-b border-b-gray-300 text-xl">{{ $product['name'] }} (Rs.
                                    {{ $product['price'] }})</h1>
                            </div>
                            <div class="card-body object-cover border-b border-b-gray-300">
                                <center>
                                    <img src="{{ asset($product['image']) }}" class="max-h-96 w-full" alt="" />
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
        @if (count($favourites) <= 0)
            <p class="text-gray-600">You have no any items in your favourite list</p>
        @endif
    </div>
    @include('footer')
</body>

</html>
