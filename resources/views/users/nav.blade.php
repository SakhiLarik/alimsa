<nav class="bg-white shadow ">
    <div class="w-[100%] px-16 hidden xl:flex justify-between items-center ">
        <!-- Logo -->
        <img src="{{ asset('images/Alimsa studio logo - Copy.PNG') }}" alt="ALIMSA Studio Logo" class=" "
            width="100px">
        <!-- Nav Links -->
        <ul class="space-x-8 uppercase flex font-semibold text-sm desktop-layout">
            <li><a href="/user/dashboard" class="hover:text-blue-600">Dashboard</a></li>
            <li><a href="/product" class="hover:text-blue-600">  All Products</a></li>
            <li><a href="/user/orders" class="hover:text-blue-600"> My Orders</a></li>
            {{-- <li><a href="/user/favourites" class="hover:text-blue-600">My Favourites</a></li> --}}
            <li><a href="/user/settings" class="hover:text-blue-600">Settings</a></li>
            <li><a href="/user/cart"><i class="fas hover:text-blue-600 fa-shopping-cart"></i></a></li>
            <li class="hover:text-red-400"><a href="/user/logout"><i class="fas fa mx-2 fa-sign-out"></i> </a></li>
        </ul>
    </div>
    {{-- <span class="font-bold text-xl">ALIMSA Studio</span> --}}
    <div class="left-0 flex justify-between px-10 items-center xl:hidden">
        <img src="{{ asset('images/Alimsa studio logo - Copy.PNG') }}" alt="ALIMSA Studio Logo" class=""
            width="100px">
        <a class="text-xl" onclick="popoutNav();" href="#"><i class="fas fa-bars"></i></a>
    </div>

    <div
        class="mobile-layout-nav hidden bg-white h-[100%] w-64 -mx-64 xl:hidden fixed z-10 top-0 left-0 shadow-2xl p-5 transition-all duration-300 delay-100">
        <ul class=" ">
            <li class="my-8"><a href="/user/dashboard" class="hover:text-blue-600"> <i class="fas fa mx-2 fa-user"></i> Dashboard</a></li>
            <li class="my-8"><a href="/product" class="hover:text-blue-600"> <i class="fas fa mx-2 fa-shop"></i> All Products</a></li>
            <li class="my-8"><a href="/user/orders" class="hover:text-blue-600"> <i class="fas fa mx-2 fa-list-dots"></i> My Orders</a></li>
            {{-- <li class="my-8"><a href="/user/favourites" class="hover:text-blue-600"> <i class="fas fa mx-2 fa-heart"></i>  My Favourites</a></li> --}}
            <li class="my-8"><a href="/user/settings" class="hover:text-blue-600"> <i class="fa fa-user-cog mx-2"></i> Settings</a></li>
            <li class="my-8"><a href="/user/cart"><i class="fas hover:text-blue-600 mx-2 fa-shopping-cart"></i> My Cart</a></li>
            <li class="my-8 hover:text-red-400"><a href="/user/logout"><i class="fas fa mx-2 fa-sign-out"></i> Logout</a></li>

        </ul>
        <!-- Icons -->
    </div>
</nav>
<script>
    function popoutNav() {
        if (document.querySelector('.mobile-layout-nav').classList.contains('hidden')) {
            document.querySelector('.mobile-layout-nav').classList.remove('hidden');
            document.querySelector('.mobile-layout-nav').classList.remove('-mx-64');
            document.querySelector('.mobile-layout-nav').classList.add('mx-0');
            document.querySelector(".fa-bars").classList.add("fa-times");
            document.querySelector(".fa-bars").classList.remove("fa-bars");
        } else {
            document.querySelector('.mobile-layout-nav').classList.add('hidden');
            document.querySelector('.mobile-layout-nav').classList.add('-mx-64');
            document.querySelector('.mobile-layout-nav').classList.remove('mx-0');
            document.querySelector(".fa-times").classList.add("fa-bars");
            document.querySelector(".fa-times").classList.remove("fa-times");
        }
    }
</script>
