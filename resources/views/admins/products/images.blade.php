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
        <div class="main shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <form action="/admin/products/images/{{ $product['id'] }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-4 ">
                @csrf
                @method('post')
                <div class="form-group m-2 col-span-4 md:col-span-4">
                    <p class="text-3xl">{{ $product['name'] }}</p>
                </div>
                <input type="hidden" class="hidden" value="{{$product['id']}}" name="product_id">
                <div class="form-group m-2 col-span-4 md:col-span-4">
                    <label for="image">Product Images <span class="text-redish">(multiple selection
                            enabled)</span></label>
                    <input type="file" name="images[]" multiple accept=".jpg,.png,.jpeg" max="10"
                        maxlength="10" id="image" class="input-control fileSelector">
                    @error('images')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    @session('error')
                        <span class="text-redish w-full"> {{ session('error') }}</span>
                    @endsession
                </div>
                <div class="grouped-btns m-2 col-span-1 md:col-span-4">
                    <button type="reset" onclick="document.querySelector('.image-container').innerHTML = '';"
                        class="secondary-btn rounded-l-md">Reset</button>
                    <button type="submit" class="primary-btn rounded-r-md">Upload</button>
                </div>
            </form>
        </div>
        <div class="main shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <h1 class="text-2xl">Peview Selected Images</h1>
            <div class="image-container grid grid-cols-4 gap-5 my-3"></div>
        </div>
        <div class="main shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <h1 class="text-2xl">Previously Uploaded Images</h1>
            <div class="product-image-container grid grid-cols-4 gap-5 my-3">
                @if (!empty($images))
                    @foreach ($images as $image)
                    <div class="product_image_preview">
                        <img src="{{asset($image->location)}}" alt="Product Image" class="">
                        <a href="/admin/products/{{$product['id']}}/images/delete/{{$image->id}}" class="secondary-btn w-full block text-center">Remove</a>
                    </div>
                    @endforeach
                @else
                    <h1 class="text-xl p-5 text-slate-600">No Images added yet</h1>
                @endif
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
        </script>
</body>

</html>
