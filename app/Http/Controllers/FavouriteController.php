<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
{
    //
    function index()
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $user = User::find($user_id);
            $favourites = DB::table('favourites')->where('user_id', '=', $user_id)->get();
            return view('users.favourites', compact('favourites', 'user'));
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    function remove($id)
    {
        if (Auth::guard('web')->check()) {
            $find = Favourite::find($id);
            if ($find) {
                $find->delete();
                return redirect()->route('user.favourites.')->with('success', 'Product Removed from Favourites');
            } else {
                return redirect()->route('user.favourites.')->with('error', 'Soryy! We can not remove this item, try again');
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    function add($product_id)
    {
        if (Auth::guard('web')->check()) {
            $product = Product::find($product_id);
            $user_id = Auth::guard('web')->user()->id;
            if ($product) {
                Favourite::create([
                    "product_id" => $product_id,
                    "user_id" => $user_id,
                ]);
                return redirect()->back()->with('success', 'Product added in your favourites list');
            } else {
                return redirect()->back()->with('error', 'Soryy! We can not add this item, try again');
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
}
