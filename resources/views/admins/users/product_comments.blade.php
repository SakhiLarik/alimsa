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
                    <img src="{{ asset($product['image']) }}" alt="" class="rounded-md h-auto">
                </div>
                <div class="w-[75%] mx-5">
                    <h1 class="text-2xl bolder">{{ $product['name'] }}</h1>
                    <p class="text-redish ">{{ $product->product_id }}</p>
                    <p class="bolder">Price: Rs. {{ number_format($product->price, 0, ',') }}</p>
                    <hr class="bg-slate-400 border-slate-400 my-3" />
                    <p>Reviewed By: {{ $reviews }}</p>
                    <p>Total Comments: {{ count($comments) }}</p>
                    <p>Total Orders: {{ $orders }}</p>
                </div>
            </div>
            <hr class="bg-slate-500 border-slate-500 my-5" />
            @if (count($comments) <= 0)
                <p class="w-full bolder text-2xl my-5 text-redish">Sorry! There are no any reviews for this product</p>
            @endif
            <div class="list-products grid grid-cols-1 md:grid-cols-2">
                @foreach ($comments as $comment)
                    @php
                        $user = DB::table('users')->where('id', '=', $comment->user_id)->get()[0];
                    @endphp
                    <div class="col-span-1">
                        <div class="comment p-3 shadow-slate-200 border border-slate-200 shadow-md">
                            <div class="user-comment">
                                <h1 class="text-redish bolder ">{{ $user->name }}</h1>
                                <p class="p-3 bolder text-primary">
                                    {{ $comment->comment }}
                                </p>
                            </div>
                            @if ($comment->response)
                                <div class="admin-response ">
                                    <h1 class="text-primary bolder">Admin</h1>
                                    <p class="p-3 text-primary">
                                        {{ $comment->response }}
                                    </p>
                                </div>
                            @else
                                <form action="/admin/users/respond/" method="POST">
                                    @csrf
                                    @method('post')
                                    <input type="text" hidden value="{{ $comment->id }}" name="comment_id">
                                    <input type="text" hidden value="{{ $product['id'] }}" name="product_id">
                                    <textarea class="input-control" required name="response" id="" rows="5" placeholder="Write your response here...">{{ $comment->response == null ? old('response'): $comment->response }}</textarea>
                                    @error('response')
                                        <small class="text-red-500 mb-5">{{ $message }}</small>
                                    @enderror

                                    <button type="submit" class="primary-btn">Submit</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
