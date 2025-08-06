<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <h1 class="text-3xl">
            Produt Reviews & Ratings
        </h1>
        <div class="container">
            <div class="w-fit shadow-lg p-5 border border-slate-300 shadow-slate-200 flex justify-start ">
                <div class="w-[25%]">
                    <img src="{{asset($product['image'])}}" alt="" class="rounded-md h-auto">
                </div>
                <div class="w-[75%] mx-5">
                    <h1 class="text-2xl bolder">{{ $product['name'] }}</h1>
                <p class="text-redish ">{{ $product->product_id }}</p>
                <p class="bolder">Price: Rs. {{ number_format($product->price, 0, ',') }}</p>
                <hr class="bg-slate-400 border-slate-400 my-3" />
                <p>Reviewed By: {{count($reviews)}}</p>
                <p>Total Comments: {{$comments}}</p>
                <p>Total Orders: {{$orders}}</p>
            </div>
        </div>
        <hr class="bg-slate-500 border-slate-500 my-5" />
        @if (count($reviews) <= 0)
            <p class="w-full bolder text-2xl my-5 text-redish">Sorry! There are no any reviews for this product</p>
        @endif
            <div class="list-products grid grid-cols-2 md:grid-cols-4">
                @foreach ($reviews as $review)
                @php
                    $user = DB::table('users')->where("id","=",$review->user_id)->get()[0];
                @endphp
                    <div class="review col-span-2">
                        <div class="card">
                            <p class="bolder text-redish">{{$user->name}}</p>
                            <div class="p-3">
                                <p class="text-primary">{{$review->review}}</p>
                            </div>
                            <p class="text-primary bolder">Ratings: {{$review->ratings}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
