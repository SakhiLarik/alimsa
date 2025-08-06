<div class="bars block md:hidden fixed text-right bg-white z-10 w-full shadow border-b border-b-slate-300 p-5">
    <i onclick="popoutNav()" class="text-xl fa fa-bars cursor-pointer"></i>
</div>
<nav
    class="hidden mobile-layout-nav md:block md:left-0 w-56 text-white h-full bg-primary fixed top-0 shadow-md shadow-black z-20">
    <div class="text-center pt-10 pb-5">
        <h1 style="font-weight: 900"; class="text-4xl"> ALIMSA </h1>
        <small class="text-2xl text-redish" style="font-weight: 600";>Studio</small>
        {{-- <div class="flex px-5 py-4 justify-center items-center ">
            <img src="{{ asset('images/Alimsa studio logo - Copy.PNG') }}" alt="ALIMSA Studio Logo" class=""
                width="100px">
        </div> --}}
    </div>
    <ul class="block ">
        <li><a href="/admin/dashboard" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"><i
                    class="fa mx-1 fa-dashboard"></i>
                Dashboard </a></li>
        <li>
            <a href="#"
                class="peer transition-all duration-500  block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa mx-1 fa-receipt"></i>
                Orders </a>
            <ul class="my-2 hidden h-0 peer-focus:h-fit peer-focus:block hover:block hover:h-fit text-sm transition-all duration-500 ">
                <li><a class="mx-5 px-5 block border-b border-b-gray-200 py-2 hover:bg-white text-redish-hover"
                        href="/admin/orders">All</a></li>
                <li><a class="mx-5 px-5 block border-b border-b-gray-200 py-2 hover:bg-white text-redish-hover"
                        href="/admin/orders/active">Active</a></li>
                <li><a class="mx-5 px-5 block border-b border-b-gray-200 py-2 hover:bg-white text-redish-hover"
                        href="/admin/orders/shipped">Shipped</a></li>
                        <li><a class="mx-5 px-5 block border-b border-b-gray-200 py-2 hover:bg-white text-redish-hover"
                        href="/admin/orders/delivered">Delivered</a></li>
                <li><a class="mx-5 px-5 block border-b border-b-gray-200 py-2 hover:bg-white text-redish-hover"
                        href="/admin/orders/completed">Completed</a></li>
            </ul>
        </li>
        <li><a href="/admin/categories" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa mx-1 fa-list-check"></i>
                Categories </a></li>
        <li><a href="/admin/products" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa mx-1 fa-shop"></i>
                Products </a></li>
        <li><a href="/admin/addons" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa mx-1  fa-audio-description"></i>
                Add On Feature</a></li>
        <li><a href="/admin/users" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover "><i
                    class="fas mx-1 fa-user-shield "></i>
                Users </a></li>
        <li><a href="/admin/users/ratings" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover "><i
                    class="fas mx-1 fa-star "></i>
                Reviews </a></li>
        <li><a href="/admin/users/comments" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover "><i
                    class="fas mx-1 fa-message"></i>
                Comments </a></li>
        <li><a href="/admin/contacts" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa fa-users mx-1"></i>
                Contacts </a></li>
                <li><a href="/admin/settings" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover"> <i
                    class="fa fa-cogs mx-1"></i>
                Settings </a></li>
        {{-- <li><a href="/admin/carts" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover "><i
                    class="fas mx-1 fa-shopping-cart"></i>
                Carts </a></li>
        <li><a href="/admin/favourites" class=" block w-full px-5 py-4 hover:bg-white text-redish-hover "><i
                    class="fas mx-1 fa-heart "></i>
                Favourite </a></li> --}}
        <li><a href="/admin/logout" class="block w-full px-5 py-4 hover:bg-white text-redish-hover text-redish"><i
                    class="fas text-redish mx-1 fa-sign-out"></i> Logout</a></li>
    </ul>
    <!-- Icons -->
    </div>
</nav>


<script>
    function popoutNav() {
        if (document.querySelector('.mobile-layout-nav').classList.contains('hidden')) {
            document.querySelector('.mobile-layout-nav').classList.remove('hidden');
            document.querySelector(".fa-bars").classList.add("fa-times");
            document.querySelector(".fa-bars").classList.remove("fa-bars");
        } else {
            document.querySelector('.mobile-layout-nav').classList.add('hidden');
            document.querySelector(".fa-times").classList.add("fa-bars");
            document.querySelector(".fa-times").classList.remove("fa-times");
        }
    }
</script>
