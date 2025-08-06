@php
    $totalBill = 0;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <h1 class="text-3xl bolder">
            Shippment Process
        </h1>
        <hr class="my-5 bg-gray-400 border-gray-400" />
        <form action="/admin/orders/shippment_submit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="grid sm:grid-cols-1 lg:grid-cols-3">
                <div class="col-span-1 xl:col-span-2">
                    <div class="">
                        <p class="my-5 bolder">You have selected following orders for shippment.</p>
                        <div class="table-responsive">
                            <table class="table table-auto table-bordered">
                                <thead>
                                    <tr>
                                        <th class="th-settings">SR#</th>
                                        <th class="th-settings">OrderID</th>
                                        <th class="th-settings">Product</th>
                                        <th class="th-settings">Size</th>
                                        <th class="th-settings">Price</th>
                                        <th class="th-settings">Amount</th>
                                        <th class="th-settings">Add On</th>
                                        <th class="th-settings">Bill</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($request->orders as $index => $order)
                                        @php
                                            $orderDetails = DB::table('orders')->where('id', '=', $order)->get()[0];
                                            $product = DB::table('products')
                                                ->where('id', '=', $orderDetails->product_id)
                                                ->get();
                                            $size = DB::table('product_sizes')
                                                ->where('id', '=', $orderDetails->product_size_id)
                                                ->get();
                                            $totalBill += $orderDetails->total_price;
                                        @endphp
                                        <tr>
                                            <td class="td-settings">{{ $index + 1 }}</td>
                                            <td class="td-settings">
                                                <input type="hidden" name="orders[]" value="{{ $orderDetails->id }}">
                                                {{ $orderDetails->order_id }}
                                            </td>
                                            <td class="td-settings">{{ $product[0]->name }}</td>
                                            <td class="td-settings">
                                                {{ $orderDetails->product_size_id == null ? $product[0]->size : $size[0]->name }}
                                            </td>
                                            <td class="td-settings">Rs.
                                                {{ number_format($orderDetails->price, 0, ',') }}
                                            </td>
                                            <td class="td-settings">{{ $orderDetails->order_amount }}</td>
                                            <td class="td-settings">Rs.
                                                {{ $orderDetails->add_on_price == null ? '00.0' : number_format($orderDetails->add_on_price, 0, ',') }}
                                            </td>
                                            <td class="td-settings">Rs.
                                                {{ number_format($orderDetails->total_price, 0, ',') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="order-receiving-message">
                            <p class="m-5 px-5">
                                <i class="text-redish bolder">Note: </i>
                                It may take time from curior service to process your order. So it is best to confirm the
                                order shippment, than add the shippment details here once the order is dispatched.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-1">
                    <div class="p-5 shadow-lg shadow-gray-400 rounded border border-gray-300">
                        <input type="hidden" name="user_id" id="" value="{{ $request->user_id }}">
                        <h1 class="text-2xl my-2 bolder">Shippment Form</h1>
                        <hr />
                        <div class="shipment-form my-5">
                            <div class="form-group my-1">
                                <label for="">Curior Service </label>
                                <input list="service" type="text" class="input-control" name="service"
                                    placeholder="TCS, M&P, Leopered etc.">
                                    <datalist id="service">
                                        <option value="TCS">TCS</option>
                                        <option value="M&P">M&P</option>
                                        <option value="Leopered">Leopered</option>
                                        <option value="Post">Post</option>
                                    </datalist>
                            </div>
                            <div class="form-group my-1">
                                <label for="">Tracking ID (Provided by Curior Service)</label>
                                <input type="text" class="input-control" name="tracking_id" placeholder="">
                            </div>
                            <p class="my-5 text-sm">Please confirm the given details before you submit. The details must be complete so your customer can easily track the order.</p>
                            <div class="form-group my-1">
                                <button class="primary-btn" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('admins.flash')
</body>

</html>
