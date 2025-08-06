@php
    use app\Models\AddOnFeature;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <div class="spacer"></div>
        <h1 class="text-3xl">
            {{ $product['name'] }}
        </h1>
        <div class="product-details">
            <div class="spacer my-10"></div>
            <div class="image-holder gap-5 grid sm:grid-cols-3 lg:grid-cols-6">
                <div class="image-list-manager h-[70vh] overflow-y-scroll overflow-x-hidden col-span-1 hiddenScroller">
                    @foreach ($images as $image)
                        <div class="image-box cursor-pointer hover:scale-105" onclick="updateImageContent(this)">
                            <img class="block rounded h-52 w-52 mb-5 shadow-lg shadow-slate-200"
                                src="{{ asset($image->location) }}" alt="">
                        </div>
                    @endforeach
                    <div class="image-box hover:scale-105 cursor-pointer" onclick="updateImageContent(this)">
                        <img class="block rounded h-52 w-52 mb-5 shadow-lg shadow-slate-200"
                            src="{{ asset($product['image']) }}" alt="">
                    </div>
                </div>
                <div class="main-image-container col-span-2">
                    <img class="main-image" src="{{ asset($product['image']) }}" alt="">
                </div>
                <div class="data-container col-span-3">
                    <div class="information border-b-2 border-b-slate-400">
                        <h1 class="text-4xl bolder">{{ $product['name'] }}</h1>
                        <div class="flex my-5 justify-between">
                            <p class="text-4xl bolder">PKR {{ number_format($product['price'], 0, '.') }}</p>
                            <div>
                                <p class="bolder text-3xl">Size</p>
                                <div class="flex justify-center items-center">
                                    {{-- @if (count($sizes) <= 0)
                                        <h1 class="my-2 text-slate-600">
                                            Only available in <span class="bolder">{{ $product['size'] }}</span> Size
                                        </h1>
                                    @endif --}}
                                    @foreach ($sizes as $size)
                                        <div title="{{ $size->name }}" class="p-1 px-2 m-1 border border-slate-500">
                                            {{ strtoupper($size->symbol) }}
                                        </div>
                                    @endforeach
                                    <div title="{{ $product->size }}" class="p-1 px-2 m-1 border border-slate-500">
                                        {{ strtoupper($product->symbol) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-to-cart border-b-2 border-b-slate-400">
                        <div class="content py-5">
                            <p class="mb-5">
                                {{ $product['description'] }}
                            </p>
                            <h1 class="text-xl">Availability</h1>
                            <h2 class="text-2xl bolder">{{ $product['availability'] }}</h2>
                        </div>
                    </div>
                    <div class="more-information py-5 border-b-2 border-b-slate-400">
                        <h2 class="text-2xl bolder">More Information</h2>
                        <div class="py-5 flex w-full justify-baseline">
                            <div class="titles space-y-2 w-[25%]">
                                <p>Color :</p>
                                <p>Sub-Category :</p>
                                <p>Febric Type :</p>
                                <p>Design Type :</p>
                                <p>Season :</p>
                                <p>Occasion :</p>
                                <p>Outfit :</p>
                                <p>Disclaimer :</p>
                            </div>
                            <div class="mx-20 values space-y-2 w-[75%]">
                                <p>{{ $product['color'] }}</p>
                                <p>{{ $subCategory['name'] }}</p>
                                <p>{{ $product['febric'] }}</p>
                                <p>{{ $product['design'] }}</p>
                                <p>{{ $product['season'] }}</p>
                                <p>{{ $product['occasion'] }}</p>
                                <p>{{ $product['outfit'] }}</p>
                                <p>Due to photographic lighting and different screen callibrations, the color of the
                                    original product may vary from picture</p>
                            </div>
                        </div>
                        <h2 class="text-2xl bolder">Matching Items</h2>
                        <div class="items my-5">
                            @foreach ($addOns as $feature)
                                <div class="flex justify-start items-center my-5 border p-3 border-slate-300">
                                    <div class="image-data mx-3 w-[25%]">
                                        <img src="{{ asset($feature->image) }}" alt="Image not Loaded"
                                            class="w-fit">
                                    </div>
                                    <div class="data mx-3 w-[75%]">
                                        <p class="text-2xl my-2 text-redish bolder">{{ $feature->name }}</p>
                                        <hr class="w-full my-5 border border-slate-300 bg-slate-300" />
                                        <p>Price: <span class="my-5  bolder"> Rs. {{ $feature->price }}</span></p>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admins.flash')
    <script>
        function updateImageContent(div) {
            document.querySelector("img.main-image").src = div.querySelector("img").src;
        }
    </script>
</body>

</html>
