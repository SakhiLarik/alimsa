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
            Create Category
        </h1>
        <div class="main w-full lg:w-[60%] shadow-lg border border-slate-200 shadow-slate-200 my-10 p-10 rounded">
            <form action="/admin/categories/store" method="POST" enctype="multipart/form-data" class="grid grid-cols-4  ">
                @csrf
                @method('post')
                <div class="form-group m-2 col-span-4">
                    <label for="name">Category Name <span class="text-redish">*</span></label>
                    <input type="text" name="name" id="name" class="input-control" spellcheck="false"
                        autofocus="true" autocomplete="none" placeholder="Enter Name of the Category" required
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4">
                    <label for="sub_category">Sub-Category Name <span class="text-redish">*</span></label>
                    <input type="text" name="sub_category" id="sub_category" value="{{ old('sub_category') }}" required
                        class="input-control" placeholder="Sub Category Name">
                    @error('sub_category')
                        <span class="text-redish  w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4">
                    <label for="description">Description <span class="text-redish">*</span></label>
                    <textarea rows="3" name="description" id="description" class="input-control" required
                        spellcheck="true" placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-2 col-span-4 md:col-span-2">
                    @session('error')
                        <span class="text-redish w-full"> {{ session('error') }}</span>
                    @endsession
                </div>
                <div class="form-group m-2 col-span-4 flex">
                    <button type="reset" class="form-secondary-btn ">Reset</button>
                    <button type="submit" class="form-primary-btn ">Create</button>
                </div>
            </form>
        </div>
    </div>
    @include("admins.flash")
</body>

</html>

