@php
    $year = date("Y");
    $month = date("m");
    $monthList = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    $amountToPay = 0;
    $amountTotalSpent = 0;
    $amountSpentThisYear = 0;
@endphp
@foreach ($toPay as $item)
    @php
        $amountToPay += $item->total_price;
    @endphp
@endforeach
@foreach ($totalSpent as $item)
    @php
        $amountTotalSpent += $item->total_price;
    @endphp
@endforeach
@foreach ($spentThisYear as $item)
    @php
        $amountSpentThisYear += $item->total_price;
    @endphp
@endforeach

<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="container">
        <div class="welcome p-5">
            <h1 class="text-2xl bolder">Welcom {{ $user['name'] }}</h1>
            <hr class="bg-gray-400 border-gray-400" />
        </div>
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Orders</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5">
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-receipt text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($activeOrders) >= 10)
                                {{ count($activeOrders) - 1 }}+
                            @else
                                {{ count($activeOrders) }}
                                @endif Active @if (count($activeOrders) > 1)
                                    Orders
                                @else
                                    Order
                                @endif
                        </h1>
                        <p class="text-slate-100 ">
                            @if (count($activeOrders) > 0)
                                You will recieve these orders soon
                            @else
                                Browse products to make an order
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-white p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-receipt text-primary"></i>
                    </div>
                    <div class="content  mx-2 text-primary">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($pendingOrders) >= 10)
                                {{ count($pendingOrders) - 1 }}+
                            @else
                                {{ count($pendingOrders) }}
                                @endif Pending @if (count($pendingOrders) > 1)
                                    Orders
                                @else
                                    Order
                                @endif
                        </h1>
                        <p class="text-slate-700">
                            @if (count($pendingOrders) > 0)
                                Complete the pay to procces these orders
                            @else
                                You have nothing to pay for
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-receipt text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($completedOrders) >= 10)
                                {{ count($completedOrders) - 1 }}+
                            @else
                                {{ count($completedOrders) }}
                                @endif Completed @if (count($completedOrders) > 1)
                                    Orders
                                @else
                                    Order
                                @endif
                        </h1>
                        <p class="text-slate-100">
                            @if (count($completedOrders) > 0)
                                It was a good time to deal with you
                            @else
                                Uff! what are you waiting for?
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Revenu --}}
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Revenu</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5">
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-dollar-sign text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if ($amountTotalSpent >= 1000)
                                {{ number_format($amountTotalSpent, 0, ',') }}
                            @else
                                {{ $amountTotalSpent }}
                            @endif Total Spent
                        </h1>
                        <p class="text-slate-100">
                            @if ($amountTotalSpent > 1000)
                                We will surprise you soon
                            @else
                                Your are our normal user / customer
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-white p-10 shadow-lg h-32 border border-slate-200">

                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-dollar-sign text-primary"></i>
                    </div>
                    <div class="content  mx-2 text-primary">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if ($amountToPay >= 1000)
                                {{ number_format($amountToPay, 0, ',') }}
                            @else
                                {{ $amountToPay }}
                            @endif To Pay
                        </h1>
                        <p class="text-slate-700 ">
                            @if ($amountToPay > 0)
                                You have pending orders to pay
                            @else
                                You have noting to pay for
                            @endif
                        </p>
                    </div>
                </div>
            </div>


            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-dollar-sign text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if ($amountSpentThisYear >= 1000)
                                {{ number_format($amountSpentThisYear, 0, ',') }}
                            @else
                                {{ $amountSpentThisYear }}
                            @endif Spent This Year

                        </h1>
                        <p class="text-slate-100">01 January {{$year}}- {{ date('d') }} {{$monthList[intval($month-1)]}} {{$year}}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Activity --}}
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Progress</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5">

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-shopping-cart text-white"></i>
                    </div>
                    <div class="content mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($carts) >= 10)
                                {{ count($carts) - 1 }}+
                            @else
                                {{ count($carts) }}
                                @endif Cart @if (count($carts) > 1)
                                    Items
                                @else
                                    Item
                                @endif
                        </h1>
                        <p class="text-slate-100 ">
                            @if (count($carts) > 0)
                                Complete these orders before expiry
                            @else
                                Add items in Cart to order collectively
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-white p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-heart text-primary"></i>
                    </div>
                    <div class="content  mx-2 text-primary">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($comments) >= 10)
                                {{ count($comments) - 1 }}+
                            @else
                                {{ count($comments) }}
                                @endif @if (count($comments) > 1)
                                    Comments
                                @else
                                    Comment
                                @endif
                        </h1>
                        <p class="text-slate-700">
                            @if (count($comments) > 0)
                                You seems a happy client, Thanks
                            @else
                                It doesn't cost you to comment
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-star text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if (count($reviews) >= 10)
                                {{ count($reviews) - 1 }}+
                            @else
                                {{ count($reviews) }}
                            @endif
                            Product Reviewed

                        </h1>
                        <p class="text-slate-100">
                            @if (count($reviews) > 0)
                                Thanks for your time to review
                            @else
                                Let us know about our products
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="my-80"></div>
    @include('footer')
</body>

</html>
