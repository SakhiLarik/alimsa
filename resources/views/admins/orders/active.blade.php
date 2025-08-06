@php
    use App\Models\UserSettings;
    use App\Models\Orders;
    use App\Models\Payments;
    use App\Models\Product;
    use App\Models\AddOnFeature;
    $orderCounter=0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <div class="container search-container -mt-5">
            <form action="/admin/orders/search" method="post" class="grouped-btns items-center justify-center">
                @csrf
                @method('post')
                <input type="hidden" name="page" value="active">
                <input type="text" class="input-search" value="{{ $search }}"
                    placeholder="Search the orders by user name..." name="search">
                <input type="submit" name="submit" id="" value="Search"
                    class="secondary-btn hidden lg:block lg:text-lg">
                <button type="submit" name="submit" id="" class="secondary-btn block lg:hidden"><i
                        class="fa fa-search"></i></button>
                <a href="/admin/orders/active" class="primary-btn text-lg hidden lg:block">Reset</a>
            </form>
        </div>
        <h1 class="text-3xl my-4">
            Users with Active Orders
        </h1>
        <div class="main-container">
            <div class="grid sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
                @foreach ($users as $user)
                    @php
                        $bill = 0;
                        $totalOrders = 0;
                        $userSettings = DB::table('user_settings')->where('user_id', '=', $user->id)->get();
                        $orders = DB::table('orders')
                            ->where('user_id', '=', $user->id)
                            ->where('is_paid', '=', 1)
                            ->where('is_active', '=', 1)
                            ->where('is_shipped', '=', 0)
                            ->where('is_delivered', '=', 0)
                            ->where('is_completed', '=', 0)
                            ->get();
                    @endphp
                    @if (count($orders) > 0)
                        <div class="col-span-1">
                            <form action="/admin/orders/shippment_process" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="card p-5 m-2 product-card">
                                    <div class="order-card">
                                        <h1 class="text-xl bolder">{{ $user->name }}</h1>
                                    </div>
                                    <input type="hidden" name="user_name" value="{{ $user->name }}">
                                    <input type="hidden" name="user_email" value="{{ $user->email }}">
                                    <input type="hidden" name="user_phone" value="{{ $user->phone }}">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <p class="bolder text-lg text-slate-600">Order Summary</p>
                                    @foreach ($orders as $order)
                                        @php
                                        $orderCounter++;
                                            $product = Product::find($order->product_id);
                                            $addOn = DB::table('add_on_features')
                                                ->where('product', '=', $order->product_id)
                                                ->get();
                                            $payments = DB::table('payments')
                                                ->where('order_id', '=', $order->id)
                                                ->get();
                                            $bill += $order->total_price;
                                            $totalOrders += 1;
                                        @endphp
                                        <hr class="bg-gray-400 border-gray-400" />
                                        <div class="lg:flex items-center p-2 shadow m-2 border border-gray-200 rounded">
                                            <div class="product-details lg:w-[25%]">
                                                <center>
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                        class="h-52 w-fit  rounded-xl">
                                                </center>
                                            </div>
                                            <div class="p-2 h-fit lg:w-[30%] px-5">
                                                <div class="">
                                                    <h1 class="text-xl bolder">Order Details</h1>
                                                    <p class="text-redish text-md bolder">Order ID: <span
                                                            class="text-redish">{{ $order->order_id }}</span></p>
                                                    <p>Product: <span class="text-redish">{{ $product->name }}</span>
                                                    </p>
                                                    <p>Price: <span class="text-redish">Rs.
                                                            {{ number_format($order->price, 0, ',') }}</span></p>
                                                    <p>Amount: <span
                                                            class="text-redish">{{ $order->order_amount }}</span>
                                                    <p>Recieving Address: <span
                                                            class="text-redish">{{ $order->recieving_address }}</span>
                                                    </p>
                                                    @if ($order->add_on_added == 1)
                                                        <p>Add On: <span
                                                                class="text-redish">{{ $addOn[0]->name }}</span>
                                                        </p>
                                                        <p>Add On Size: <span
                                                                class="text-redish">{{ $order->add_on_size }}</span>
                                                        </p>
                                                        <p>Add On Price: <span class="text-redish">Rs.
                                                                {{ number_format($order->add_on_price, 0, ',') }}</span>
                                                        </p>
                                                    @endif
                                                    <h1 class="text-xl my-2 bolder">Bill: Rs.
                                                        {{ number_format($order->total_price, 0, ',') }}</h1>
                                                </div>
                                            </div>
                                            @if ($order->is_paid == 1)
                                                <div class="p-2 h-fit lg:w-[40%] px-5">
                                                    <div class="">
                                                        <h1 class="text-xl bolder">Payment Details</h1>
                                                        @foreach ($payments as $t_id => $payment)
                                                            <p class="text-redish text-md bolder">TRX ID: <span
                                                                    class="text-redish">{{ $payment->transaction_id }}</span>
                                                            </p>
                                                            <p>Payable: <span class="text-redish">Rs.
                                                                    {{ number_format($payment->payable, 0, ',') }}</span>
                                                            </p>
                                                            <p>Paid: <span class="text-redish">Rs.
                                                                    {{ number_format($payment->paid, 0, ',') }}</span>
                                                            </p>
                                                            <p>Method: <span
                                                                    class="text-redish">{{ $payment->payment_method }}</span>
                                                            </p>
                                                            <hr />
                                                            @if (strtolower($payment->payment_method) != 'cash on delivery')
                                                                <p>Bank: <span
                                                                        class="text-redish">{{ $payment->account }}</span>
                                                                </p>
                                                                <p>Account Title: <span
                                                                        class="text-redish">{{ $payment->account_title }}</span>
                                                                </p>
                                                                <p>Account Number: <span
                                                                        class="text-redish">{{ $payment->account_number }}</span>
                                                                </p>
                                                                <p>Payment Screenshot: <a class="text-redish"
                                                                        target="_blank"
                                                                        href="{{ asset($payment->screenshot) }}">View</a>
                                                                </p>
                                                            @else
                                                                <p class="bolder my-2 text-slate-600">Cash On Delivery -
                                                                    No
                                                                    Payments Made
                                                                </p>
                                                            @endif
                                                            <hr />
                                                            <div class="p-2">
                                                                @if ($payment->payment_successfull != 0)
                                                                    <p
                                                                        class="{{ $payment->payment_successfull == 1 ? 'text-green-600' : 'text-red-500' }}">
                                                                        Payment Status:
                                                                        {{ $payment->payment_successfull == 1 ? 'Successfull' : 'Failed' }}
                                                                    </p>
                                                                @else
                                                                    <p>
                                                                        Payment Status: Under Verification
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($order->is_shipped == 0)
                                            <div class="flex justify-center items-center m-4">
                                                <label class="w-[50%] flex border p-2 px-10"
                                                    for="ready_order_{{ $order->order_id }}">
                                                    <input checked name="orders[]" type="checkbox"
                                                        value="{{ $order->id }}"
                                                        id="ready_order_{{ $order->order_id }}">
                                                    <span class="mx-4 block">Ready For Shippment</span>
                                                </label>
                                                {{-- Check payment and update accordingly --}}
                                                <div class="grouped-btns">
                                                    <a href="/admin/orders/verify/{{ $order->id }}/error/"
                                                        class="secondary-btn"><i class="fa fa-times mx-2"></i> Payment
                                                        Failed </a>
                                                    <a href="/admin/orders/verify/{{ $order->id }}/success/"
                                                        class="primary-btn"> <i class="fa fa-check mx-2"></i> Payment
                                                        Successfull </a>
                                                </div>
                                            </div>
                                        @else
                                            @if ($order->is_completed == 1)
                                                <p class="text-md bolder my-4 text-center text-primary">This Order is
                                                    Completed</p>
                                            @else
                                                @if ($order->is_delivered == 1)
                                                    <p class="text-md bolder my-4 text-center text-primary">
                                                        <a href="/admin/orders/completed_submit/{{$order->id}}" class="secondary-btn w-full text-center block">This Order is Delivered => Click to Mark as Completed</a>
                                                    </p>
                                                @else
                                                    <p class="text-md bolder my-4 text-center text-primary">
                                                        <a href="/admin/orders/delivered_submit/{{$order->id}}" class="primary-btn w-full text-center block">This Order is Shipped => Click to Mark as Delivered</a>
                                                    </p>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                    <div class="lg:w-[50%] m-4 shadow-md rounded border border-gray-300 p-5">
                                        <div class="">
                                            <h1 class="text-xl bolder">User Details</h1>
                                            <p class="text-redish text-md bolder">User ID: <span
                                                    class="text-redish">{{ $user->user_id }}</span></p>
                                            <p>Name: <span class="text-redish">{{ $user->name }}</span></p>
                                            <p>Email: <a href="mailto:{{ $user->email }}"
                                                    class="text-redish">{{ $user->email }}</a></p>
                                            <p>Phone: <a href="tel:{{ $user->phone }}"
                                                    class="text-redish">{{ $user->phone }}</a></p>
                                        </div>
                                        <hr class="bg-gray-300 border-gray-300 my-3" />
                                        <p><span class="bolder text-redish">Note: </span>If you encounter any issue
                                            with
                                            user payment, address, or order details, you can contact to your customer
                                            and
                                            verify this order with given email and phone number before you proceed for
                                            shippment.</p>
                                    </div>
                                    <div class="p-5">
                                        <h1 class="text-xl text-redish">Final Bill: <span
                                                class=" bolder text-primary">Rs.
                                                {{ number_format($bill, 0, ',') }}</span> + 270 (delivery charges)</h1>
                                        <h1 class="text-xl text-redish">Total Orders: <span
                                                class=" bolder text-primary">{{ $totalOrders }}</span></h1>
                                    </div>
                                    <div class="">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit" class="block primary-btn">Start Shippment
                                            Process</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="main-container my-5">
            @if (!$orderCounter>0)
                <h1 class="text-xl bolder text-center text-slate-500">Sorry! There is no any active order yet.</h1>
            @endif
        </div>
    </div>

    @include('admins.flash')
</body>

</html>
