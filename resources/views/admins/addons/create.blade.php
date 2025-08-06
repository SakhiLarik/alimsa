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
            Create Add On
        </h1>
        <div class="main w-full lg:w-[50%] shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <form action="/admin/addons/store" method="POST" enctype="multipart/form-data" class="grid grid-cols-4 ">
                @csrf
                @method('post')

                <div class="form-group m-2 col-span-4">
                    <label for="product">Select Product <span class="text-redish">*</span></label>
                    <select name="product" id="product" min="1" required minlength="1" class="input-control"
                        value="{{ old('product') }}">
                        <option value="">-- Select Product -- </option>
                        @foreach ($products as $product)
                            <option
                                @if (isset($product_id) && $product_id == $product['id']) selected @endif
                                @if (old('product') == $product['id']) selected @endif
                                value="{{ $product['id'] }}">
                                {{ $product['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('product')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4">
                    <label for="name">Name <span class="text-redish">*</span></label>
                    <input type="text" name="name" id="name" class="input-control" spellcheck="false"
                        autofocus autocomplete="none" placeholder="Enter product name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group m-2 col-span-4 ">
                    <label for="size">Product Size (Default) <span class="text-redish">*</span></label>
                    <input type="text" name="size" id="size" class="input-control"
                        placeholder="Small, Large, Extra Large etc." value="{{ old('size') }}">
                    @error('size')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group m-2 col-span-4">
                    <label for="price">Product Price (Default) <span class="text-redish">*</span></label>
                    <input type="number" name="price" id="price" class="input-control" placeholder="Numbers Only"
                        value="{{ old('price') }}">
                    @error('price')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 ">
                    <label for="image">Product Image <span class="text-redish">*</span></label>
                    <input type="file" accept=".jpg,.png,.jpeg" name="image" id="image" class="input-control">
                    @error('image')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 ">
                    @session('error')
                        <span class="text-redish w-full"> {{ session('error') }}</span>
                    @endsession
                </div>
                <div class="grouped-btns m-2 col-span-4">
                    <button type="reset" class="secondary-btn rounded-l-md">Reset</button>
                    <button type="submit" class="primary-btn rounded-r-md">Create</button>
                </div>
            </form>
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
