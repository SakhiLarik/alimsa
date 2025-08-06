@php
    $pendingTotalBill = 0;
    $activeTotalBill = 0;
    $completedTotalBill = 0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="container my-5">
        <h1 class="text-2xl bolder text-primary mt-5">Active Orders</h1>
        <p>We are reviewing your order details and will contact you soon about your order/s, stay connected.</p>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($activeOrders as $index => $order)
                <div class="col-span-1">
                    <a href="/product/details/{{$order->product_id}}">
                    <div class="card product-card">
                        @php
                            $product = DB::table('products')->where('id', '=', $order->product_id)->get();
                            $size = DB::table('product_sizes')->where('id', '=', $order->product_size_id)->get();
                            $activeTotalBill += $order->total_price;
                        @endphp
                        <div class="orderDetails">
                            <div class="orderHead">
                                <h1 class="text-lg bolder">{{ $product[0]->name }}</h1>
                                <p>Order ID: <span class="text-redish"> {{ $order->order_id }}</span></p>
                                <hr class="bg-slate-400 border-slate-400" />
                            </div>
                            <div class="orderBody my-2">
                                <p>Size: {{ $order->product_size_id == null ? $product[0]->size : $size[0]->name }}</p>
                                <p>Price: Rs. {{ number_format($order->price, 0, ',') }}</p>
                                <p>Order Amount: {{ $order->order_amount }}</p>
                                <p>Add On: Rs.
                                    {{ $order->add_on_price == null ? '00.0' : number_format($order->add_on_price, 0, ',') }}
                                </p>
                                <p class="bolder text-redish">Total Bill: Rs.
                                    {{ number_format($order->total_price, 0, ',') }}</p>
                            </div>
                            <div
                                class="mb-2 mt-5 p-3 rounded text-white shadow-lg shadow-gray-300 {{ $order->is_shipped == 1 ? ($order->is_delivered == 1 ? 'bg-info' : 'bg-primary') : 'bg-redish' }}">
                                <span class="bolder">Current Status:</span>
                                @if ($order->is_shipped == 1)
                                    @if ($order->is_delivered)
                                        <span class="underline bolder">Delivered</span>
                                    @else
                                        <span class="underline bolder">Shipped</span>
                                    @endif
                                    <div class="shipment-details my-2">
                                        <p>
                                            Curior Service: <span class=""> {{ $order->service }}</span>
                                        </p>
                                        <p>
                                            Tracking ID: <span class="">{{ $order->tracking_id }}</span>
                                        </p>
                                    </div>
                                    <div class="grouped-btns flex-wrap">
                                        <a href="/user/orders/recieved/{{ $order->id }}"
                                            class="secondary-btn w-full text-center">Order Recieved</a>
                                        {{-- <a href="#" class="primary-btn border-white w-full text-center lg:w-[50%]">Order Recieved</a> --}}
                                    </div>
                                @else
                                    <span class=" bolder">Under Review</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @if ($activeTotalBill <= 0)
                <div class="col-span-3">
                    <p class="my-5 text-slate-700">You have no Active Orders
                        <a class="text-redish underline" href="/product">Browse Products & Order Now</a>
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="container my-5">
        <hr class="bg-slate-500 border-slate-500 " />
        <h1 class="text-2xl mt-5 text-primary bolder">Payment Pending</h1>
        <p>You have ordered for these products but have not made any payment or set the receiving addrress.</p>
        <table class="table w-full my-5">
            <thead>
                <tr>
                    <th class="th-settings">OrderID</th>
                    <th class="th-settings">Product</th>
                    <th class="th-settings">Product Size</th>
                    <th class="th-settings">Product Price</th>
                    <th class="th-settings">Product Amount</th>
                    <th class="th-settings">Add On Price</th>
                    <th class="th-settings">Total Bill</th>
                    <th class="th-settings">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingOrders as $index => $order)
                    @php
                        $product = DB::table('products')->where('id', '=', $order->product_id)->get();
                        $size = DB::table('product_sizes')->where('id', '=', $order->product_size_id)->get();
                        $pendingTotalBill += $order->total_price;
                    @endphp
                    <tr>
                        <td class="td-settings">{{ $order->order_id }}</td>
                        <td class="td-settings">{{ $product[0]->name }}</td>
                        <td class="td-settings">
                            {{ $order->product_size_id == null ? $product[0]->size : $size[0]->name }}
                        </td>
                        <td class="td-settings text-center">Rs. {{ number_format($order->price, 0, ',') }}</td>
                        <td class="td-settings text-center">{{ $order->order_amount }}</td>
                        <td class="td-settings text-center">Rs.
                            {{ $order->add_on_price == null ? '00.0' : number_format($order->add_on_price, 0, ',') }}
                        </td>
                        <td class="td-settings text-center text-primary bolder">Rs. {{ number_format($order->total_price, 0, ',') }}
                        </td>
                        <td class="px-0 py-0 text-center">
                            <a href="/user/orders/cancel/{{ $order->id }}" class="secondary-btn block"> <i
                                    class="fa fas fa-trash "></i></a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="td-settings bolder text-xl text-redish" colspan="8">Final Bill: Rs.
                        {{ number_format($pendingTotalBill, 0, ',') }}</td>
                </tr>
                @if ($pendingTotalBill > 0)
                    <tr>
                        <td class="bg-primary text-center" colspan="8">
                            <a class="primary-btn block" href="/user/orders/payment_process">Complete Payment and Order
                                Now</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="td-settings text-slate-700" colspan="8">You have no Pending Orders <a
                                class="text-redish underline" href="/product">Browse Products & Order Now</a></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="container my-5">
        <hr class="bg-slate-500 border-slate-500 " />
        <h1 class="text-2xl mt-5 text-primary bolder">Completed Pending</h1>
        <p>Orders that you have completed, It was a good dealing with you, stay connected are bringing more for you.</p>
        <table class="table w-full my-5">
            <thead>
                <tr>
                    <th class="th-settings">SR#</th>
                    <th class="th-settings">OrderID</th>
                    <th class="th-settings">Product</th>
                    <th class="th-settings">Product Amount</th>
                    <th class="th-settings">Add On Price</th>
                    <th class="th-settings">Total Bill</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($completedOrders as $index => $order)
                    @php
                        $product = DB::table('products')->where('id', '=', $order->product_id)->get();
                        $size = DB::table('product_sizes')->where('id', '=', $order->product_size_id)->get();
                        $completedTotalBill += $order->total_price;
                    @endphp
                    <tr>
                        <td class="td-settings">{{ $index + 1 }}</td>
                        <td class="td-settings">{{ $order->order_id }}</td>
                        <td class="td-settings">{{ $product[0]->name }}
                            ({{ $order->product_size_id == null ? $product[0]->size : $size[0]->name }})
                            (Rs.
                            {{ number_format($order->price, 0, ',') }})</td>
                        <td class="td-settings text-center">{{ $order->order_amount }}</td>
                        <td class="td-settings text-center">Rs.
                            {{ $order->add_on_price == null ? '00.0' : number_format($order->add_on_price, 0, ',') }}
                        </td>
                        <td class="td-settings text-primary text-center bolder">Rs. {{ number_format($order->total_price, 0, ',') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="td-settings bolder  text-xl text-redish" colspan="6">Total Spent: Rs.
                        {{ number_format($completedTotalBill, 0, ',') }}</td>
                </tr>
                @if ($completedTotalBill <= 0)
                    <tr>
                        <td class="td-settings text-slate-700" colspan="6">You have not yet completed any order with us. <a
                                class="text-redish underline" href="/product">Browse Products & Order Now</a></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @include('footer')
</body>

</html>
