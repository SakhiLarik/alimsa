@php
    $defaultPrice = $product['price'];
    $rating_stars = 0;
    $rating_list = ['Poor', 'Average', 'Looks Good', 'Loved It', 'Perfect Fit & Quality'];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('nav')
    <div class="container">
        {{-- <div class="spacer"></div> --}}
        <div class="product-details">
            <div class="spacer my-10"></div>
            <div class="image-holder gap-5 grid sm:grid-cols-3 lg:grid-cols-6">
                <div class="col-span-3">
                    <div class="grid grid-cols-3">
                        <div
                            class="image-list-manager h-[50vh] md:h-[75vh] m-1 overflow-y-scroll overflow-x-hidden col-span-1 hiddenScroller">
                            @foreach ($images as $image)
                                <div class="image-box cursor-pointer hover:scale-105" onclick="updateImageContent(this)">
                                    <img class="block rounded h-52 w-52 mb-5 shadow-lg shadow-slate-200"
                                        src="{{ asset($image->location) }}" alt="">
                                </div>
                            @endforeach
                            <div class="image-box m-1 hover:scale-105 cursor-pointer"
                                onclick="updateImageContent(this)">
                                <img class="block rounded h-52 w-52 mb-5 shadow-lg shadow-slate-200"
                                    src="{{ asset($product['image']) }}" alt="">
                            </div>

                        </div>
                        <div class="main-image-container m-1 col-span-2">
                            <img class="main-image" src="{{ asset($product['image']) }}" alt="">
                        </div>
                        <div class="col-span-3">
                            <div class="ratings my-3">
                                <hr class="bg-slate-400 border-slate-400" />
                                <div>
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
                                                    echo "<i class=\"text-2xl text-amber-400 fa fa-star fas far\"></i>";
                                                }
                                                $remaining = 5 - intval($ratings);
                                                for ($i = 0; $i < $remaining; $i++) {
                                                    echo "<i class=\"text-2xl text-gray-400 fa fa-star fas far\"></i>";
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
                                                    echo "<i class=\"text-2xl text-gray-400 fa fa-star fas far\"></i>";
                                                }
                                            @endphp
                                            )
                                        </h1>
                                        <p class="my-2 text-redish">Be the first to review</p>
                                    @endif

                                    {{-- Check if already reviewed this product --}}
                                    @php
                                        $askReview = true;
                                        if (Auth::guard('web')->check()) {
                                            $user_id = Auth::guard('web')->user()->id;
                                            $reviewCount = DB::table('product_reviews')
                                                ->where('user_id', '=', $user_id)
                                                ->where('product_id', '=', $product->id)
                                                ->get();
                                            if (count($reviewCount) > 0) {
                                                $askReview = false;
                                            }
                                        }
                                    @endphp
                                    @if ($askReview)

                                        <div
                                            class="review-form border md:block hidden border-slate-300 shadow-lg shadow-slate-300 rounded-lg p-5 m-5">
                                            <form action="/user/product/ratings" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('post')
                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                {{-- <p>Let us know about our product    </p> --}}
                                                <h1 class="text-xl bolder">Write a Review</h1>
                                                <hr class="bg-slate-300 my-5 border-slate-300" />
                                                <div class="form-group">
                                                    <label for="">Reviews</label>
                                                    <textarea maxlength="255" oninput="document.querySelector('.counter').innerText = this.value.length+'/255'"
                                                        class="input-control" rows="3" name="review" placeholder="Write your feedback here...">{{ old('review') }}</textarea>
                                                    @error('review')
                                                        <span class="text-red-500 ">{{ $message }}</span>
                                                    @enderror
                                                    <div class="flex justify-between">
                                                        <span></span>
                                                        <small
                                                            class="text-sm w-full bolder text-right counter text-primary">0/255</small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <ul class="flex flex-wrap">
                                                        @foreach ($rating_list as $index => $rating)
                                                            <input @if ($index == 2) checked @endif
                                                                type="radio" hidden value="{{ $index + 1 }}"
                                                                onchange="setRatingItem('RatingListItem','selected_rating{{ $index }}');"
                                                                name="rating" id="rating{{ $index + 1 }}">
                                                            <li class="m-2"><label
                                                                    class=" @if ($index == 2) checked_rating @endif RatingListItem selected_rating{{ $index }} "
                                                                    for="rating{{ $index + 1 }}">
                                                                    {{ $rating }}
                                                                    (@php
                                                                        for ($i = 0; $i <= $index; $i++) {
                                                                            echo "<i class=\"fa rating_star fas fa-star\"></i>";
                                                                        }
                                                                    @endphp)
                                                                </label></li>
                                                        @endforeach
                                                        @error('rating')
                                                            <span class="text-red-500 ">{{ $message }}</span>
                                                        @enderror
                                                    </ul>
                                                    @error('rating')
                                                        <span class="text-red-500 ">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="primary-btn" value="Submit Review">
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="comments md:block hidden my-5">
                                <h1 class="text-2xl">Comments</h1>
                                <hr class="my-5 bg-slate-400 border-slate-400" />
                                <div class="comment-area">
                                    <div class="comment-form">
                                        <form action="/user/product/comments/" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            <input type="text" hidden name="product_id" value="{{ $product->id }}">
                                            <div class="form-group">
                                                <textarea required minlength="10" maxlength="5000" name="comment" id="" rows="3"
                                                    placeholder="Write your comment here..." class="input-control">{{ old('comment') }}</textarea>
                                                @error('comment')
                                                    <span class="text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="primary-btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="comment-container my-10">
                                        @foreach ($comments as $comment)
                                            @php
                                                $userData = DB::table('users')
                                                    ->where('id', '=', $comment->user_id)
                                                    ->get()[0];
                                            @endphp
                                            <div class="comment p-5 shadow-slate-200 border border-slate-200 shadow-md">
                                                <div class="user-comment">
                                                    <h1 class="text-redish bolder ">{{ $userData->name }}</h1>
                                                    <p class="p-2 text-primary">
                                                        {{ $comment->comment }}
                                                    </p>
                                                </div>
                                                @if ($comment->response)
                                                    <div class="admin-response ">
                                                        <h1 class="text-primary bolder">Admin</h1>
                                                        <p class="p-2 text-primary">
                                                            {{ $comment->response }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-container col-span-3 sm:my-10 lg:my-0">
                    <form action="/user/orders/single_order" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" value="{{ $product->id }}" name="product">
                        <input type="hidden" value="{{ $product->price }}" name="price" class="product_price">
                        <input type="hidden" value="{{ $product->price }}" name="total_price"
                            class="product_total_price">
                        <div class="information border-b border-b-slate-300">
                            <h1 class="text-2xl md:text-4xl bolder">{{ $product['name'] }}</h1>
                            <div class="flex my-10 justify-between">
                                <div class="order-amount">
                                    <p class="text-2xl md:text-4xl">PKR <span class="updatablePrice"></span>
                                        {{ number_format($product['price']) }}</p>
                                </div>
                                <div>
                                    <p class="bolder text-xl md:text-3xl">

                                        Size</p>
                                    <div class="flex justify-center items-center">
                                        @if (count($sizes) <= 0)
                                            {{-- <h1 class="my-2 text-slate-600">
                                                Only available in <span class="bolder">{{ $product['size'] }}</span>
                                                Size
                                            </h1> --}}
                                        @endif
                                        @foreach ($sizes as $index => $size)
                                            <div class="item my-4">
                                                <input type="radio" name="size" class="hidden"
                                                    onchange="selectSize(this, 'currentSizeLabel{{ $size->id }}','{{ $size->name }}','{{ $size->price }}');"
                                                    id="selectSizes{{ $size->id }}" value="{{ $size->id }}">
                                                <label title="{{ $size->name }}"
                                                    for="selectSizes{{ $size->id }}"
                                                    class=" currentSizeLabel{{ $size->id }} selectSizeLabel cursor-pointer">
                                                    {{ strtoupper($size->symbol) }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="item my-4">
                                            <input type="radio" name="size" class="hidden" checked
                                                onchange="selectSize(this, 'currentSizeLabel{{ $product->id }}_productDefault','{{ $product->size }}','{{ $product->price }}');"
                                                id="selectSizes{{ $product->id }}_productDefault" value="">
                                            <label title="{{ $product->size }}"
                                                for="selectSizes{{ $product->id }}_productDefault"
                                                class=" currentSizeLabel{{ $product->id }}_productDefault selected-label selectSizeLabel cursor-pointer">
                                                {{ strtoupper($product->symbol) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add-to-cart border-b my-5 border-b-slate-300">
                            <h1 class="text-2xl bolder">Product Details</h1>
                            <div class="product-order-settings w-[50%] flex justify-between px-5 py-2">
                                <div class="item-name space-y-2">
                                    <p>
                                        @if ($product['is_perfume'] == 1)
                                            Bottle
                                        @else
                                            Product
                                        @endif
                                        Size:
                                    </p>
                                    <p>Product Price: </p>
                                    <p>Order Amount: </p>
                                    <br />
                                </div>
                                <div class="item-value space-y-2">
                                    <p class="update_order_size">{{ $product['size'] }}</p>
                                    <p class="update_order_price">{{ $defaultPrice }}</p>
                                    <input type="hidden" name="price" id="price" value="{{ $defaultPrice }}"
                                        class="setInputOrderPrice">
                                    <p><input type="number" value="1" min="1" max="10"
                                            name="order_amount"
                                            class="border setOrderAmount border-gray-300 rounded outline-0 focus:outline-0 px-2 py-1"
                                            oninput="updateTotalBill(this, 'setInputOrderPrice' )"> </p>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="more-information  border-b border-b-slate-300">
                            <h2 class="text-2xl bolder">More Information</h2>
                            <p class="py-5">
                                {{ $product['description'] }}
                            </p>
                            <div class="py-5 flex w-full justify-baseline">
                                <div class="titles space-y-2 w-[25%]">
                                    <p>{{ $product['color'] != null ? 'Color: ' : '' }}</p>
                                    <p>Sub-Category :</p>
                                    @if ($product['is_perfume'] == 1)
                                        <p>Gender</p>
                                    @else
                                        <p>Gender</p>
                                        <p>Febric Type :</p>
                                        <p>Design Type :</p>
                                        <p>Season :</p>
                                        <p>Occasion :</p>
                                        <p>Outfit :</p>
                                    @endif
                                    <p>Disclaimer :</p>
                                </div>
                                <div class="mx-20 values space-y-2 w-[75%]">
                                    <p>{{ $product['color'] != null ? $product['color'] : '' }}</p>
                                    <p>{{ $subCategory == null ? 'No Sub-category' : $subCategory['name'] }}</p>
                                    @if ($product['is_perfume'] == 1)
                                        <p>{{ $product['gender'] }}</p>
                                    @else
                                        <p>{{ $product['gender'] }}</p>
                                        <p>{{ $product['febric'] }}</p>
                                        <p>{{ $product['design'] }}</p>
                                        <p>{{ $product['season'] }}</p>
                                        <p>{{ $product['occasion'] }}</p>
                                        <p>{{ $product['outfit'] }}</p>
                                    @endif
                                    <p>Due to photographic lighting and different screen callibrations, the color of the
                                        original product may vary from picture</p>
                                </div>
                            </div>
                            @if (count($addOns) > 0)
                                <div class="matching-item-information">
                                    <h2 class="text-2xl bolder">Matching Items</h2>
                                    <div class="items my-5">
                                        @foreach ($addOns as $feature)
                                            <div
                                                class="flex justify-start items-center my-5 border p-3 border-slate-300">
                                                <div class="image-data mx-3 w-[25%]">
                                                    <img src="{{ asset($feature->image) }}" alt="Image not Loaded"
                                                        class="w-fit">
                                                </div>
                                                <div class="data mx-3 w-[75%]">
                                                    <p class="text-2xl my-2 text-redish bolder">{{ $feature->name }}
                                                    </p>
                                                    <hr class="w-full my-5 border border-slate-300 bg-slate-300" />
                                                    <label for="matching_item_size" class="bolder"> Select Size
                                                    </label>
                                                    <select class="w-[35%] mx-5 border p-1" name="add_on_size"
                                                        id="matching_item_size">
                                                        <option value="36">36</option>
                                                        <option value="37">37</option>
                                                        <option value="38">38</option>
                                                        <option value="39">39</option>
                                                        <option value="40">40</option>
                                                    </select>
                                                    <br />
                                                    {{-- <p>Size: <span class="bolder">{{ $feature->size }}</span></p> --}}
                                                    <div class="add-item-check my-5">
                                                        <input type="text" value="{{ $feature->price }}"
                                                            name="add_on_price" hidden
                                                            class="addOnPrice_{{ $feature->id }} matching_item_price">
                                                        <input type="checkbox" class="matching_item_checkbox"
                                                            onchange="addMatchingItem(this,'{{ $feature->price }}');"
                                                            id="checkbox_matching_item_{{ $feature->id }}"
                                                            value="{{ $feature->id }}">
                                                        <label class="bolder mx-3"
                                                            for="checkbox_matching_item_{{ $feature->id }}">Add
                                                            Matching
                                                            {{ $feature->name }} (+Rs.
                                                            {{ number_format($feature->price, 0, ',') }})</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" class="add_on_selected" name="add_on_selected" value="0">
                        <p class="my-2 bolder text-xl">Total Bill: Rs. <span
                                class="update_total_bill">{{ number_format($defaultPrice) }}</span></p>
                        <input type="hidden" value="{{ $defaultPrice }}" name="total_price"
                            class="setInputTotalBill">
                        <div class="order-link py-5">
                            <button type="submit" class="primary-btn">BUY NOW</button>
                            <a href="/user/cart/add/{{ $product['id'] }}" class="secondary-btn">ADD TO CART</a>
                            {{-- <a href="/user/favourites/add/{{ $product['id'] }}" class="info-btn">ADD TO FAVOURITE</a> --}}
                    </form>
                    {{-- Check if already reviewed this product --}}
                    @php
                        $askReview = true;
                        if (Auth::guard('web')->check()) {
                            $user_id = Auth::guard('web')->user()->id;
                            $reviewCount = DB::table('product_reviews')
                                ->where('user_id', '=', $user_id)
                                ->where('product_id', '=', $product->id)
                                ->get();
                            if (count($reviewCount) > 0) {
                                $askReview = false;
                            }
                        }
                    @endphp
                    @if ($askReview)
                        <div
                            class="review-form border block md:hidden border-slate-300 shadow-lg shadow-slate-300 rounded-lg p-5 my-10">
                            <form action="/user/product/ratings" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                {{-- <p>Let us know about our product    </p> --}}
                                <h1 class="text-xl bolder">Write a Review</h1>
                                <hr class="bg-slate-300 my-5 border-slate-300" />
                                <div class="form-group">
                                    <label for="">Reviews</label>
                                    <textarea maxlength="255" oninput="document.querySelector('.counter').innerText = this.value.length+'/255'"
                                        class="input-control" rows="3" name="review" placeholder="Write your feedback here...">{{ old('review') }}</textarea>
                                    @error('review')
                                        <span class="text-red-500 ">{{ $message }}</span>
                                    @enderror
                                    <div class="flex justify-between">
                                        <span></span>
                                        <small
                                            class="text-sm w-full bolder text-right counter text-primary">0/255</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <ul class="flex flex-wrap">
                                        @foreach ($rating_list as $index => $rating)
                                            <input @if ($index == 2) checked @endif type="radio"
                                                hidden value="{{ $index + 1 }}"
                                                onchange="setRatingItem('RatingListItem','selected_rating{{ $index }}');"
                                                name="rating" id="rating{{ $index + 1 }}">
                                            <li class="m-2"><label
                                                    class=" @if ($index == 2) checked_rating @endif RatingListItem selected_rating{{ $index }} "
                                                    for="rating{{ $index + 1 }}"> {{ $rating }}
                                                    (@php
                                                        for ($i = 0; $i <= $index; $i++) {
                                                            echo "<i class=\"fa rating_star fas fa-star\"></i>";
                                                        }
                                                    @endphp)
                                                </label></li>
                                        @endforeach
                                        @error('rating')
                                            <span class="text-red-500 ">{{ $message }}</span>
                                        @enderror
                                    </ul>
                                    @error('rating')
                                        <span class="text-red-500 ">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="primary-btn" value="Submit Review">
                                </div>
                            </form>
                        </div>
                    @endif
                    <div class="comments md:hidden block my-5">
                        <h1 class="text-2xl">Comments</h1>
                        <hr class="my-5 bg-slate-400 border-slate-400" />
                        <div class="comment-area">
                            <div class="comment-form">
                                <form action="/user/product/comments/" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <input type="text" hidden name="product_id" value="{{ $product->id }}">
                                    <div class="form-group">
                                        <textarea required minlength="10" maxlength="5000" name="comment" id="" rows="3"
                                            placeholder="Write your comment here..." class="input-control">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="primary-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="comment-container my-10">
                                @foreach ($comments as $comment)
                                    @php
                                        $userID = $comment->user_id;
                                        $userData = DB::table('users')->where('id', '=', $userID)->get()[0];
                                    @endphp
                                    <div class="comment p-5 shadow-slate-200 border border-slate-200 shadow-md">
                                        <div class="user-comment">
                                            <h1 class="text-redish bolder ">{{ $userData->name }}</h1>
                                            <p class="p-3 text-primary">
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                        @if ($comment->response)
                                            <div class="admin-response my-5">
                                                <h1 class="text-primary bolder">Admin</h1>
                                                <p class="p-3 text-primary">
                                                    {{ $comment->response }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('footer')
    <script>
        function updateImageContent(div) {
            document.querySelector("img.main-image").src = div.querySelector("img").src;
        }

        function selectSize(input, lbl_class, size, price) {
            let label = document.querySelector(`.${lbl_class}`);
            let labelSizeSelector = document.querySelectorAll('.selectSizeLabel');
            for (selection of labelSizeSelector) {
                selection.classList.remove('selected-label');
                selection.classList.remove('unselected-label');
            }
            if (input.checked) {
                document.querySelector(".update_order_size").innerText = size;
                document.querySelector(".update_order_price").innerText = price;
                document.querySelector(".setInputOrderPrice").value = price;
                label.classList.add('selected-label')
                label.classList.remove('unselected-label')
            } else {
                label.classList.remove('selected-label')
                label.classList.add('unselected-label')
            }
            document.querySelector(".setOrderAmount").value = 1;
            document.querySelector(".update_total_bill").innerText = price;
            document.querySelector(".setInputTotalBill").value = price;
        }

        function updateTotalBill(amount, price) {
            if (amount.value > 10) {
                amount.value = 10;
            }
            if (amount.value <= 0) {
                amount.value = 1;
            }
            price = parseInt(document.querySelector(`.${price}`).value);
            let addOnPrice = 0;
            if (document.querySelector(".matching_item_checkbox")) {
                if (document.querySelector(".matching_item_checkbox").checked) {
                    addOnPrice = parseInt(document.querySelector(".matching_item_price").value);
                }
            }
            let total = parseInt(amount.value) * price;
            total = total + addOnPrice;
            document.querySelector(".update_total_bill").innerText = total;
            document.querySelector(".setInputTotalBill").value = total;
        }

        function addMatchingItem(input, price) {

            let bill = document.querySelector(".setInputTotalBill").value;
            let total = bill;
            if (input.checked) {
                total = parseInt(bill) + parseInt(price);
                document.querySelector(".add_on_selected").value = 1;
            } else {
                total = parseInt(bill) - parseInt(price);
                document.querySelector(".add_on_selected").value = 0;
            }
            document.querySelector(".setInputTotalBill").value = total;
            document.querySelector(".update_total_bill").innerText = total;
        }

        function setRatingItem(itemList, currentItem) {
            let items = document.querySelectorAll(`.${itemList}`);
            items.forEach(element => {
                element.classList.remove("checked_rating");
            });
            document.querySelector(`.${currentItem}`).classList.add("checked_rating");
        }
    </script>
</body>

</html>
