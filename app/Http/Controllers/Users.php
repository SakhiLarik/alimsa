<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function dashboard()
    {
        if (Auth::guard('web')->check()) {
            $id = Auth::guard('web')->user()->id;
            $user = User::find($id);
            $year = date("Y");
            $activeOrders = DB::table('orders')->where("user_id", '=', $id)->where('is_active', '=', 1)->where('is_paid', '=', 1)->where('is_completed', '=', 0)->get();
            $pendingOrders = DB::table('orders')->where("user_id", '=', $id)->where('is_active', '=', 1)->where('is_paid', '=', 0)->get();
            $completedOrders = DB::table('orders')->where("user_id", '=', $id)->where('is_completed', '=', 1)->get();

            $totalSpent = DB::table('orders')->where("user_id", '=', $id)->where('is_paid', '=', 1)->get();
            $toPay = DB::table('orders')->where("user_id", '=', $id)->where('is_paid', '=', 0)->get();
            $spentThisYear = DB::table('orders')->where("user_id", '=', $id)->where('is_paid', '=', 1)->where('created_at', 'like', "$year%")->get();

            $carts = DB::table('cart_items')->where("user_id", '=', $id)->get();
            $comments = DB::table('product_comments')->where("user_id", '=', $id)->get();
            $reviews = DB::table('product_reviews')->where("user_id", '=', $id)->get();

            if (isset($_SESSION['set_cart'])) {
                return redirect()->route('product.add_cart', $_SESSION['set_cart']);
            }
            return view('users.index', compact('user', 'activeOrders', 'pendingOrders', 'completedOrders', 'toPay', 'spentThisYear', 'totalSpent', 'carts', 'comments', 'reviews'));
        } else {
            return redirect()->route('login');
        }
    }
    public function settings()
    {
        if (Auth::guard('web')->check()) {
            $id = Auth::guard('web')->user()->id;
            $user = User::find($id);
            $userSettings = DB::table('user_settings')->where('user_id', '=', $id)->get();
            return view('users.settings', compact('user', 'userSettings'));
        } else {
            return redirect()->route('login');
        }
    }
    public function setAccount(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $validator = $request->validate([
            'name' => 'string|min:3|max:255|required',
            'old_password' => 'string|min:8|max:255|required',
            'new_password' => 'string|min:8|max:255|nullable',
            'email' => 'email|required',
            'phone' => 'string|min:11|max:11|required',
        ]);
        $User = User::find($user_id);
        if (Hash::check($request->old_password, $User->password)) {
            if (empty($request->new_password)) {
                $User->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                return redirect()->back()->with('success', 'Account updated successfully');
            } else {
                $User->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->new_password),
                    'phone' => $request->phone,
                ]);
                return redirect()->back()->with('success', 'Account and Password updated successfully');
            }
        } else {
            return redirect()->back()->with('error', 'Old password is incorrect');
        }
    }

    public function setSettings(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $validator = $request->validate([
            'address_1' => 'string|max:255|required',
            'address_2' => 'string|max:255|required',
            'bank' => 'string|max:255|required',
            'bank_number' => 'string|max:255|required',
            'bank_title' => 'string|max:255|required',
        ]);
        $UserSettings = DB::table('user_settings')->where('user_id', '=', $user_id);
        if (count($UserSettings->get()) > 0) {
            $UserSettings->update([
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'payment_method_bank' => $request->bank,
                'payment_method_number' => $request->bank_number,
                'payment_method_title' => $request->bank_title,
            ]);
            return redirect()->back()->with('success', 'Account settings updated successfully');
        } else {
            UserSetting::create([
                'user_id' => $user_id,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'payment_method_bank' => $request->bank,
                'payment_method_number' => $request->bank_number,
                'payment_method_title' => $request->bank_title,
            ]);
            return redirect()->back()->with('success', 'Account settings created successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login_view()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        } else {
            $categories = ProductCategory::all();
            return view('login', compact('categories'));
        }
    }

    public function login(Request $request)
    {
        //
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:255',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('web')->attempt($data, true)) {
            $request->session()->put('email', $check['email']);
            return redirect()->route('user.dashboard');
        } else {
            return back()->with('error', "Invalid email or password, Try again")->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:8|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|min:11|max:11|unique:users',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        // dd(Auth::guard('web')->attempt($check, true));
        User::create([
            'user_id' => 'user_' . substr(uniqid(), 5, 8),
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        if (Auth::guard('web')->attempt($data)) {
            $request->session()->put('email', $check['email']);
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('home')->with('error', 'Invalid email or password')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */

    public function view()
    {
        //
        if (Auth::guard('admin')->check()) {
            $users = User::all();
            $search = "";
            return view('admins.users.index', compact('users', 'search'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }

    public function search(Request $request)
    {
        //
        if (Auth::guard('admin')->check()) {
            $name = $request->name;
            if (empty($name)) {
                return redirect()->route('admin.users.view');
            }
            $users = DB::table('users')->where('name', 'like', "$name%")->orWhere('user_id', 'like', "$name%")->get();
            $search = $name;
            return view('admins.users.index', compact('users', 'search'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }

    public function ratings()
    {
        if (Auth::guard('admin')->check()) {
            $products = Product::all();
            return view('admins.users.ratings', compact('products'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }
     public function reviews($product_id)
    {
        if (Auth::guard('admin')->check()) {
            $product = Product::find($product_id);
            $reviews = DB::table('product_reviews')->where('product_id',"=",$product_id)->get();
            $comments = count(DB::table('product_comments')->where('product_id',"=",$product_id)->get());
            $orders = count(DB::table('orders')->where('product_id',"=",$product_id)->get());
            return view('admins.users.reviews', compact('reviews','product','comments','orders'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }
    public function comments()
    {
        //
        if (Auth::guard('admin')->check()) {
            $products = Product::all();
            return view('admins.users.comments', compact('products'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }
     public function product_comments($product_id)
    {
        //
        if (Auth::guard('admin')->check()) {
            $product = Product::find($product_id);
            $reviews = count(DB::table('product_reviews')->where('product_id',"=",$product_id)->get());
            $comments = DB::table('product_comments')->where('product_id',"=",$product_id)->get();
            $orders = count(DB::table('orders')->where('product_id',"=",$product_id)->get());
            return view('admins.users.product_comments', compact('product','comments','reviews','orders'));
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }
    public function respond(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validator = $request->validate([
                'comment_id' => 'required',
                'response' => 'required|string|min:10',
            ]);
            $comment = ProductComment::find($request->comment_id);
            if($comment){
                $comment->update([
                    'response' => $request->response,
                ]);
            return redirect()->back()->with('success', "Your response submitted successfully.");
            }
            else{
            return redirect()->back()->with('error', "Sorry! the response comment not found.");

            }
        } else {
            return redirect()->route('admin.login')->with('error', "Please login first");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
