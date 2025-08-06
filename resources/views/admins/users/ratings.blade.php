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
            <div class="list-products grid grid-cols-1 lg:grid-cols-4">
                @if (count($products)<=0)
                    <h1 class="col-span-4 p-5 text-slate-600 text-xl">Sorry! there is no product to check and review</h1>
                @endif
                @foreach ($products as $product)
                    @php
                        $reviews = DB::table('product_reviews')->where('product_id', '=', $product->id)->get();
                    @endphp
                    <div class="col-span-1 lg:col-span-2">
                        <div class="card m-2 p-5">
                            <a href="/admin/users/reviews/{{ $product->id }}">
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
                                    @if (count($reviews) > 0)
                                        @php
                                            $totalReviews = count($reviews);
                                            $ratings = 0;
                                        @endphp
                                        @foreach ($reviews as $review)
                                            @php
                                                $ratings += $review->ratings;
                                            @endphp
                                        @endforeach
                                        @php
                                            $ratings = $ratings / $totalReviews;
                                        @endphp
                                        <h1 class="text-2xl bolder mt-5">
                                            Ratings (
                                            @php
                                                for ($i = 0; $i < intval($ratings); $i++) {
                                                    echo "<i class=\"text-amber-400 fa fa-star fas far\"></i>";
                                                }
                                                $remaining = 5 - intval($ratings);
                                                for ($i = 0; $i < $remaining; $i++) {
                                                    echo "<i class=\"text-gray-400 fa fa-star fas far\"></i>";
                                                }
                                            @endphp
                                            )
                                        </h1>
                                        <p>Reviewed By ({{ $totalReviews }}) User/s</p>
                                    @else
                                        <h1 class="text-2xl bolder mt-5">
                                            Ratings (
                                            @php
                                                for ($i = 0; $i < 5; $i++) {
                                                    echo "<i class=\" text-gray-400 fa fa-star fas far\"></i>";
                                                }
                                            @endphp
                                            )
                                        </h1>
                                        <p class="my-2 text-redish">No one reviewed this product yet</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
