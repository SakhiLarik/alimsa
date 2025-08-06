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
            Edit Product
        </h1>
        <div class="main shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <form action="/admin/products/update" method="POST" enctype="multipart/form-data" class="grid grid-cols-4 ">
                @csrf
                @method('post')
                <input type="hidden" name="id" value="{{ $product['id'] }}">
                <div class="form-group m-2 col-span-4 md:col-span-4">
                    <label class="bolder" for="type">Select Product Type <span class="text-redish">*</span></label>
                    <select name="type" onchange="setAsPerfume(this.value)" id="type" class="input-control" value="{{ $product['type'] }}">
                        <option  @if ($product->is_perfume == 0) selected @endif  @if (old('type') == 0) selected @endif  value="0">Clothing Item</option>
                        <option  @if ($product->is_perfume == 1) selected @endif  @if (old('type') == 1) selected @endif  value="1">Perfume Item</option>
                    </select>
                    @error('type')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    <label for="name">Product Name <span class="text-redish">*</span></label>
                    <input type="text" name="name" id="name" class="input-control" spellcheck="false"
                        autofocus autocomplete="none" placeholder="Enter product name" value="{{ $product['name'] }}">
                    @error('name')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    <label for="color">Product Color <span class="text-redish">*</span></label>
                    <input type="text" name="color" id="color" class="input-control"
                        placeholder="Magenta, SeaGreen, Yellow etc." value="{{ $product['color'] }}">
                    @error('color')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    <label for="category">Select Category <span class="text-redish">*</span></label>
                    <select onchange="fetchSubCategories(this.value)" name="category" id="category" min="1"
                        minlength="1" class="input-control">
                        <option value="">-- Select Category -- </option>
                        @foreach ($categories as $category)
                            <option @if ($product['category'] == $category['id']) selected @endif @if (old('category') == $category['id']) selected @endif value="{{ $category['id'] }}">
                                {{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    <label for="sub_category">Select Sub Category <span class="text-redish">*</span></label>
                    <select name="sub_category" id="sub_category" min="1" minlength="1"
                        class="input-control sub_category" value="{{ $product['sub_category'] }}">
                        <option value="0">-- Select Sub Category -- </option>
                        {{-- @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach --}}
                    </select>
                    @error('sub_category')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="size">Product Size (Default) <span class="text-redish">*</span></label>
                    <input type="text" name="size" id="size" class="input-control"
                        placeholder="Small, Large, Extra Large etc." value="{{ $product['size'] }}">
                    @error('size')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="symbol">Size Symbol (Default) <span class="text-redish">*</span></label>
                    <input type="text" name="symbol" id="symbol" class="input-control"
                        placeholder="xs, sm, md, lg, xl, xxl etc." value="{{ $product['symbol'] }}">
                    @error('symbol')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="price">Product Price (Default) <span class="text-redish">*</span></label>
                    <input type="number" name="price" id="price" class="input-control" placeholder="Numbers Only"
                        value="{{ $product['price'] }}">
                    @error('price')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="gender">Gender <span class="text-redish">*</span></label>
                    <select name="gender" id="gender" class="input-control" value="{{ $product['gender'] }}">
                        <option @if ($product['gender'] == 'Male & Female') selected @endif value="Male & Female"> Male & Female
                        </option>
                        <option @if ($product['gender'] == 'Male') selected @endif value="Male"> Male </option>
                        <option @if ($product['gender'] == 'Female') selected @endif value="Female"> Female </option>
                    </select>
                    @error('gender')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="febric">Febric Type<span class="text-redish">*</span></label>
                    <input type="text" name="febric" id="febric" class="input-control clothSettings disabled:bg-gray-300"
                        value="{{ $product['febric'] }}" />
                    @error('febric')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="design">Design Type <span class="text-redish">*</span></label>
                    <select name="design" id="design" class="input-control clothSettings disabled:bg-gray-300" value="{{ $product['design'] }}">
                        <option @if ($product['gender'] == 'Printed') selected @endif value="Printed"> Printed </option>
                        <option @if ($product['gender'] == 'Embroidered') selected @endif value="Embroidered"> Embroidered
                        </option>
                        <option @if ($product['gender'] == 'Solid') selected @endif value="Solid"> Solid </option>
                    </select>
                    @error('design')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="outfit">Outfit Type <span class="text-redish">*</span></label>
                    <select name="outfit" id="outfit" class="input-control clothSettings disabled:bg-gray-300" value="{{ $product['outfit'] }}">
                        <option @if ($product['outfit'] == '2-Piece') selected @endif value="2-Piece"> 2-Piece </option>
                        <option @if ($product['outfit'] == '3-Piece') selected @endif  value="3-Piece"> 3-Piece </option>
                    </select>
                    @error('outfit')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="season">Season <span class="text-redish">*</span></label>
                    <select name="season" id="season" class="input-control clothSettings disabled:bg-gray-300" value="{{ $product['season'] }}">
                        <option @if ($product['season'] == 'All Seasons') selected @endif value="All Seasons"> All Seasons </option>
                        <option @if ($product['season'] == 'Summer') selected @endif  value="Summer"> Summer </option>
                        <option @if ($product['season'] == 'Winter') selected @endif  value="Winter"> Winter </option>
                    </select>
                    @error('season')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="occasion">Occasion <span class="text-redish">*</span></label>
                    <select name="occasion" id="occasion" class="input-control clothSettings disabled:bg-gray-300" value="{{ $product['occasion'] }}">
                        <option @if ($product['occasion'] == 'Casual') selected @endif value="Casual"> Casual </option>
                        <option @if ($product['occasion'] == 'Formal') selected @endif  value="Formal"> Formal </option>
                        <option @if ($product['occasion'] == 'Festive') selected @endif  value="Festive"> Festive </option>
                        <option @if ($product['occasion'] == 'Daily Wear') selected @endif  value="Daily Wear"> Daily Wear </option>
                    </select>
                    @error('occasion')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    <label for="availability">Availability <span class="text-redish">*</span></label>
                    <select name="availability" id="availability" class="input-control"
                        value="{{ $product['availability'] }}">
                        <option  @if ($product['availability'] == 'In Stock') selected @endif  value="In Stock"> In Stock </option>
                        <option  @if ($product['availability'] == 'Out of Stock') selected @endif value="Out Stock"> Out of Stock </option>
                    </select>
                    @error('occasion')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group m-2 col-span-4 md:col-span-2">
                    <label for="image">Product Image <span class="text-redish">*</span></label>
                    <input type="file" accept=".jpg,.png,.jpeg" name="image" id="image"
                        class="input-control">
                    @error('image')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-4">
                    <label for="price">Product Description <span class="text-redish">*</span></label>
                    <textarea rows="5" name="description" id="description" class="input-control"
                        placeholder="Detailed description of your product...">{{ $product['description'] }}</textarea>
                    @error('description')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2 lg:col-span-1">
                    @session('error')
                        <span class="text-redish w-full"> {{ session('error') }}</span>
                    @endsession
                </div>
                <div class="grouped-btns m-2 col-span-1 md:col-span-4">
                    <button type="reset" class="secondary-btn rounded-l-md">Reset</button>
                    <button type="submit" class="primary-btn rounded-r-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    @include('admins.flash')

    <script>
        function fetchSubCategories(id) {
            let select = document.querySelector('.sub_category');
            if (parseInt(id) > 0 || id !== "" || id.length > 0) {
                // /admin/sub_categories/fetch/{id}
                let xhr = new XMLHttpRequest();
                xhr.open("GET", `/admin/sub_categories/fetch/${id}`, false);
                xhr.onload = function() {
                    // console.log(this.responseText);
                    if (this.responseText.length > 0) {
                        select.innerHTML = "<option value='0'>-- Select Sub Category -- </option>";
                        let Fetched = JSON.parse(this.responseText);
                        for (data of Fetched) {
                            // // console.log(data);
                            select.innerHTML += `<option value="${data.id}"> ${data.name} </option>`;
                        }
                    }
                }
                xhr.send();
            } else {
                select.innerHTML = html;
            }

        }
        fetchSubCategories({{$product['category']}});

        function setAsPerfume(item){
            let clothSettings = document.querySelectorAll(".clothSettings");
            console.log("Working...");

            if(item == 1){
                // Perfumes
                clothSettings.forEach(element => {
                    console.log("Disabled");
                    element.setAttribute("disabled", true);
                });

            }else{
                // Clothes
                clothSettings.forEach(element => {
                    console.log("Enabled");
                    element.removeAttribute("disabled");
                });
            }
        }
    </script>

  @if ($product->is_perfume == 1)
        <script>
            setAsPerfume(1);
        </script>
    @endif
</body>

</html>
