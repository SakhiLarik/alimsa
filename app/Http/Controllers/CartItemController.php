<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    //
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $id = Auth::guard('web')->user()->id;
            $cartItems = DB::table('cart_items')->where('user_id', '=', $id)->get();
            $user = User::find($id);
            return view('users.cart', compact('cartItems', 'user'));
        } else {
            return redirect()->route('login')->with('error', "Please login to your account");
        }
    }
    public function addToCart($product_id)
    {
        // dd($product_id);
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            // dd($user_id);
            $check = DB::table('cart_items')->where('user_id', '=', $user_id)->where('product_id', '=', $product_id)->get();
            if (count($check) <= 0) {
                CartItem::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                ]);
                return redirect()->back()->with('success', "Product added Successfully");
            } else {
                return redirect()->back()->with('error', "This item is already in your cart");
            }
        } else {
            session('set_cart', $product_id);
            return redirect()->route('register')->with('error', "Please create your account first / login");
        }
    }

    public function checkout()
    {
        if (Auth::guard('web')->check()) {
            $categories = ProductCategory::all();
            $user_id = Auth::guard()->user()->id;
            $user = User::find($user_id);
            $cartItems = DB::table('cart_items')->where('user_id', "=", $user_id)->get();
            return view('checkout', compact('cartItems', 'user', 'categories'));
        } else {
            return redirect()->route('login')->with('error', "Please login to process with checkout");
        }
    }
    public function remove($id)
    {
        if (Auth::guard('web')->check()) {
            $cartItem = CartItem::find($id);
            if ($cartItem) {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Item removed from your cart');
            } else {
                return redirect()->back()->with('error', 'Item not found in yout cart');
            }
        } else {
            return redirect()->route('login')->with('error', "Please login to process with checkout");
        }
    }
}
