<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImages;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        //
        $products = Product::all();
        $categories = ProductCategory::all();
        $images = DB::table('product_images')->inRandomOrder()->orderBy('product_id')->limit(5)->get();
        $categories = ProductCategory::all();
        $settings = DB::table('settings')->first();
        return view("home", compact('products', 'categories', 'images','settings'));
    }
    public function contact()
    {
        //
        $categories = ProductCategory::all();
        return view("contact", compact('categories'));
    }
    public function contact_submit(Request $request)
    {
        $validator = $request->validate([
            'name' => 'string|min:3|max:200|required',
            'email' => 'email|required',
            'message' => 'required|string|min:50',
        ]);
        $create = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        if ($create) {
            return redirect()->back()->with('success', "Thank you! for contacting us, we will respond you soon.");
        } else {
            return redirect()->back()->with('error', "Sorry! there was an error at our side, please try again.");
        }
    }

    public function index()
    {
        $products = Product::all();
        $search = "";
        $type = 0;
        $searchedCategory = "";
        $categories = ProductCategory::all();
        return view("products", compact('products', 'categories', 'search', 'type', 'searchedCategory'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $type = $request->type;
        $categories = ProductCategory::all();
        $searchedCategory = $request->category;
        $products = DB::table('products')->where('name', 'like', "$search%")->where('category', '=', $searchedCategory)->where('is_perfume', "=", $type)->get();
        return view("products", compact('products', 'categories', 'search', 'type', 'searchedCategory'));
    }

    public function details($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::all();
        if ($product) {
            $sizes = DB::table('product_sizes')->where('product_id', '=', $id)->get();
            $images = DB::table('product_images')->where('product_id', '=', $id)->get();
            $category = ProductCategory::find($product['category']);
            $subCategory = SubCategory::find($product['sub_category']);
            $addOns = DB::table('add_on_features')->where('product', '=', $id)->get();
            $comments = DB::table('product_comments')->where('product_id', '=', $id)->orderBy('id', 'desc')->limit(10)->get();
            $reviews = DB::table('product_reviews')->where('product_id', '=', $id)->get();
            return view('view_product', compact('product', 'sizes', 'images', 'category', 'categories', 'subCategory', 'addOns', 'comments', 'reviews'));
        } else {
            return redirect()->route('home')->with('error', "Product details does not exists");
        }
    }
    function category($id)
    {
        $category = ProductCategory::find($id);
        $categories = ProductCategory::all();
        $subCategory = DB::table('sub_categories')->where('category', '=', $id)->get();
        $products = DB::table('products')->where('category', '=', $id)->get();
        if ($categories) {
            return view('view_category', compact('category', 'categories', 'products', 'subCategory'));
        } else {
            return redirect()->route('home')->with('error', "Product categories does not exists");
        }
    }

    function perfumes()
    {
        $products = DB::table('products')->where('is_perfume', '=', 1)->get();
        if (count($products) > 0) {
            $category = ProductCategory::find($products[0]->category);
            $categories = ProductCategory::all();
            $subCategory = DB::table('sub_categories')->where('category', '=', $products[0]->category)->get();
            if ($category) {
                return view('perfumes', compact('category', 'products', 'subCategory','categories'));
            } else {
                return redirect()->route('home')->with('error', "Product categories does not exists");
            }
        } else {
            return redirect()->back()->with('error', 'Sorry! there no any fragrances, try again letter');
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    public function register()
    {
        $categories = ProductCategory::all();
        return view("register", compact('categories'));
    }

    function category_with_sub($categoryID, $subCategoryID)
    {
        $category = ProductCategory::find($categoryID);
        $categories = ProductCategory::all();
        $subCategory = DB::table('sub_categories')->where('category', '=', $categoryID)->get();
        $products = DB::table('products')->where('category', '=', $categoryID)->where('sub_category', '=', $subCategoryID)->get();
        if ($categories) {
            return view('view_category', compact('category', 'categories', 'products', 'subCategory'));
        } else {
            return redirect()->route('home')->with('error', "Product categories does not exists");
        }
    }

    function arrivals()
    {

        //
        $products = DB::table('products')->orderByDesc('id')->limit(15)->get();
        $categories = ProductCategory::all();
        return view("arrivals", compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
