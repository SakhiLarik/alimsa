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
            <h1 class="text-xl md:text-3xl">
                Categories Management
            </h1>
            <div class="btn-group hidden md:block">
                <a href="/admin/categories/create" class=" primary-btn">
                    <span class="">Add Category</span>
                </a>
            </div>
        </div>
            <div class="container search-container my-5">
                <form action="/admin/categories/search" method="post" class="grouped-btns items-center justify-center">
                    @csrf
                    @method('post')
                    <input type="text" class="input-search" value="{{ $search }}"
                        placeholder="Search category by name or sub-category name..." name="search">
                    <input type="submit" name="submit" id="" value="Search"
                        class="secondary-btn hidden md:block md:text-lg">
                    <button type="submit" name="submit" id="" class="secondary-btn block md:hidden"><i
                            class="fa fa-search"></i></button>
                    <a href="/admin/categories" class="primary-btn text-lg">Reset</a>
                </form>
            </div>
            <div class="list-products">
            <div class="table-responsive">
                @if (isset($categories) && count($categories)>0)
                <table class="table-auto w-full">
                    <thead>
                        <tr class="">
                            <th class="th-settings">Sr#</th>
                            <th class="th-settings">Name</th>
                            <th class="th-settings">Sub-Categories</th>
                            <th class="th-settings">Description</th>
                            <th class="th-settings">Products</th>
                            <th class="th-settings">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td class="td-settings bolder text-center">{{ $index + 1 }}</td>
                                    <td class="td-settings">{{ $category->name }}</td>
                                    @php
                                        $categoryId = $category->id;
                                        $subCategories = DB::table('sub_categories')
                                            ->where('category', '=', $categoryId)
                                            ->get();
                                    @endphp
                                    <td class="td-settings">
                                        <ol class="p-5">
                                            @foreach ($subCategories as $subCategory)
                                                <li class=" list-decimal">{{ $subCategory->name }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td class="td-settings">{{ $category->description }}
                                    </td>

                                    <td class="td-settings bolder text-center">
                                        @php
                                            $categoryId = $category->id;
                                            $productsCount = count(
                                                DB::table('products')->where('category', '=', $categoryId)->get(),
                                            );
                                            echo $productsCount;
                                        @endphp
                                    </td>

                                    <td class=" td-settings">
                                        <div class="grouped-btns">
                                            <a onclick="addCategory('{{ $categoryId }}');" href="#"
                                                title="Add Sub-category" class="primary-btn rounded-l"><i
                                                    class="fa fa-plus"></i></a>
                                            <a title="Delete Category" href="#"
                                                onclick="deleteItem('/admin/categories/delete/{{ $categoryId }}');"
                                                class="secondary-btn"><i class="fa fa-trash"></i></a>
                                            <a title="Edit Category" href="/admin/categories/edit/{{ $categoryId }}"
                                                class="warning-btn rounded-r"><i class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <h1 class="text-xl p-5 text-slate-600 col-span-4 w-fit">No categories found in your shop. </h1>
                        </tbody>
                    </table>
                        @endif
                <div class="md:hidden my-10">
                    <a href="/admin/categories/create" class=" primary-btn w-full">
                        <span class="">Add Category</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


    @include('admins.flash')
</body>

</html>
