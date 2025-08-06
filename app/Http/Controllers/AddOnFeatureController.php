<?php

namespace App\Http\Controllers;

use App\Models\AddOnFeature;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddOnFeatureController extends Controller
{
    //
    function index()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $addOns = AddOnFeature::all();
            $search = '';
            return view('admins.addons.index', compact('addOns', 'search'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function create()
    {
        if (Auth::guard('admin')->check()) {
            $products = Product::all();
            return view('admins.addons.create', compact('products'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function create_with_product($product_id){
         if (Auth::guard('admin')->check()) {
            $products = Product::all();
            return view('admins.addons.create', compact('products','product_id'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function edit($id)
    {
        if (Auth::guard('admin')->check()) {
            $products = Product::all();
            $addOn = AddOnFeature::find($id);
            return view('admins.addons.edit', compact('products', 'addOn'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function store(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validator = $request->validate([
                'product' => 'integer|required|unique:add_on_features,product',
                'name' => 'string|required|max:255',
                'price' => 'integer|required|min:0',
                'image' => 'image|mimes:png,jpg,jpeg|max:2048|required',
            ]);
            $imageName = time() . "_" . uniqid(false) . '.' . $request->image->extension();
            $request->image->move(public_path('products/addons/images/'), $imageName);
            $create = AddOnFeature::create([
                'product' => $request->product,
                'name' => $request->name,
                'price' => $request->price,
                'image' => "products/addons/images/" . $imageName
            ]);
            if ($create) {
                return redirect()->route('admin.add_ons.index')->with("success", "Add On Feature Created Successfully");
            } else {
                return redirect()->route('admin.add_ons.create')->with("error", "Sorry! somethin went wrong");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    function update(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validator = $request->validate([
                'product' => 'integer|required',
                'name' => 'string|required|max:255',
                'price' => 'integer|required|min:0',
                'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            ]);
            // dd(empty($request->image));
            if (empty($request->image)) {
                $addOn = AddOnFeature::find($request->id);
                $update = $addOn->update([
                    'product' => $request->product,
                    'name' => $request->name,
                    'price' => $request->price,
                ]);
                if ($update) {
                    return redirect()->route('admin.add_ons.index')->with("success", "Add On Feature Created Successfully");
                } else {
                    return redirect()->route('admin.add_ons.create')->with("error", "Sorry! somethin went wrong");
                }
            } else {
                $imageName = time() . "_" . uniqid(false) . '.' . $request->image->extension();
                $request->image->move(public_path('products/addons/images/'), $imageName);
                $addOn = AddOnFeature::find($request->id);
                $update = $addOn->update([
                    'product' => $request->product,
                    'name' => $request->name,
                    'price' => $request->price,
                    'image' => "products/addons/images/" . $imageName
                ]);
                if ($update) {
                    return redirect()->route('admin.add_ons.index')->with("success", "Add On Feature Created Successfully");
                } else {
                    return redirect()->route('admin.add_ons.create')->with("error", "Sorry! somethin went wrong");
                }
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    function delete($id)
    {
        if (Auth::guard('admin')->check()) {
            $addOn = AddOnFeature::find($id);
            if ($addOn) {
                $addOn->delete();
                return redirect()->back()->with('success', "Add On Feature deleted successfully");
            } else {
                return redirect()->back()->with('error', "Add On Feature not found");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function search(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $search = $request->search;
            $addOns = DB::table('add_on_features')->where('name', 'like', "$search%")->get();
            return view('admins.addons.index', compact('search', 'addOns'));
        } else {
            return redirect()->route('admin.login');
        }
    }
}
