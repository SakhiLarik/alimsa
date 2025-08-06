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
                Product Management
            </h1>
            <div class="btn-group hidden md:block">
                <a href="/admin/products/create" title="Add Product" class="hidden md:block primary-btn">
                    <span class="">Create Product</span>
                </a>
            </div>
            <div class="btn-group block md:hidden">
                <a href="/admin/products/create" title="Add Product" class="block md:hidden primary-btn">
                    <span class="fa fas fa-plus"></span>
                </a>
            </div>
        </div>
        <div class="container search-container my-5">
            <form action="/admin/products/search" method="post" class="grouped-btns items-center justify-center">
                @csrf
                @method('post')
                <div class="grid grid-cols-4">
                    <div class="col-span-4 md:col-span-2 m-2">
                        <input type="text" class="input-search" value="{{ $search }}"
                            placeholder="Search by name..." name="search">
                    </div>

                    <div class="col-span-4 md:col-span-1 m-2">
                        <select class="select-filter" name="type" id="">
                            <option  @if ($type == 0) selected @endif value="0">Clothes</option>
                            <option @if ($type == 1) selected @endif value="1">Perfumes</option>
                        </select>
                    </div>

                    <div class="col-span-4 md:col-span-1 m-2">
                        <select class="select-filter" name="category" id="">
                            @foreach ($categories as $category)
                                <option @if ($category->id == $searchedCategory) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-span-4 md:col-span-1 m-2">
                    <div class="grouped-btns">
                        <input type="submit" name="submit" id="" value="Search & Filter"
                            class="secondary-btn hidden lg:block ">
                        <button type="submit" name="submit" id="" class="secondary-btn block lg:hidden"><i
                                class="fa fa-search"></i></button>
                        <a href="/admin/products" class="primary-btn hidden lg:block">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="list-products">
            <div class="card-container grid grid-cols-6">
                @if (count($products)>0)
                    @foreach ($products as $index => $product)
                    {{-- @dd($product) --}}
                        <div class="card col-span-3 md:col-span-2 h-fit">
                            <a href="/admin/products/view/{{ $product->id }}">
                                <div class="card-head border-b-2 border-b-slate-300 py-2">
                                    <h1 class="text-2xl bolder">{{ $product->name }}</h1>
                                    <p class="text-redish bolder">Rs. {{ $product->price }} </p>
                                </div>
                                <div class="card-body py-3 ">
                                    <div class="card-image">
                                        <img class="w-full h-full" src="{{ asset($product->image) }}"
                                            alt="Image not loaded">
                                    </div>
                                    <div class="card-content p-2">
                                        <p class="text-redish bolder">Product ID: {{ $product->product_id }}</p>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                                <div class="card-footer pt-2 border-t-2 border-t-slate-300">
                                    <div class="grouped-btns wrap-anywhere flex-wrap gap-2">
                                        <a title="Product Images" href="/admin/products/images/{{ $product->id }}"
                                            class="primary-btn "><i class="fa fa-images"></i></a>
                                        <a title="Product Sizes" href="/admin/products/sizes/{{ $product->id }}"
                                            class="success-btn m-1 lg:mx-0 lg:m-0"><i class="fa fa-layer-group"></i></a>
                                        <a title="Delete Product"
                                            onclick="deleteItem('/admin/products/delete/{{ $product->id }}')"
                                            href="#" class="secondary-btn m-1 lg:mx-0 lg:m-0"><i
                                                class="fa fa-trash"></i></a>
                                        <a title="Edit Product" href="/admin/products/edit/{{ $product->id }}"
                                            class="warning-btn m-1 lg:mx-0 lg:m-0"><i class="fa fa-pencil"></i></a>
                                        <a title="Add On Feature"
                                            href="/admin/addons/create_with_product/{{ $product->id }}"
                                            class="primary-btn "><i class="fa fa-audio-description"></i></a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <h1 class="text-xl p-5 text-slate-600 col-span-4 w-fit">No products found in your shop. </h1>
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
