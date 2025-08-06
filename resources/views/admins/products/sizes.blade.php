<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <div class="spacer"></div>
        {{-- <div class="header flex justify-between items-center">
            <h1 class="text-2xl md:text-3xl">
                Product Management
            </h1>
        </div> --}}
        <div class="main shadow-lg border border-slate-200 shadow-slate-200 my-5 p-5 rounded">
            <form action="/admin/products/sizes/{{ $product['id'] }}" method="POST" enctype="multipart/form-data"
                class="form">
                @csrf
                @method('post')
                <div class="form-group m-2 col-span-4">
                    <p class="text-3xl">{{ $product['name'] }}</p>
                </div>
                <div class="form-variations-container">
                    <div
                        class="border grid grid-cols-4 border-slate-400 p-5 m-5 shadow-lg rounded my-10 sizeFormFields">
                        <input type="hidden" class="hidden" value="{{ $product['id'] }}" name="product_id">
                        <div class="form-group m-2 col-span-4 md:col-span-2">
                            <label for="name">Name <span class="text-redish">*</span></label>
                            <input type="text" name="names[]" id="names" class="input-control"
                                placeholder="Small, Medium, Large, etc.">
                            @error('names')
                                <span class="text-redish w-full"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group m-2 col-span-4 md:col-span-2">
                            <label for="symbols">Symbol <span class="text-redish"> *</span></label>
                            <input type="text" name="symbols[]" id="symbols" class="input-control"
                                placeholder="xl, xs, sm, md, lg, xxl, etc.">
                            @error('symbols')
                                <span class="text-redish w-full"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group m-2 col-span-4 md:col-span-2">
                            <label for="prices">Price <span class="text-redish"> *</span></label>
                            <input type="number" name="prices[]" id="prices" class="input-control"
                                placeholder="Numbers only">
                            @error('prices')
                                <span class="text-redish w-full"> {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group m-2 col-span-4 md:col-span-2">
                            <label for="images">Product Images <span class="text-redish"> *</span></label>
                            <input type="file" name="images[]" accept=".jpg,.png,.jpeg" id="images"
                                class="input-control fileSelector">
                            @error('images')
                                <span class="text-redish w-full"> {{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="m-5 col-span-4">
                    <button type="button" onclick="addMoreVariations()" class="info-btn shadow-xl rounded-lg">Add More
                        Variations</button>
                </div>
                <div class="grouped-btns m-2 col-span-1 md:col-span-4">
                    <button type="reset" class="secondary-btn rounded-l-md">Reset</button>
                    <button type="submit" class="primary-btn rounded-r-md">Submit and Save</button>
                </div>
            </form>
        </div>
        <div class="shadow-lg border border-slate-200 shadow-slate-200 my-10 p-5 rounded w-full">
            <h1 class="text-2xl mb-5">Previously Added Sizes</h1>
            <div class="list-products">
                <div class="w-full">
                    <table class="table-auto table table-bordered w-fit text-center">
                        <thead>
                            <tr class="">
                                <th class="th-settings bolder">Sr#</th>
                                <th class="th-settings bolder">Name</th>
                                <th class="th-settings bolder">Price</th>
                                <th class="th-settings bolder">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($sizes))
                                @foreach ($sizes as $index => $size)
                                    <tr>
                                        <td class="td-settings bolder">{{ $index + 1 }}</td>
                                        <td class="td-settings bolder">{{ $size->name }}({{ strtoupper($size->symbol) }})</td>
                                        <td class="td-settings bolder">
                                            Rs. {{ $size->price }}
                                        </td>
                                        <td class=" td-settings">
                                            <div class="grouped-btns">
                                                {{-- <a href="/admin/products/create/{{$categoryId}}" class="primary-btn rounded-l"><i class="fa fa-plus"></i></a> --}}
                                                <a href="#"
                                                    onclick="deleteItem('/admin/products/{{ $product['id'] }}/sizes/delete/{{ $size->id }}');"
                                                    class="secondary-btn rounded-l"><i class="fa fa-trash"></i></a>
                                                <a href="#" onclick="editSize({{ json_encode($size) }})"
                                                    class="warning-btn rounded-r"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h1 class="text-3xl text-gray-500">No Product Sizes addded yet</h1>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-variations-sample hidden">
            <div class="node">
                <div class="border grid grid-cols-4 border-slate-400 p-5 m-5 shadow-lg rounded my-10 sizeFormFields">
                    <input type="hidden" class="hidden" value="{{ $product['id'] }}" name="product_id">
                    <div class="form-group m-2 col-span-4 md:col-span-2">
                        <label for="name">Name <span class="text-redish">*</span></label>
                        <input type="text" name="names[]" id="names" class="input-control"
                            placeholder="Small, Medium, Large, etc.">
                        @error('names')
                            <span class="text-redish w-full"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group m-2 col-span-4 md:col-span-2">
                        <label for="symbols">Symbol <span class="text-redish"> *</span></label>
                        <input type="text" name="symbols[]" id="symbols" class="input-control"
                            placeholder="xl, xs, sm, md, lg, xxl, etc.">
                        @error('symbols')
                            <span class="text-redish w-full"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group m-2 col-span-4 md:col-span-2">
                        <label for="prices">Price <span class="text-redish"> *</span></label>
                        <input type="number" name="prices[]" id="prices" class="input-control"
                            placeholder="Numbers only">
                        @error('prices')
                            <span class="text-redish w-full"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group m-2 col-span-4 md:col-span-2">
                        <label for="images">Product Images <span class="text-redish"> *</span></label>
                        <input type="file" name="images[]" accept=".jpg,.png,.jpeg" id="images"
                            class="input-control fileSelector">
                        @error('images')
                            <span class="text-redish w-full"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="modal edit-item-modal hidden">
            <div class="edit-modal-container p-5">
                <div class="modal-content p-5 ">
                    <h1
                        class="text-2xl font-bold flex justify-between items-center pb-4 border-b-2 border-b-slate-300 text-slate-800">
                        <span>Update Information ({{ $product['name'] }})</span>
                        <span class="cursor-pointer" onclick="editSize(null)"><i
                                class="fa fa-times text-3xl text-redish"></i></span>
                    </h1>
                    <form method="POST" enctype="multipart/form-data" action="/admin/products/update_sizes/update/"
                        class="form updateSizeForm">
                        @csrf
                        @method('post')
                        <div class="form-variations-container">
                            <div class="p-10 grid grid-cols-4 sizeFormFields">
                                <input type="text" class="hidden" value="{{ $product['id'] }}"
                                    name="product_id">
                                <input type="text" class="hidden" value="" name="size_id">
                                <div class="form-group m-2 col-span-4 md:col-span-2">
                                    <label for="name">Name <span class="text-redish">*</span></label>
                                    <input type="text" name="name" id="names" class="input-control"
                                        placeholder="Small, Medium, Large, etc." value="">
                                    @error('name')
                                        <span class="text-redish w-full"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group m-2 col-span-4 md:col-span-2">
                                    <label for="symbols">Symbol <span class="text-redish"> *</span></label>
                                    <input type="text" name="symbol" id="symbols" class="input-control"
                                        placeholder="xl, xs, sm, md, lg, xxl, etc." value="">
                                    @error('symbol')
                                        <span class="text-redish w-full"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group m-2 col-span-4 md:col-span-2">
                                    <label for="prices">Price <span class="text-redish"> *</span></label>
                                    <input type="number" name="price" id="prices" class="input-control"
                                        placeholder="Numbers only" value="">
                                    @error('price')
                                        <span class="text-redish w-full"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group m-2 col-span-4 md:col-span-2">
                                    <label for="images">Product Images <span class="text-redish"> (Updates Previous
                                            Image)
                                        </span></label>
                                    <input type="file" name="image" accept=".jpg,.png,.jpeg" id="images"
                                        class="input-control fileSelector" value="">
                                    @error('image')
                                        <span class="text-redish w-full"> {{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="grouped-btns m-2 col-span-1 md:col-span-4">
                            <button type="reset" onclick="editSize(null)"
                                class="secondary-btn rounded-l-md">Cancel</button>
                            <button type="submit" class="primary-btn rounded-r-md">Submit and Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        @include('admins.flash')
        <script>
            let inputElement = document.querySelector("input.fileSelector");
            inputElement.addEventListener('change', (e) => {
                // console.log(e.target.files);
                // let classList = ['product_image_preview'];
                let container = document.querySelector(".image-container");
                container.innerHTML = "";
                for (file of e.target.files) {
                    let newFile = file;
                    let div = document.createElement('div');
                    let img = document.createElement('img');
                    let close = closeBtn(div, newFile);
                    div.classList.add('product_image_preview');
                    img.src = URL.createObjectURL(file);
                    div.appendChild(img);
                    div.appendChild(close);
                    container.appendChild(div);
                }
            });

            function closeBtn(div, newFile) {
                let close = document.createElement('button');
                close.innerHTML = "Remove";
                close.classList.add("secondary-btn");
                close.classList.add("block");
                close.classList.add("w-full");
                close.addEventListener("click", (e) => {
                    div.classList.add("hidden");
                    removeFile(newFile);
                });
                return close;
            }

            function removeFile(file) {
                const files = inputElement.files;
                const dataTransfer = new DataTransfer();
                for (let i = 0; i < files.length; i++) {
                    if (files[i] !== file) {
                        dataTransfer.items.add(files[i]);
                    }
                }
                inputElement.files = dataTransfer.files;
            }

            const sample = document.querySelector(".form-variations-sample");

            function addMoreVariations() {
                // form-variations-container
                // form-variations-sample
                let newSample = sample.cloneNode(true);
                newSample.classList.remove("hidden");

                document.querySelector(".form-variations-container").appendChild(newSample);
            }

            function editSize(size) {
                // alert(url);
                let modal = document.querySelector('.modal.edit-item-modal');
                if (modal.classList.contains("hidden")) {
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                } else {
                    modal.classList.add("hidden");
                    modal.classList.remove("flex");
                }
                if (size !== null) {
                    let updateSizeForm = document.querySelector(".updateSizeForm");
                    let [_token, _method, product_id, size_id, name, symbol, price, image] = updateSizeForm.querySelectorAll(
                        'input');

                    size_id.value = size.id;
                    name.value = size.name;
                    symbol.value = size.symbol;
                    price.value = size.price;
                    console.log(size_id);

                    // console.log(size.name);
                }
                // document.querySelector('.deleteItemLink').setAttribute('href', url);
            }
        </script>
</body>

</html>
