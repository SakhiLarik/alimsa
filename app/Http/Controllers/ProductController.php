<?php

namespace App\Http\Controllers;

use App\Models\AddOnFeature;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImages;
use App\Models\ProductSize;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $search = '';
            $type = 0;
            $searchedCategory = 0;
            $products = Product::all();
            $categories = ProductCategory::all();
            return view('admins.products.index', compact('search', 'products', 'categories', 'searchedCategory', 'type'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function search(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $search = $request->search;
            $type = $request->type;
            $categories = ProductCategory::all();
            $searchedCategory = $request->category;
            $products = DB::table('products')->where('name', 'like', "$search%")->where('category', '=', $searchedCategory)->where('is_perfume', "=", $type)->get();
            return view('admins.products.index', compact('search', 'products', 'categories', 'type', 'searchedCategory'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function create()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $categories = ProductCategory::all();
            return view('admins.products.create', compact('categories'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function store(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $validator = $request->validate([
                'type' => 'required|integer',
                'category' => 'required|integer|min:1',
                'sub_category' => 'required|integer|min:1',
                'name' => 'string|max:255|required',
                'size' => 'string|required|max:255',
                'symbol' => 'string|max:255',
                'price' => "integer|min:0|required",
                'color' => "string|max:255",
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'febric' => 'string|max:255',
                'design' => 'string|max:255',
                'season' => 'string|max:255',
                'occasion' => 'string|max:255',
                'gender' => 'string|required|max:255',
                'availability' => 'string|required|max:255',
                'outfit' => 'string|max:255',
                'description' => "string|required|max:255",
            ]);
            $imageName = time() . "_" . uniqid(false) . '.' . $request->image->extension();
            $request->image->move(public_path('products/images/'), $imageName);
            if ($validator) {
                if ($request->type == '1') {
                    // Perfume
                    Product::create([
                        'product_id' => 'product_' . substr(uniqid('', false), 5, 8),
                        'category' => $request->category,
                        'sub_category' => $request->sub_category,
                        'is_perfume' => 1,
                        'name' => $request->name,
                        'color' => $request->color,
                        'size' => $request->size,
                        'symbol' => strtoupper($request->symbol),
                        'price' => $request->price,
                        'image' => "products/images/" . $imageName,
                        'gender' => $request->gender,
                        'availability' => $request->availability,
                        'description' => $request->description,
                        'remarks' => "New product created on date " . date("Y-m-d"),
                        'created_by' => $admin,
                    ]);
                } else {
                    // Clothes
                    Product::create([
                        'product_id' => 'product_' . substr(uniqid('', false), 5, 8),
                        'category' => $request->category,
                        'sub_category' => $request->sub_category,
                        'is_perfume' => 0,
                        'name' => $request->name,
                        'size' => $request->size,
                        'symbol' => strtoupper($request->symbol),
                        'price' => $request->price,
                        'color' => $request->color,
                        'image' => "products/images/" . $imageName,
                        'febric' => $request->febric,
                        'design' => $request->design,
                        'season' => $request->season,
                        'occasion' => $request->occasion,
                        'gender' => $request->gender,
                        'availability' => $request->availability,
                        'outfit' => $request->outfit,
                        'description' => $request->description,
                        'remarks' => "New product created on date " . date("Y-m-d"),
                        'created_by' => $admin,
                    ]);
                }
                return redirect()->route('admin.products.index')->with('success', 'Product Category Created Successfully');
            } else {
                return back()->with('error', "Please fill out all the fields correctly")->withInput();
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function edit($id)
    {
        if (Auth::guard('admin')->check()) {
            $product = Product::find($id);
            $categories = ProductCategory::all();
            return view('admins.products.edit', compact('product', 'categories'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function update(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $id = $request->id;
            $product = Product::find($id);
            if ($product) {
                $validator = $request->validate([
                    'type' => 'required|integer',
                    'category' => 'required|integer|min:1',
                    'sub_category' => 'required|integer|min:1',
                    'name' => 'string|max:255|required',
                    'size' => 'string|required|max:255',
                    'symbol' => 'string|max:255',
                    'price' => "integer|min:0|required",
                    'color' => "string|max:255",
                    'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'febric' => 'string|max:255',
                    'design' => 'string|max:255',
                    'season' => 'string|max:255',
                    'occasion' => 'string|max:255',
                    'gender' => 'string|required|max:255',
                    'availability' => 'string|required|max:255',
                    'outfit' => 'string|max:255',
                    'description' => "string|required|max:255",
                ]);

                if (!empty($request->image)) {
                    $imageName = time() . "_" . uniqid(false) . '.' . $request->image->extension();
                    $request->image->move(public_path('products/images/'), $imageName);
                    if ($request->type == 1) {
                        // Perfume
                        $product->update([
                            'product_id' => 'product_' . substr(uniqid('', false), 5, 8),
                            'category' => $request->category,
                            'sub_category' => $request->sub_category,
                            'is_perfume' => 1,
                            'name' => $request->name,
                            'size' => $request->size,
                            'color' => $request->color,
                            'symbol' => strtoupper($request->symbol),
                            'price' => $request->price,
                            'image' => "products/images/" . $imageName,
                            'gender' => $request->gender,
                            'availability' => $request->availability,
                            'description' => $request->description,
                            'remarks' => "Product Updated on date " . date("Y-m-d"),
                            'updated_by' => $admin,
                        ]);
                    } else {
                        $product->update([
                            'category' => $request->category,
                            'sub_category' => $request->sub_category,
                            'is_perfume' => 0,
                            'name' => $request->name,
                            'size' => $request->size,
                            'symbol' => strtoupper($request->symbol),
                            'price' => $request->price,
                            'color' => $request->color,
                            'image' => "products/images/" . $imageName,
                            'febric' => $request->febric,
                            'design' => $request->design,
                            'season' => $request->season,
                            'occasion' => $request->occasion,
                            'gender' => $request->gender,
                            'availability' => $request->availability,
                            'outfit' => $request->outfit,
                            'description' => $request->description,
                            'remarks' => "Product updated on date " . date("Y-m-d"),
                            'updated_by' => $admin,
                        ]);
                    }
                    return redirect()->route('admin.products.index')->with('success', 'Product Category Created Successfully');
                } else {
                    if ($request->type == 1) {
                        // Perfume
                        $product->update([
                            'product_id' => 'product_' . substr(uniqid('', false), 5, 8),
                            'category' => $request->category,
                            'sub_category' => $request->sub_category,
                            'is_perfume' => 1,
                            'name' => $request->name,
                            'color' => $request->color,
                            'size' => $request->size,
                            'symbol' => strtoupper($request->symbol),
                            'price' => $request->price,
                            'gender' => $request->gender,
                            'availability' => $request->availability,
                            'description' => $request->description,
                            'remarks' => "Product Updated on date " . date("Y-m-d"),
                            'updated_by' => $admin,
                        ]);
                    } else {
                        $product->update([
                            'category' => $request->category,
                            'sub_category' => $request->sub_category,
                            'is_perfume' => 0,
                            'name' => $request->name,
                            'size' => $request->size,
                            'symbol' => strtoupper($request->symbol),
                            'price' => $request->price,
                            'color' => $request->color,
                            'febric' => $request->febric,
                            'design' => $request->design,
                            'season' => $request->season,
                            'occasion' => $request->occasion,
                            'gender' => $request->gender,
                            'availability' => $request->availability,
                            'outfit' => $request->outfit,
                            'description' => $request->description,
                            'remarks' => "Product updated  on date " . date("Y-m-d"),
                            'updated_by' => $admin,
                        ]);
                    }
                    return redirect()->route('admin.products.index')->with('success', 'Product Category Created Successfully');
                }
            } else {
                return redirect()->route('admin.products.index')->with('error', 'Product edit was unsuccessfull');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function delete($id)
    {
        if (Auth::guard('admin')->check()) {
            $product = Product::find($id);
            $search = "";
            if ($product) {
                $product->delete();
                return redirect()->route('admin.products.index')->with('success', "Product Deleted Successfully");;
            } else {
                return redirect()->route('admin.products.index')->with('error', "Product Does Not Exist");;
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function view($id)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $product = Product::find($id);
            if ($product) {
                $sizes = DB::table('product_sizes')->where('product_id', '=', $id)->get();
                $images = DB::table('product_images')->where('product_id', '=', $id)->get();
                $category = ProductCategory::find($product['category']);
                $subCategory = SubCategory::find($product['sub_category']);
                $addOns = DB::table('add_on_features')->where('product', '=', $id)->get();
                return view('admins.products.view', compact('product', 'sizes', 'images', 'category', 'subCategory', 'addOns'));
            } else {
                return redirect()->route('admin.products.index')->with('error', "Product details does not exists");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function images($id)
    {
        if (Auth::guard('admin')->check()) {
            $product = Product::find($id);
            $images = DB::table('product_images')->where('product_id', '=', $id)->get();
            return view('admins.products.images', compact('product', 'images'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function storeImages(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $product = Product::find($id);
            if ($product) {
                if ($request->images != null) {
                    foreach ($request->images as $image) {
                        $validator = validator(
                            [$image],
                            ['image|mimes:png,jpg,jpeg|max:2048']
                        );
                        if (!$validator->fails()) {
                            $imageName = time() . "_" . uniqid(false) . '.' . $image->extension();
                            $image->move(public_path('products/images/'), $imageName);
                            ProductImages::create([
                                'product_id' => $id,
                                'location' => 'products/images/' . $imageName,
                                'created_by' => $admin
                            ]);
                        } else {
                            return redirect()->route("admin.products.images", $id)->with('error', "Please only select images less than 2MB");
                        }
                    }
                    return redirect()->route("admin.products.index", $id)->with('success', "All product images addedd successfully");
                } else {
                    return redirect()->route("admin.products.images", $id)->with('error', "Please select correct image files");
                }
            } else {
                return redirect()->route('admin.products.index')->with('error', "Selected product was invalid to add images");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function deleteImage($product_id, $id)
    {
        if (Auth::guard('admin')->check()) {
            $image = ProductImages::find($id);
            if ($image) {
                $image->delete();
                return redirect()->route('admin.products.images', $product_id)->with('success', "Image deleted successfully");
            }
            return redirect()->route('admin.products.images', $product_id)->with('error', "Image does not exists");
        } else {
            return redirect()->route('admin.login');
        }
    }

    function sizes($id)
    {
        if (Auth::guard('admin')->check()) {
            $product = Product::find($id);
            $sizes = DB::table('product_sizes')->where('product_id', '=', $id)->get();
            return view('admins.products.sizes', compact('product', 'sizes'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function storeSizes(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $product = Product::find($id);
            if ($product) {
                // dd($request->all());
                foreach ($request->names as $index => $name) {
                    if ($name !== null) {
                        $symbol = $request->symbols[$index];
                        $price = $request->prices[$index];
                        if ($request->images != null) {
                            $image = $request->images[$index];
                            $validator = validator(
                                [$name, $symbol, $price, $image],
                                ['string|max:255|required', 'string|max:255|required', 'integer|required|min:0', 'image|mimes:png,jpg,jpeg|max:2048']
                            );
                            if (!($validator->fails())) {
                                $imageName = time() . "_" . uniqid(false) . '.' . $image->extension();
                                $image->move(public_path('products/images/'), $imageName);
                                ProductSize::create([
                                    'product_id' => $id,
                                    'name' => $name,
                                    'symbol' => $symbol,
                                    'price' => $price,
                                    'image' => "products/images/" . $imageName,
                                    'created_by' => $admin
                                ]);
                            } else {
                                return redirect()->route('admin.products.sizes', $id)->with('error', "Please enter valid information in fields");
                            }
                        } else {
                            $validator = validator(
                                [$name, $symbol, $price],
                                ['string|max:255|required', 'string|max:255|required', 'integer|required|min:0']
                            );
                            if (!($validator->fails())) {
                                ProductSize::create([
                                    'product_id' => $id,
                                    'name' => $name,
                                    'symbol' => $symbol,
                                    'price' => $price,
                                    'created_by' => $admin
                                ]);
                            } else {
                                return redirect()->route('admin.products.sizes', $id)->with('error', "Please enter valid information in fields");
                            }
                        }
                    }
                }
                return redirect()->route("admin.products.sizes", $id)->with('success', "All products addedd successfully");
            } else {
                return redirect()->route('admin.products.index')->with('error', "Selected product was invalid to set sizes");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function deleteSizes($product_id, $id)
    {
        if (Auth::guard('admin')->check()) {
            $size = ProductSize::find($id);
            if ($size) {
                $size->delete();
                return redirect()->route('admin.products.sizes', $product_id)->with('success', "Size deleted successfully");
            }
            return redirect()->route('admin.products.sizes', $product_id)->with('error', "Size does not exists");
        } else {
            return redirect()->route('admin.login');
        }
    }


    function updateSize(Request $request)
    {
        // dd($request->all());

        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $product = Product::find($request->product_id);
            $size = ProductSize::find($request->size_id);
            // dd($product->exists());
            if ($size->exists() && $product->exists()) {
                // dd($request->all());
                $validator = $request->validate([
                    'name' => 'string|max:255|required',
                    'symbol' => 'string|max:255|required',
                    'price' => 'integer|required|min:0',
                ]);
                // dd($validator);
                if ($validator) {
                    $image = $request->image;
                    if ($image == null || empty($image)) {
                        $size->update([
                            'product_id' => $request->product_id,
                            'name' => $request->name,
                            'symbol' => $request->symbol,
                            'price' => $request->price,
                            'created_by' => $admin
                        ]);
                    } else {
                        $imgValidator = validator(
                            [$request->image],
                            ['image|mimes:png,jpg,jpeg|max:2048']
                        );
                        if (!$imgValidator->fails()) {
                            $imageName = time() . "_" . uniqid(false) . '.' . $image->extension();
                            $image->move(public_path('products/images/'), $imageName);
                            $size->update([
                                'product_id' => $request->product_id,
                                'name' => $request->name,
                                'symbol' => $request->symbol,
                                'price' => $request->price,
                                'image' => "products/images/" . $imageName,
                                'created_by' => $admin
                            ]);
                        } else {
                            return redirect()->route("admin.products.sizes", $request->product_id)->with('error', "Please only select images less than 2MB");
                        }
                    }
                    return redirect()->route("admin.products.sizes", $request->product_id)->with('success', "Product size updated successfully");
                } else {
                    return redirect()->route('admin.products.sizes', $request->product_id)->with('error', "Please enter valid information in fields");
                }
            } else {
                return redirect()->route('admin.products.index')->with('error', "Selected product was invalid to set sizes");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    function getSubCategories($id)
    {
        $category = ProductCategory::find($id);
        if ($category) {
            $subCategories = DB::table('sub_categories')->where('category', '=', $id)->get();
            return $subCategories;
        } else {
            return "";
        }
    }
}
