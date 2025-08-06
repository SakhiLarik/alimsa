<!DOCTYPE html>
<html lang="en">

@include('head')

<body>

    <!-- Top Bar -->

    <!-- Navbar -->
    @include('nav')

    <div class="container">
        @if (count($products) > 0)

            <div class="container search-container my-5">
                <form action="/product/search" method="post" class="grouped-btns items-center justify-center">
                    @csrf
                    @method('post')
                    <div class="grid grid-cols-4">
                        <div class="col-span-4 md:col-span-2 m-2">
                            <input type="text" class="input-search" value="{{ $search }}"
                                placeholder="Search by name..." name="search">
                        </div>

                        <div class="col-span-4 md:col-span-1 m-2">
                            <select class="select-filter" name="type" id="">
                                <option @if ($type == 0) selected @endif value="0">Clothes
                                </option>
                                <option @if ($type == 1) selected @endif value="1">Perfumes
                                </option>
                            </select>
                        </div>

                        <div class="col-span-4 md:col-span-1 m-2">
                            <select class="select-filter" name="category" id="">
                                @foreach ($categories as $category)
                                    <option @if ($category->id == $searchedCategory) selected @endif
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-1 m-2">
                        <div class="grouped-btns">
                            <input type="submit" name="submit" id="" value="Search & Filter"
                                class="secondary-btn hidden lg:block ">
                            <button type="submit" name="submit" id=""
                                class="secondary-btn block lg:hidden"><i class="fa fa-search"></i></button>
                            <a href="/product/" class="primary-btn hidden lg:block">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        <h1 class="text-3xl my-5">Our Products</h1>
        <div class="container-products">
            <div class=" category-products ">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @if (count($products) <= 0)
                        <h1 class="text-2xl p-5 w-[100%] mb-20 text-slate-500">No products found</h1>
                    @endif
                    @foreach ($products as $product)
                        <div class="col-span-1 m-2">
                            <a href="/product/details/{{ $product->id }}" class=" text-primary">
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
                                        <a class=" text-xs w-fit secondary-btn rounded-tl-full"
                                            href="/user/cart/add/{{ $product->id }}"> ADD TO CART</a>
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
        <div class="my-40"></div>
    @endif
    <!-- Footer -->
    @include('footer')
</body>

</html>
