<!DOCTYPE html>
<html lang="en">

@include('head')

<body class="font-sans antialiased  text-gray-800">

    <!-- Top Bar -->
    {{-- <div class="bg-blue-900 text-white text-sm text-center py-2">
        FREE DELIVERY FOR ORDERS RS. 1500 & ABOVE - Applicable in Pakistan
    </div> --}}

    <!-- Navbar -->
    @include('nav')

    <!-- Hero Section -->
    <section class="lg:flex justify-between mx-10 items-center block">
        <div class="top-1/4 left-10 col-span-6 text-center flex justify-center w-[100%]">
            <div class="p-10">
                <h2 class="lg:text-5xl md:text-4xl text-3xl font-light">
                    @if($settings!=null){{ strtoupper($settings->header_extra) }}@else MEN'S @endif
                </h2>
                <h1 class="lg:text-8xl md:text-6xl text-5xl" style="font-weight:700;">
                    @if($settings!=null){{ strtoupper($settings->header_title) }}@else FESTIVE @endif
                </h1>
                <h2 class="lg:text-5xl md:text-4xl text-3xl" style="letter-spacing: 6px;">
                    @if($settings!=null){{ strtoupper($settings->header_text) }}@else COLLECTION @endif
                </h2>
                <p class="text-lg my-5 font-medium">IN STORES & ONLINE</p>
            </div>
        </div>
        <img src="@if($settings!=null){{ asset($settings->header_image) }}@else {{asset('images/header.png')}} @endif" alt="Men's Festive" class=" w-full h-100 col-span-6">
    </section>

    <!-- Collection Sections -->
    <section class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10">
        <div>
            <img src="@if($settings!=null){{ asset($settings->primary_image) }}@else {{asset('images/1.png')}} @endif" alt="">
        </div>
        <div class="flex flex-col justify-center space-y-4">
            <h3 class="text-2xl font-bold">
                @if($settings!=null){{ $settings->primary_title }}@else Summer Collection' 21 @endif
            </h3>
            <p class="text-gray-600">
                @if($settings!=null){{ $settings->primary_text }}
                @else
                    Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna.
                @endif

            </p>
        </div>

        <div class="flex flex-col justify-center space-y-4 order-2 md:order-none">
            <h3 class="text-2xl font-bold">
                @if($settings!=null){{ $settings->secondary_title }}@else Ready To Wear @endif
            </h3>
            <p class="text-gray-600">
                @if($settings!=null){{ $settings->secondary_text }}
                @else
                    Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna.
                @endif
            </p>
        </div>
        <div>
            <img src="@if($settings!=null){{ asset($settings->primary_image) }}@else {{asset('images/2.png')}} @endif" alt="">
        </div>
    </section>

    <!-- Product Grid -->
    <section class=" mx-auto px-4 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($images as $image)
                <div class="text-center border shadow-l shadow-gray-200">
                    <img src="{{ asset($image->location) }}" class="w-full h-96 object-cover">
                    <a href="/product/details/{{$image->product_id}}" class=" text-white p-2 bg-redish bg-primary-hover transition-all duration-300 block font-semibold">Details</a>
                </div>
            @endforeach
        </div>
    </section>
    @include("newsletter")
    <!-- Footer -->
    @include('footer')

</body>

</html>
