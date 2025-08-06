<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <h1 class="text-3xl">
            Manage Home Page
        </h1>
        <div class="container">
            <form action="/admin/settings/update" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="container header-settings">
                    <h1 class="text-xl my-5 text-gray-500">Header Settings</h1>
                    <hr class="bg-slate-400 border-slate-400" />
                    <div class="form-group my-2">
                        <label for="">Header Top Text<span class="text-redish"> * </span> </label>
                        <input type="text" value="@if($settings != null){{$settings->header_extra}}@endif" class="input-control" placeholder="Men's, Women's, New etc."
                            name="header_extra">
                            @error('header_extra')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Header Title Text<span class="text-redish"> * </span> </label>
                        <input type="text" class="input-control"  value="@if($settings != null){{$settings->header_title}}@endif" placeholder="Festive, Summer, Winter, Perfume etc."
                            name="header_title">
                            @error('header_title')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Header Para Text<span class="text-redish"> * </span> </label>
                        <input type="text" class="input-control"  value="@if($settings != null){{$settings->header_text}}@endif" placeholder="Collection, Bundles etc."
                            name="header_text">
                            @error('header_text')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Header Image<span class="text-redish"> * </span> </label>
                        <input type="file" oninput="imageChanges('header',this)" accept=".jpg,.png" class="input-control" value="@if($settings != null){{$settings->header_image}}@endif"  name="header_image">
                        @error('header_image')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <center>
                        <img src="@if($settings != null) {{asset($settings->header_image)}}@endif" alt="Header Image" class="rounded w-full shadow-lg shadow-slate-300 p-5">
                    </center>
                </div>

                <div class="container primary-settings">
                    <h1 class="text-xl my-5 text-gray-500">Primary Section Settings</h1>
                    <hr class="bg-slate-400 border-slate-400" />
                    <div class="form-group my-2">
                        <label for="">Primary Title Text<span class="text-redish"> * </span> </label>
                        <input type="text" value="@if($settings != null){{$settings->primary_title}} @endif" class="input-control" placeholder="We Provide 100% Cotton"
                            name="primary_title">
                            @error('primary_title')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Primary Para Text<span class="text-redish"> * </span> </label>
                        <input type="text" value="@if($settings != null){{$settings->primary_text}} @endif" class="input-control" placeholder="Detailed explaination about the title above."
                            name="primary_text">
                             @error('primary_text')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Primary Image<span class="text-redish"> * </span> </label>
                        <input type="file" oninput="imageChanges('primary',this)" accept=".jpg,.png" class="input-control" value="@if($settings != null){{$settings->primary_image}}@endif"   name="primary_image">
                         @error('primary_image')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                     <center>
                        <img src="@if($settings != null) {{asset($settings->primary_image)}}@endif" alt="Primary Image" class="rounded w-full shadow-lg shadow-slate-300 p-5">
                    </center>
                </div>

                 <div class="container secondary-settings">
                    <h1 class="text-xl my-5 text-gray-500">Secondary Section Settings</h1>
                    <hr class="bg-slate-400 border-slate-400" />
                    <div class="form-group my-2">
                        <label for="">Secondary Title Text<span class="text-redish"> * </span> </label>
                        <input type="text" class="input-control" value="@if($settings != null){{$settings->secondary_title}} @endif" placeholder="We Focus Client Satisification"
                            name="secondary_title">
                             @error('secondary_title')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Secondary Para Text<span class="text-redish"> * </span> </label>
                        <input type="text" class="input-control" value="@if($settings != null){{$settings->secondary_text}} @endif" placeholder="Detailed explaination about the title above."
                            name="secondary_text">
                            @error('secondary_text')
                                <p class="text-redish">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group my-2">
                        <label for="">Secondary Image<span class="text-redish"> * </span> </label>
                        <input oninput="imageChanges('secondary',this)" type="file" value="@if($settings != null){{$settings->secondary_image}}@endif"   accept=".jpg,.png" class="input-control" name="secondary_image">
                        @error('secondary_image')
                                <p class="text-redish">{{$message}}</p>
                        @enderror
                    </div>

                     <center>
                        <img src="@if($settings != null) {{asset($settings->secondary_image)}}@endif" alt="Secondary Image" class="rounded w-full shadow-lg shadow-slate-300 p-5">
                    </center>
                </div>
                @session('error')
                    <p class="text-redish">{{session('error')}}</p>
                @endsession
                <div class="container my-5">
                    <button class="primary-btn btn-primary block w-full">Submit & Save </button>
                </div>
            </form>
        </div>
    </div>

    @include('admins.flash')
    <script>
        function imageChanges(imgClass, inputFile){
            let imgClasses = ['header','primary','secondary'];
            let imgs = document.querySelectorAll('img');
            let changeImage = imgs[imgClasses.indexOf(imgClass)];
            inputFile.addEventListener('change',(e)=>{
                changeImage.src = URL.createObjectURL(e.target.files[0]);
            });
        }
    </script>
</body>

</html>
