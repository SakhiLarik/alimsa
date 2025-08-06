<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('nav')
    <div class="container">
        <div class="grid sm:grid-cols-1 lg:grid-cols-4">
            <div class="col-span-1 sm:hidden lg:block">
                <div
                    class="my-5 category-details h-fit shadow-xl shadow-slate-300 border-slate-300 border ">
                    <h1 class="text-2xl mx-5 border-b border-b-slate-400 bolder py-5">{{ $category['name'] }}</h1>
                    <div class="list my-5">
                        <ul class="space-y-1 bolder">
                            @if (count($subCategory) > 0)
                                @foreach ($subCategory as $item)
                                    <li class="px-5 py-1"><a
                                            class="hover:text-redish @if ($category->id == $item->category) text-redish border-b border-b-red-400 @else text-primary @endif"
                                            href="/product/category/{{ $category->id }}/sub/{{ $item->id }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            @else
                                <p class="text-slate-600 text-xl px-5">No Subcategory</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-3">
                <div class="category-details">
                    <div class="category-products">
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
                            @if (!$products || empty($products) || count($products) <= 0)
                                <h1 class="text-2xl font-bold text-slate-600 w-fit p-5 m-5">No products found</h1>
                            @endif
                            @foreach ($products as $product)
                                <div class="mx-2">
                                    <a href="/product/details/{{ $product->id }}" class=" text-primary">
                                        <div class="product-card bg-gray-100">
                                            <div class="card-body">
                                                <img src="{{ asset($product->image) }}" alt=""
                                                    class=" h-96 w-full">
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
                                                            <p
                                                                class="text-redish border ml-1 p-1 text-xs border-slate-400">
                                                                {{ strtoupper($size->symbol) }}
                                                            </p>
                                                        @else
                                                            <p class="text-redish">No size variations</p>
                                                        @endif
                                                    @endforeach
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
            <div class="col-span-1 lg:hidden sm:block">
                <div
                    class="my-5 category-details h-fit shadow-xl shadow-slate-300 border-slate-300 border ">
                    <h1 class="text-2xl mx-5 border-b border-b-slate-400 bolder py-5">{{ $category['name'] }}</h1>
                    <div class="list my-5">
                        <ul class="space-y-1 bolder">
                            @if (count($subCategory) > 0)
                                @foreach ($subCategory as $item)
                                    <li class="px-5 py-1"><a
                                            class="hover:text-redish @if ($category->id == $item->category) text-redish border-b border-b-red-400 @else text-primary @endif"
                                            href="/product/category/{{ $category->id }}/sub/{{ $item->id }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            @else
                                <p class="text-slate-600 text-xl px-5">No Subcategory</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!$products || empty($products) || count($products) <= 0)
        <div class="min-h-screen"></div>
    @endif
    @include('footer')
</body>

</html>
