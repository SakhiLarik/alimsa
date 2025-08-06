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
            Edit Category
        </h1>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-5">
        <div class="main col-span-1 shadow-lg border border-slate-300 shadow-slate-200 my-10 p-10 rounded">
            <form action="/admin/categories/update" method="POST" enctype="multipart/form-data" class="grid grid-cols-4  ">
                @csrf
                @method('post')
                <input type="hidden" name="id" id="id" value="{{$category['id']}}">
                <div class="form-group my-2 col-span-4">
                    <label for="name">Category Name <span class="text-redish">*</span></label>
                    <input type="text" name="name" id="name" class="input-control" spellcheck="false"
                        autofocus="true" autocomplete="none" placeholder="Enter Name of the Category"minlength="8"
                        required value="{{ $category['name'] }}">
                    @error('name')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2 col-span-4">
                    <label for="description">Description <span class="text-redish">*</span></label>
                    <textarea rows="3" name="description" id="description" class="input-control" minlength="8" required
                        spellcheck="true" placeholder="Description">{{ $category['description'] }}</textarea>
                    @error('description')
                        <span class="text-redish w-full"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group my-2 col-span-4 flex">
                    <button type="reset" class="form-secondary-btn ">Reset</button>
                    <button type="submit" class="form-primary-btn ">Update</button>
                </div>
            </form>
        </div>
        <div class="col-span-1 py-10">
            <h1 class="text-2xl mb-4">Sub-Categories</h1>
            <div class="main shadow border border-slate-100 table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th class="th-settings">Sr#</th>
                            <th class="th-settings">Name</th>
                            <th class="th-settings">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subCategories as $index => $item)
                            <tr>
                                <td class="td-settings">{{$index+1}}</td>
                                <td class="td-settings">{{$item->name}}</td>
                                <td class="td-settings">
                                    <a href="/admin/categories/{{$category->id}}/sub/delete/{{$item->id}}" class="secondary-btn">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    @include("admins.flash")
</body>

</html>
