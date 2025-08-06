@php
use App\Models\Product;
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
        <div class="header flex justify-between items-center">
            <h1 class="text-2xl md:text-3xl">
                Add On Management
            </h1>
            <div class="btn-group hidden md:block">
                <a href="/admin/addons/create" title="Create Add On" class="hidden md:block primary-btn">
                    <span class="">Create Add On</span>
                </a>
            </div>
            <div class="btn-group block md:hidden">
                <a href="/admin/addons/create" title="Create Add On" class="block md:hidden primary-btn">
                    <span class="fa fas fa-plus"></span>
                </a>
            </div>
        </div>
            <div class="container search-container my-5">
            <form action="/admin/addons/search" method="post" class="grouped-btns items-center justify-center">
                @csrf
                @method('post')
                <input type="text" class="input-search" value="{{ $search }}" placeholder="Search by name..."
                    name="search">
                <input type="submit" name="submit" id="" value="Search"
                    class="secondary-btn hidden lg:block lg:text-lg">
                <button type="submit" name="submit" id="" class="secondary-btn block lg:hidden"><i
                        class="fa fa-search"></i></button>
                <a href="/admin/addons/" class="primary-btn text-lg hidden lg:block">Reset</a>
            </form>
        </div>
        <div class="list-products">
            <div class="card-container grid grid-cols-4">
                @if (count($addOns) > 0)
                    @foreach ($addOns as $index => $addOn)
                      @php
                            $productID = $addOn->product;
                            $product = Product::find($productID);
                        @endphp
                        <div class="card col-span-4 md:col-span-1 h-fit">
                            <div class="card-head border-b-2 border-b-slate-300 py-2">
                                <h1 class="text-2xl bolder">{{ $addOn['name'] }}</h1>
                                {{-- <p class="text-redish">Rs. {{ $addOn['price'] }} </p> --}}
                            </div>
                            <div class="card-body py-3 ">
                                <div class="card-image">
                                    <img class="w-full h-64" src="{{ asset($addOn['image']) }}" alt="Image not loaded">
                                </div>
                                <div class="card-content p-2 py-4 my-5  border-t border-b border-slate-300">
                                    <p>Product:  <span class="bolder text-redish"> {{ $product['name'] }}</span></p>
                                    {{-- <p>Size:  <span class="bolder"> {{ $addOn['size'] }}</span></p> --}}
                                    <p>Price:  <span class="bolder"> {{ $addOn['price'] }}</span></p>
                                </div>
                            </div>
                            <div class="">
                                <div class="grouped-btns">
                                    <a href="#" onclick="deleteItem('/admin/addons/delete/{{$addOn['id']}}')" class="secondary-btn ">Delete</a>
                                    <a href="/admin/addons/edit/{{$addOn['id']}}" class="warning-btn ">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h1 class="text-xl text-slate-600 p-5 col-span-4 w-fit">No product found in your shop. </h1>
                @endif
                {{-- <div class="md:hidden my-10">
                    <a href="/admin/categories/create" class=" primary-btn w-full">
                        <span class="">Add Category</span>
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
