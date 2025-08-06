@php
    $year = date("Y");
    $month = date("m");
    $monthList = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    $firstOrderData = date("Y-m-d");
    if($firstOrder){
        $firstOrderData = date("Y-m-d",strtotime(substr($firstOrder->created_at,0,10)));
    }

    $amountTotal = 0;
    $amountPending = 0;
    $amountThisYear = 0;
@endphp
@foreach ($pending as $item)
    @php
        $amountPending += $item->total_price;
    @endphp
@endforeach
@foreach ($total as $item)
    @php
        $amountTotal += $item->total_price;
    @endphp
@endforeach
@foreach ($thisYear as $item)
    @php
        $amountThisYear += $item->total_price;
    @endphp
@endforeach
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <h1 class="text-2xl md:text-4xl boldest pb-5 border-b border-b-slate-500">Welcom {{ $admin['name'] }}</h1>
        {{-- Orders --}}
        <div class="my-5"></div>
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Orders</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-5">
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-receipt text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            @if ($countActive >= 10)
                                {{ $countActive - 1 }}+
                            @else
                                {{ $countActive }}
                                @endif Active @if ($countActive > 1)
                                    Orders
                                @else
                                    Order
                                @endif
                        </h1>
                        <p class="text-slate-100 ">Review your orders and ship them</p>
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
                            @if ($countShipped >= 10)
                                {{ $countShipped - 1 }}+
                            @else
                                {{ $countShipped }}
                            @endif
                            @if ($countShipped > 1)
                                Orders
                            @else
                                Order
                            @endif
                            Shipped
                        </h1>
                        <p class="text-slate-700">Track your shipped orders</p>
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
                            @if ($countCompleted >= 10)
                                {{ $countCompleted - 1 }}+
                            @else
                                {{ $countCompleted }}
                            @endif
                            @if ($countCompleted > 1)
                                Orders
                            @else
                                Order
                            @endif
                            Completed
                        </h1>
                        <p class="text-slate-100">Check costumer product reviews</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Revenu --}}
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Revenu</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-5">
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-dollar-sign text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{ number_format($amountTotal,0,"0") }}
                            Total Earnings
                        </h1>
                        <p class="text-slate-100">{{date("d",strtotime($firstOrderData))}} {{$monthList[intval(date("m",strtotime($firstOrderData)))-1]}} {{date("Y",strtotime($firstOrderData))}} - {{ date('d') }} {{$monthList[intval($month-1)]}} {{$year}}</p>
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
                            {{ number_format($amountPending,0,"0") }}
                            Pending
                        </h1>
                        <p class="text-slate-700">COD orders are pending</p>
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
                            {{ number_format($amountThisYear,0,"0") }}
                            This Year
                        </h1>
                        <p class="text-slate-100">01 January {{$year}} - {{ date('d') }} {{$monthList[intval($month-1)]}} {{$year}}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Products --}}
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Progress</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-5">

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-list-check text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$countCategories}} Categories
                        </h1>
                        <p class="text-slate-100 ">Total categories of products</p>
                    </div>
                </div>
            </div>
            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-white p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-shop text-primary"></i>
                    </div>
                    <div class="content  mx-2 text-primary">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$countProducts}} Products
                        </h1>
                        <p class="text-slate-700">10 average by category</p>
                    </div>
                </div>
            </div>

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-shopping-cart text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$countCarts}} Carts
                        </h1>
                        <p class="text-slate-100">In Cart List By Users</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews, Ratings and Comments --}}
        {{-- <h1 class="my-5 text-2xl md:text-3xl bolder text-redish">Progress</h1> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-5">

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-redish p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-users text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$countReviews}}+ Reviews
                        </h1>
                        <p class="text-slate-100">Check product reviews</p>
                    </div>
                </div>
            </div>

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-white p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-star text-primary"></i>
                    </div>
                    <div class="content  mx-2 text-primary">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$totalRatings}}+ Rating
                        </h1>
                        <p class="text-slate-700">Ratings shows good progress</p>
                    </div>
                </div>
            </div>

            <div class="box hover:scale-105 col-span-3 md:col-span-2 lg:col-span-1">
                <div class="flex items-center m-2 bg-slate-700 p-10 shadow-lg h-32 border border-slate-200">
                    <div class="icon mx-2 ">
                        <i class="text-4xl md:text-5xl fa fa-message text-white"></i>
                    </div>
                    <div class="content  mx-2 text-white">
                        <h1 class="text-xl md:text-2xl bolder">
                            {{$countComments}}+ Comments
                        </h1>
                        <p class="text-slate-100 ">Read comments and resonse</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
