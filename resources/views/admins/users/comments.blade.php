<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <h1 class="text-3xl">
            Produt Comments
        </h1>
        <div class="container">
            <div class="list-products grid grid-cols-1 lg:grid-cols-4">
                @if (count($products)<=0)
                    <h1 class="col-span-4 p-5 text-slate-600 text-xl">Sorry! there is no product to check and comment</h1>
                @endif
                @foreach ($products as $product)
                    @php
                        $comments = DB::table('product_comments')->where('product_id', '=', $product->id)->get();
                        $not_responded = DB::table('product_comments')->where('product_id', '=', $product->id)->where("response","=",null)->get();
                    @endphp
                    <div class="col-span-1 lg:col-span-2">
                        <div class="card m-2 p-5">
                            <a href="/admin/users/product_comments/{{ $product->id }}">
                                <div class="card-title">
                                    <div class="flex items-center">
                                        <div class="mx-3 w-[25%]">
                                            <img src="{{ asset($product->image) }}" width="200px" height="200px"
                                                alt="Product Image" class="rounded-md border border-gray-400 shadow-xl">
                                        </div>
                                        <div class="mx-3 w-[75%]">
                                            <h1 class="text-xl bolder">{{ $product->name }}</h1>
                                            <p class="text-redish ">{{ $product->product_id }}</p>
                                            <p class="">Price: Rs. {{ number_format($product->price, 0, ',') }}
                                            </p>
                                            <p class="">Size: {{ $product->size }}</p>
                                            <p class="">Color: {{ $product->color }}</p>
                                        </div>
                                    </div>
                                    <hr class="bg-gray-600 border-gray-400 my-2" />
                                    @if (count($comments) > 0)
                                        <p class="my-2 text-primary">
                                            {{count($comments)}} Comments, {{count($comments) - count($not_responded)}} Responded</p>
                                    @else
                                        <p class="my-2 text-redish">No one commented this product yet</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include("admins.flash")
</body>
</html>

