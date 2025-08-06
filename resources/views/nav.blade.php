<nav class="bg-white shadow ">
    <div class="w-[100%] px-16 hidden xl:flex justify-between items-center ">
        <!-- Logo -->
        <img src="{{ asset('images/Alimsa studio logo - Copy.PNG') }}" alt="ALIMSA Studio Logo" class=" "
            width="100px">
        <!-- Nav Links -->
        <ul class="space-x-8 uppercase flex font-semibold text-sm desktop-layout">
            <li><a href="/" class="hover:text-blue-600">Home</a></li>
            <li><a href="/product" class="hover:text-blue-600">All Products</a></li>
            @if (count($categories)>0)
                <li class="">
                    <a class="drop-down-menu peer" href="#">Categories</a>
                    <ul class="drop-down-menu-item">
                        @foreach ($categories as $item)
                            <li class="my-4"><a href="/product/category/{{ $item->id }}"
                                    class="hover:text-blue-600 block hover:border-b hover:border-b-gray-300 font-bold">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endif
            <li><a href="/product/new" class="hover:text-blue-600">New Arrivals</a></li>
            {{-- <li><a href="/product" class="hover:text-blue-600">Sale</a></li> --}}
            <li><a href="/product/perfumes" class="hover:text-blue-600">Fragrances</a></li>
            <li><a href="/contact" class=" hover:text-blue-600">Contact Us</a></li>
            <li><a href="/login"><i class="fas hover:text-blue-600 fa-user"></i></a></li>
            <li><a href="/user/cart"><i class="fas hover:text-blue-600 fa-shopping-cart"></i></a></li>

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
            <li class="m-5 my-7"><a href="/" class="hover:text-blue-600">Home</a></li>
            <li class="m-5 my-7"><a href="/product" class="hover:text-blue-600">All Products</a></li>
            <li class="m-5 my-7">
                <a href="#" class="hover:text-blue-600 peer drop-down-menu">
                    Categories
                    <ul class="drop-down-menu-item">
                        @foreach ($categories as $item)
                            <li class="my-5">
                                <a href="/product/category/{{ $item->id }}"
                                    class="hover:text-blue-600 hover:border-b block hover:border-b-gray-300">{{ $item->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </a>
            </li>
            <li class="m-5 my-7"><a href="product/new" class=" hover:text-blue-600">New Arrivals</a></li>
            {{-- <li class="m-5 my-7"><a href="#" class=" hover:text-blue-600">Sale</a></li> --}}
            <li class="m-5 my-7"><a href="/product/perfumes" class=" hover:text-blue-600">Fragrances</a></li>
            <li class="m-5 my-7"><a href="/contact" class=" hover:text-blue-600">Contact Us</a></li>
            <li class="m-5 my-7"><a href="/login"> User Profile</a></li>
            <li class="m-5 my-7"><a href="/user/cart">Cart Items</a>
            </li>
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
