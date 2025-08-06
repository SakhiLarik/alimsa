<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function dashboard()
    {
        if (Auth::guard('admin')->check()) {
            $year = date("Y");
            $month = date("Y-m");
            $id = Auth::guard('admin')->user()->id;
            $admin = Admin::find($id);

            $countActive = count(DB::table('orders')->where('is_paid', '=', 1)->where('is_active', '=', 1)->where('is_completed', '=', 0)->get());
            $countShipped = count(DB::table('orders')->where('is_shipped', '=', 1)->where('is_delivered', '=', 0)->where('is_completed', '=', 0)->get());
            $countCompleted = count(DB::table('orders')->where('is_completed', '=', 1)->get());

            $firstOrder = DB::table('orders')->first('created_at');
            $total = DB::table('orders')->where('is_paid', '=', 1)->where('is_active', '=', 1)->get();
            $pending = DB::table('orders')->where('is_paid', '=', 0)->where('is_active', '=', 1)->get();
            $thisYear = DB::table('orders')->where('is_paid', '=', 1)->where('is_active', '=', 1)->where('created_at', 'like', "$year%")->get();

            $countCategories = count(ProductCategory::all());
            $countProducts = count(Product::all());
            $countCarts = count(CartItem::all());

            $countReviews = count(ProductReview::all());
            $countComments = count(ProductComment::all());
            $allReviews = ProductReview::all();
            $totalRatings = 0;
            foreach ($allReviews as $key => $value) {
                $totalRatings += $value['ratings'];
            }
            // $totalRatings = $totalRatings / $countReviews==0?1:$countReviews ;
            $totalRatings = $countReviews == 0 ? 0 : $totalRatings / $countReviews;



            return view("admins.index", compact('admin', 'countActive', 'countShipped', 'countCompleted', 'total', 'thisYear', 'pending', 'firstOrder', 'countCategories', 'countProducts', 'countCarts','countComments','totalRatings','countReviews'));
        } else {
            return redirect()->route('admin.login');
        }
    }


    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view("admins.login");
        }
    }

    public function loginPost(Request $request)
    {
        // dd(Hash::make($request->password));
        // Studio@123 => $2y$12$KlZeQHVRWoZ6IqfBPI5crOc0K4xtU8BHfXHLwusPn2TItlSDa3JjW
        // adminpanel@alimsa.com
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:255'
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('admin')->attempt($data, true)) {
            $request->session()->put('email', $check['email']);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', "Invalid email or password, Try again")->withInput();
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route("admin.login");
    }
}
