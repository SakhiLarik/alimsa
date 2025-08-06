<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\VoidType;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // New orders by users
            $users = User::all();
            $search = '';
            return view("admins.orders.index", compact('search', 'users'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function search(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $search = $request->search;
            if (empty($search)) {
                return redirect()->route("admin.orders.index");
            }
            $users = DB::table('users')->where('name', 'like', "$search%")->get();
            if ($request->page == 'all') {
                return view("admins.orders.index", compact('search', 'users'));
            } else if ($request->page == 'active') {
                // dd("Active");
                return view("admins.orders.active", compact('search', 'users'));
            } else if ($request->page == 'shipped') {
                return view("admins.orders.shipped", compact('search', 'users'));
            } else if ($request->page == 'delivered') {
                return view("admins.orders.delivered", compact('search', 'users'));
            } else if ($request->page == 'completed') {
                return view("admins.orders.completed", compact('search', 'users'));
            } else {
                return view("admins.orders.index", compact('search', 'users'));
            }
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function active()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // New orders by users
            $users = User::all();
            $search = '';
            return view("admins.orders.active", compact('search', 'users'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function shipped()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // New orders by users
            $users = User::all();
            $search = '';
            return view("admins.orders.shipped", compact('search', 'users'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function delivered()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // New orders by users
            $users = User::all();
            $search = '';
            return view("admins.orders.delivered", compact('search', 'users'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function completed()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // New orders by users
            $users = User::all();
            $search = '';
            return view("admins.orders.completed", compact('search', 'users'));
        } else {
            return redirect()->route('admin.login');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function verify($order_id, $payment_status)
    {
        //
        $order = Order::find($order_id);
        $status = $payment_status == "error" ? -1 : 1;
        if ($order) {
            $payment = Payments::find($order->payment_id);
            if ($payment) {
                $payment->update([
                    'payment_successfull' => $status,
                ]);
                if ($status == 1) {
                    return redirect()->back()->with("success", "Hurray! We got a new order from user.");
                } else {
                    return redirect()->back()->with("success", "Oh ho! It was a bad behavior of the user.");
                }
            } else {
                return redirect()->back()->with("error", "Sorry! we can find the payment attached.");
            }
        } else {
            return redirect()->back()->with("error", "Sorry! we can find the order details.");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function shippment_process(Request $request)
    {
        $validator = $request->validate([
            'orders' => 'array|min:1|required'
        ]);
        return view("admins.orders.shippment", compact('request'));
    }

    public function shippment_submit(Request $request)
    {
        $validator = $request->validate([
            'service' => 'string|max:255|required',
            'tracking_id' => 'string|max:255|required'
        ]);
        if (count($request->orders) > 0) {
            foreach ($request->orders as $order_id) {
                $order = Order::find($order_id);
                // mark payment as successfull
                DB::table('payments')->where('order_id', '=', $order_id)->update(['payment_successfull' => 1]);
                // Start the order shippment
                if ($order) {
                    $order->update([
                        'tracking_id' => $request->tracking_id,
                        'service' => $request->service,
                        'is_shipped' => 1,
                    ]);
                }
            }
            return redirect()->route('admin.orders.index')->with('success', "Awesome! order was shipped successfully");
        } else {
            return redirect()->route('admin.orders.index')->with('error', "Oh ho! you have not selected any order");
        }
    }

    public function delivered_submit($order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            $order->update(['is_delivered' => 1]);
        } else {
            return redirect()->back()->with("error", "Sorry! we can find the order details.");
        }
        return redirect()->back()->with("success", "Awesome! your order was delivered.");
    }

    public function completed_submit($order_id)
    {
        $order = Order::find($order_id);
        if ($order) {
            Payments::find($order->payment_id)->update(['order_completed' => 1]);
            $order->update(['is_active' => 0, 'is_completed' => 1]);
        } else {
            return redirect()->back()->with("error", "Sorry! we can find the order details.");
        }
        return redirect()->back()->with("success", "Congratulations! your order was completed.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
