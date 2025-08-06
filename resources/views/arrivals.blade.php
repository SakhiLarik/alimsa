<!DOCTYPE html>
<html lang="en">

@include('head')

<body>

    <!-- Top Bar -->

    <!-- Navbar -->
    @include('nav')

    <div class="container">
        <h1 class="text-3xl my-5">New Arrivals</h1>
        <div class="container-products">
             <div class=" category-products ">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @if (count($products)<=0)
                        <h1 class="text-xl text-slate-500 p-5">No products found</h1>
                    @endif
                    @foreach ($products as $product)
                        <div class="col-span-1 m-2">
                            <a href="/product/details/{{$product->id}}" class=" text-primary">
                                <div class="product-card bg-gray-100">
                                    <div class="card-body">
                                        <img src="{{ asset($product->image) }}" alt="" class=" h-96 w-full">
                                    </div>
                                    <div class="card-header flex justify-between items-center p-3 ">
                                        <h1 class="">{{ $product->name }}</h1>
                                        <p class="text-redish ">Rs. {{ $product->price }}</p>
                                    </div>
                                    <div class="card-footer grouped-btns w-full items-center justify-between">
                                        {{-- <a class=" text-sm primary-btn w-full" href="#">DETAILS</a> --}}
                                        @php
                                            $sizes = DB::table('product_sizes')
                                                ->where('product_id', '=', $product->id)
                                                ->get();
                                        @endphp
                                        <div class="flex mx-3 justify-center items-center">
                                            @foreach ($sizes as $size)
                                                @if (!empty($size))
                                                    <p class="text-redish border ml-1 p-1 text-xs border-slate-400">
                                                        {{ strtoupper($size->symbol) }}
                                                    </p>
                                                @else
                                                    <p class="text-redish">No size variations</p>
                                                @endif
                                            @endforeach
                                             <p class="text-redish border ml-1 p-1 text-xs border-slate-400">
                                                        {{ strtoupper($product->symbol) }}
                                                    </p>
                                        </div>
                                        <a class=" text-xs w-fit secondary-btn rounded-tl-full" href="/user/cart/add/{{$product->id}}"> ADD TO CART</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Newsletter --}}
    @include('newsletter')
  @if (count($products) <= 0)
        <div class="my-60"></div>
    @endif
    <!-- Footer -->
    @include('footer')
</body>

</html>
