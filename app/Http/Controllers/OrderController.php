<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function order_now(Request $request)
    {
        // dd($request->all());
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $products = $request->products;
            foreach ($products as $key => $value) {
                $product_id = $value;
                $price = $request->prices[$key];
                $size = $request["size_$product_id"];
                $addOn = $request["addOn_$product_id"];
                $addOnSize = $request["addOn_size_$product_id"];
                $addOnPrice = 0;
                if ($addOn == 1) {
                    $addOnPrice = $request["addOn_price_$product_id"];
                }
                $amount = $request->amounts[$key];
                $totalPrice = ($price * $amount) + $addOnPrice;
                // check for duplicate
                $check = DB::table('orders')->where('product_id', '=' . $product_id)->where('product_size_id', '=', $size)->where('user_id', '=', $user_id)->get();
                if (!count($check) > 0) {
                    $createOrder = Order::create([
                        'order_id' => 'order_' . substr(uniqid(false), 5, 8),
                        'product_id' => $product_id,
                        'product_size_id' => $size == 0 ? null : $size,
                        'user_id' => $user_id,
                        'add_on_added' => $addOn,
                        'add_on_size' => $addOn == 0 ? null : $addOnSize,
                        'add_on_price' => $addOn == 0 ? null : $addOnPrice,
                        'order_amount' => $amount,
                        'price' => $price,
                        'total_price' => $totalPrice,
                        'is_active' => 1,
                        'is_paid' => 0,
                        'is_shipped' => 0,
                        'is_delivered' => 0,
                        'is_completed' => 0,
                        'recieving_address' => null,
                        'tracking_id' => null,
                        'service' => null,
                        'is_deleted' => 0,
                    ]);
                    if ($createOrder) {
                        continue;
                    } else {
                        return redirect()->back()->with('error', "Sorry! Something went wrong try again");
                    }
                }
            }
            // $user_id = Auth::guard('web')->user()->id;
            // Delete Cart Items
            $cartItems = DB::delete('delete from cart_items where user_id = ?', [$user_id]);
            return redirect()->route('user.orders.payment_process')->with('message', "Your order is created successfully please make your payment to proceed further");
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    public function single_order(Request $request)
    {
        // dd($request->all());
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $validator = $request->validate([
                'product' => 'integer|required|min:1',
                'price' => 'integer|required',
                'total_price' => 'integer|required',
                'size' => '',
                'order_amount' => 'integer|required|min:1',
                'add_on_size' => 'integer',
                'add_on_price' => 'integer',
                'add_on_selected' => 'integer',
            ]);
            if ($validator) {
                $totalPrice = ($request->price * $request->order_amount) + ($request->add_on_selected == 0 ? 0 : $request->add_on_price);
                $createOrder = Order::create([
                    'order_id' => 'order_' . substr(uniqid(false), 5, 8),
                    'product_id' => $request->product,
                    'product_size_id' => $request->size,
                    'user_id' => $user_id,
                    'add_on_added' => $request->add_on_selected,
                    'add_on_size' => $request->add_on_selected == 0 ? null : $request->add_on_size,
                    'add_on_price' => $request->add_on_selected == 0 ? null : $request->add_on_price,
                    'order_amount' => $request->order_amount,
                    'price' => $request->price,
                    'total_price' => $totalPrice,
                    'is_active' => 1,
                    'is_paid' => 0,
                    'is_shipped' => 0,
                    'is_delivered' => 0,
                    'is_completed' => 0,
                    'recieving_address' => null,
                    'tracking_id' => null,
                    'service' => null,
                    'is_deleted' => 0,
                ]);
                if ($createOrder) {
                    return redirect()->route('user.orders.payment_process')->with('message', "Your order is created successfully please make your payment to proceed further");
                    // Payment for this order
                } else {
                    return redirect()->back()->with('error', "Sorry! Something went wrong try again");
                }
            } else {
                return redirect()->back()->with('error', "Sorry! Your order is incomplete");
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    function payment_process()
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $pendingOrders = DB::table('orders')->where('user_id', '=', $user_id)->where('is_active', '=', 1)->where('is_paid', '=', 0)->get();
            $paymentMethods = DB::table('user_settings')->where('user_id', '=', $user_id)->get();
            if (count($pendingOrders) > 0) {
                return view('users.orders.payment_process', compact('pendingOrders', 'paymentMethods'));
            } else {
                return redirect()->back()->with('error', "You have not made any order to pay for");
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    function make_payment(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            // dd(($request->file('screenshot')));
            $imageLocation = "";
            $orders = $request->orders;
            if (strtolower($request->payment_method) != "cod") {
                $validator = $request->validate([
                    'amount_paid' => 'string|max:255|required',
                    'payment_method' =>  'string|max:255|required',
                    'account_bank' => 'string|max:255|required',
                    'account_number' => 'string|max:255|required',
                    'account_title' => 'string|max:255|required',
                    'transaction_id' => 'string|max:255|required',
                    'screenshot' => 'required|image|max:2048|mimes:png,jpg',
                ]);
                $imageName = time() . "_" . uniqid(false) . '.' . $request->screenshot->extension();
                $request->screenshot->move(public_path('orders/payments/'), $imageName);
                $imageLocation = "orders/payments/" . $imageName;
            }
            foreach ($orders as $order) {
                if (strtolower($request->payment_method) == "cod") {
                    Payments::create([
                        'user_id' => $user_id,
                        'order_id' => $order,
                        'payable' => $request->amount_payable,
                        'paid' => $request->amount_paid,
                        'payment_method' => "Cash On Delivery",
                        'account' => null,
                        'account_title' => null,
                        'account_number' => null,
                        'transaction_id' => null,
                        'screenshot' => null,
                        'payment_successfull' => 0,
                        'order_completed' => 0
                    ]);
                } else {
                    Payments::create([
                        'user_id' => $user_id,
                        'order_id' => $order,
                        'payable' => $request->amount_payable,
                        'paid' => $request->amount_paid,
                        'payment_method' => "Online Payment",
                        'account' => $request->account_bank,
                        'account_title' => $request->account_title,
                        'account_number' => $request->account_number,
                        'transaction_id' => $request->transaction_id,
                        'screenshot' => $imageLocation,
                        'payment_successfull' => 0,
                        'order_completed' => 0
                    ]);
                }

                // update order
                // Fetch Last Payment
                $payment = DB::table('payments')->get()->last();
                $updatableOrder = Order::find($order);
                if ($updatableOrder) {
                    $updatableOrder->update([
                        'is_paid' => 1,
                        'recieving_address' => $request->r_address,
                        'payment_id' => $payment->id,
                    ]);
                } else {
                    return redirect()->back()->with('error', "Sorry! we can not locate your order to process");
                }
            }
            return redirect()->route('user.orders.index')->with('success', "Congratulations! your successfully completed your order");
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
    function orders()
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $activeOrders = DB::table('orders')->where("user_id", '=', $user_id)->where('is_active', '=', 1)->where('is_paid', '=', 1)->where('is_completed', '=', 0)->get();
            $pendingOrders = DB::table('orders')->where("user_id", '=', $user_id)->where('is_active', '=', 1)->where('is_paid', '=', 0)->get();
            $completedOrders = DB::table('orders')->where("user_id", '=', $user_id)->where('is_completed', '=', 1)->get();
            return view("users.orders.index", compact('activeOrders', 'pendingOrders', 'completedOrders'));
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }

    function cancel($order_id)
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $order = DB::table('orders')->where('id','=',$order_id)->where('user_id','=',$user_id);
            if ($order) {
                $order->delete();
            }
            return redirect()->back()->with('success', "Item deleted from your order list");
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }

    function recieved($order_id)
    {
        if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $order = DB::table('orders')->where('id','=',$order_id)->where('user_id','=',$user_id);
            if ($order) {
                $order->update([
                    'is_delivered' => 1,
                    'is_completed' => 1,
                    'is_active' => 0
                ]);
                return redirect()->back()->with('success', "Thanks for your order");
            }else{
                return redirect()->back()->with('error', "Sorry! We can not validate given order");
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }
}
