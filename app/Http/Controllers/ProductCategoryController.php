<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProductCategoryController extends Controller
{
    //
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $search = '';
            $categories = ProductCategory::all();
            return view('admins.categories.index', compact('categories', 'search'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function search(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $search = $request->search;
            $categories =  DB::table('product_categories')->where('name', 'LIKE', "$search%")->get();
            return view('admins.categories.index', compact('categories', 'search'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function create()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            return view('admins.categories.create');
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function store(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $validator = $request->validate([
                'name' => 'required|string|max:255|unique:product_categories',
                'sub_category' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            if ($validator) {
                $category = ProductCategory::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'remarks' => "New product category created on date " . date("Y-m-d"),
                    'creation_by' => $admin,
                ]);
                SubCategory::create([
                    'category' => $category->id,
                    'name' => $request->sub_category,
                    'remarks' => "Sub-category created along with category creation",
                ]);
                return redirect()->route('admin.categories.index')->with('success', 'Product Category Created Successfully');
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
            $category = ProductCategory::find($id);
            $subCategories = DB::table('sub_categories')->where('category','=',$id)->get();
            if ($category) {
                return view('admins.categories.edit', compact('category','subCategories'));
            }
            return redirect()->route('admin.categories.index')->with('error', "Category Does Not Exist");
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function update(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user()->id;
            $validator = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            if ($validator) {
                $category = ProductCategory::find($request->id);
                if ($category) {
                    $category->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'remarks' => "Product category updated on date " . date("Y-m-d"),
                        'updated_by' => $admin,
                    ]);
                    return redirect()->route('admin.categories.index')->with('success', 'Product Category Updated Successfully');
                } else {
                    return redirect()->route('admin.categories.index')->with('error', "Category Does Not Exist");
                }
            } else {
                return back()->with('error', "Please fill out all the fields correctly")->withInput();
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function delete($id)
    {
        if (Auth::guard('admin')->check()) {
            $category = ProductCategory::find($id);
            if ($category) {
                $category->delete();
                return redirect()->route('admin.categories.index')->with('success', "Category Deleted Successfully");
            }
            return redirect()->route('admin.categories.index')->with('error', "Category Does Not Exist");
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function view($id)
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            return view('admins.categories.index');
        } else {
            return redirect()->route('admin.login');
        }
    }

    function add_sub_category(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            SubCategory::create([
                'category' => $request->category_id,
                'name' => $request->name,
                'remarks' => "Sub-category created",
            ]);
            return redirect()->route('admin.categories.index')->with('success','Sub-category created successfully');
        } else {
            return redirect()->route('admin.login');
        }
    }
    function delete_sub_category($category, $subCategory){
         if (Auth::guard('admin')->check()) {
            $subCategoryFind = SubCategory::find($subCategory);
            if($subCategoryFind){
                $subCategoryFind->delete();
                return redirect()->route('admin.categories.edit',$category)->with('success','Sub-category deleted successfully');
            }else{
                return redirect()->route('admin.categories.edit', $category)->with('success','Sub-category does not exists');
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
}
