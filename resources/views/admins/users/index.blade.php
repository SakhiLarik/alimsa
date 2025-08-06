@php
    use App\Models\Order;
    use App\Models\CartItem;
    $finalTotal = 0;
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
            <form action="/admin/users/search" method="post" class="grouped-btns items-center justify-center">
                @csrf
                @method('post')
                <input type="text" class="input-search" value="{{ $search }}"
                    placeholder="Search by name or user id..." name="name">
                <input type="submit" name="submit" id="" value="Search"
                    class="secondary-btn hidden lg:block lg:text-lg">
                <button type="submit" name="submit" id="" class="secondary-btn block lg:hidden"><i
                        class="fa fa-search"></i></button>
                <a href="/admin/users/" class="primary-btn text-lg hidden lg:block">Reset</a>
            </form>
        </div>
        <h1 class="text-3xl">
            Users Accounts and Summary
        </h1>
        <div class="list-users">
            <div class="user-cards my-10 grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                @if (!(count($users) > 0))
                    <p class="text-xl p-5 w-full text-gray-500 col-span-3">Sorry! No users found with given details, try again</p>
                @endif
                @foreach ($users as $user)
                    @php
                        $user_id = $user->id;
                        $activeOrders = count(
                            DB::table('orders')
                                ->where('user_id', '=', $user_id)
                                ->where('is_active', '=', 1)
                                ->where('is_paid', '=', 1)
                                ->get(),
                        );
                        $completedOrders = count(
                            DB::table('orders')->where('user_id', '=', $user_id)->where('is_completed', '=', 1)->get(),
                        );
                        $pendingOrders = count(
                            DB::table('orders')->where('user_id', '=', $user_id)->where('is_paid', '=', 0)->get(),
                        );
                        $cartItems = count(DB::table('cart_items')->where('user_id', '=', $user_id)->get());
                        $orders = DB::table('orders')->where('user_id', '=', $user_id)->get();
                        $total = 0;
                        $active = 0;
                        $completed = 0;
                        $pending = 0;
                        foreach ($orders as $order) {
                            if ($order->is_active == 1 && $order->is_paid == 1) {
                                $active += $order->total_price;
                            }
                            if ($order->is_paid == 0) {
                                $pending += $order->total_price;
                            }
                            if ($order->is_completed == 1) {
                                $completed += $order->total_price;
                            }
                            $total += $order->total_price;
                        }
                        $finalTotal += $total;
                    @endphp
                    <div class="card p-5">
                        <div class="card-title">
                            <div class="flex items-center">
                                <div class="mx-3 w-[25%]">
                                    <img src="{{ $user->image ? asset($user->image) : asset('avatar.jpg') }}"
                                        alt="" class="rounded-[50%] border border-gray-400 shadow-xl">
                                </div>
                                <div class="mx-3 w-[75%]">
                                    <h1 class="text-2xl bolder">{{ $user->name }}</h1>
                                    <small class="text-redish text-sm">{{ $user->user_id }}</small>
                                    <p class="text-sm">email: <a target="_blank" class="text-redish"
                                            href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                                    <p class="text-sm">phone: <a target="_blank" class="text-redish"
                                            href="tel:{{ $user->phone }}">{{ $user->phone }}</a></p>

                                </div>
                            </div>
                            <hr class="bg-gray-600 border-gray-400 my-2" />
                            <h1 class="text-lg bolder">Order Summary</h1>
                            <p>Completed: {{ $completedOrders }}</p>
                            <p>Active: {{ $activeOrders }}</p>
                            <p>Pending: {{ $pendingOrders }}</p>
                            <p>Cart: {{ $cartItems }}</p>
                            <hr class="bg-gray-600 border-gray-400 my-2" />
                            <h1 class="text-lg bolder">Payments Summary</h1>
                            <p>Completed: Rs. {{ number_format($completed, 0, ',') }}</p>
                            <p>Active: Rs. {{ number_format($active, 0, ',') }}</p>
                            <p>Pending: Rs. {{ number_format($pending, 0, ',') }}</p>
                            <hr class="bg-gray-600 border-gray-400 my-2" />
                            <p class="bolder">Total: Rs. {{ number_format($total, 0, ',') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <h1 class="text-3xl bolder">Final: Rs. {{ number_format($finalTotal, 0, ',') }}</h1>
    </div>

</body>

</html>
