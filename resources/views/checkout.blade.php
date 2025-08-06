@php
    use App\Models\Product;
    $totalBill = 0;
    $productCounter = 0;
@endphp
<!DOCTYPE html>
<html lang="en">

@include('head')
<body>

    <!-- Top Bar -->

    <!-- Navbar -->
    @include('users.nav')

    <div class="container">
        <form action="/user/orders/order_now/" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="checkout-container p-5">
                <div class="my-5">
                <h1 class="text-3xl bolder">Checkout</h1>
                <p class="py-5">Confirm your order, amount and sizes and manage prices to checkout.</p>
                </div>
                <div class="data-conatiner w-full">
                    <table class="table table-responsive table-auto table-bordered w-full">
                        <thead class="space-y-3">
                            <tr>
                                <th class="cart-th">Product</th>
                                <th class="cart-th">Amount</th>
                                <th class="cart-th">Size</th>
                                <th class="cart-th">Add On</th>
                                <th class="cart-th">Price / Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $index => $item)
                                @php
                                    $product = Product::find($item->product_id);
                                    $sizes = DB::table('product_sizes')
                                        ->where('product_id', '=', $product['id'])
                                        ->get();
                                    $addOn = DB::table('add_on_features')->where('product', '=', $product['id'])->get();
                                    $defaultPrice = $product['price'];
                                    $totalBill += $defaultPrice;
                                    $productCounter++;
                                @endphp
                                <tr>
                                    <input type="hidden" name="products[]" value="{{ $product->id }}">
                                    <input type="hidden" name="prices[]" value="{{ $product->price }}"
                                        class="product_input_{{ $product->id }} product_prices_input">
                                    <input type="hidden" name="size_{{ $product->id }}"
                                        class="size_{{ $product->id }}" value="0">
                                    <input type="hidden" name="addOn_{{ $product->id }}"
                                        class="addOn_{{ $product->id }}" value="0">
                                    <td class="td-settings">
                                        <center>
                                            <p class="text-md py-3 bolder">{{ $product['name'] }} (Rs.
                                                {{ $product['price'] }})</p>
                                            <img src="{{ asset($product['image']) }}"
                                                class="w-fit h-32 my-5  shadow border rounded-md shadow-gray-300 border-gray-100"
                                                alt="">
                                            <a class="secondary-btn px-10 my-5 w-full rounded-md"
                                                href="/user/cart/remove/{{ $item->id }}"><i class="fa fa-trash">
                                                </i>
                                            </a>
                                        </center>
                                    </td>
                                    <td class="td-settings">
                                        <input type="number" onchange="updateTotalBill(this.value)"
                                            class="border product_amount_input border-slate-300 px-2 py-1"
                                            min="1" max="10" value="1" name="amounts[]">
                                    </td>
                                    <td class="td-settings">
                                        <select
                                            onchange="setSelectedSize('product_input_{{ $product->id }}','product_{{ $product->id }}',this.value,'size_{{ $product->id }}')"
                                            value=""
                                            class="border w-full p-2 rounded-md shadow-md shadow-gray-300 border-gray-300">
                                            @foreach ($sizes as $index => $size)
                                                <option value="{{ $size->price }}-{{ $size->id }}">
                                                    {{ $size->name }} (Rs. {{ $size->price }})</option>
                                            @endforeach
                                            <option selected value="{{ $product->price }}">{{ $product->size }} (Rs.
                                                {{ $product->price }})</option>
                                        </select>
                                    </td>
                                    <td class="td-settings w-64">
                                        @if (count($addOn) > 0)
                                            <input onchange="addAddOn(this, 'addOn_{{ $product->id }}')"
                                                type="checkbox" value="{{ $addOn[0]->price }}"
                                                name="addOn_price_{{ $product->id }}" id="addon_{{ $addOn[0]->id }}"
                                                class="product_addons_input">
                                            <label class="bolder" for="addon_{{ $addOn[0]->id }}">Add Matching
                                                {{ $addOn[0]->name }} (+Rs. {{ $addOn[0]->price }})
                                                <img src="{{ asset($addOn[0]->image) }}" alt=""
                                                    class="h-32 my-5 w-full shadow border rounded-md shadow-gray-300 border-gray-100">
                                            </label>
                                            <div>
                                                <label for="">Select Size</label>
                                                <select value="" name="addOn_size_{{$product->id}}" class="border w-full p-2 rounded-md shadow-md shadow-gray-300 border-gray-300">
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                </select>
                                            </div>
                                        @else
                                            <input type="checkbox" hidden value="0" name="addOn_price_{{ $product->id }}">
                                            <p>No Matching Items Available</p>
                                        @endif
                                    </td>
                                    <td
                                        class="td-settings product_prices_containers bolder product_{{ $product->id }}">
                                        Rs. {{ $defaultPrice }}</td>
                                </tr>
                            @endforeach
                            <tr class="text-redish">
                                <th class="bolder td-settings text-redish text-xl" colspan="4">Final Bill</th>
                                <th class="bolder td-settings text-redish text-xl bolder totalBillTH">Rs.
                                    {{ $totalBill }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" class="totalBillInput" name="totalBill" value="{{ $totalBill }}">
            @if ($productCounter > 0)
                <button type="submit" class="primary-btn mx-5">Make Payment Now</button>
            @endif
        </form>
    </div>

    {{-- Newsletter --}}
    @include('newsletter')

    <!-- Footer -->
    @include('footer')
    <script>
        let totalBillInput = document.querySelector(".totalBillInput");
        let totalBillTH = document.querySelector(".totalBillTH");

        function updateImageContent(div) {
            document.querySelector("img.main-image").src = div.querySelector("img").src;
        }

        function setSelectedSize(input, price, setNewPrice, setSize) {
            let [setPriceValue, setSizeValue] = setNewPrice.split("-");

            document.querySelector(`.${input}`).value = parseInt(setPriceValue);
            document.querySelector(`.${price}`).innerText = "Rs. " + parseInt(setPriceValue);

            document.querySelector(`.${setSize}`).value = isNaN(setSizeValue) ? "0" : parseInt(setSizeValue);
            updateTotalAmountAndBill();
        }

        function addAddOn(input, setterInput) {
            if (input.checked) {
                document.querySelector(`.${setterInput}`).value = 1;
            } else {
                document.querySelector(`.${setterInput}`).value = 0;
            }
            updateTotalAmountAndBill();
        }

        function updateTotalBill(amount) {
            if (amount.value > 10) {
                amount.value = 10;
            }
            if (amount.value <= 0) {
                amount.value = 1;
            }
            updateTotalAmountAndBill();
        }

        function updateTotalAmountAndBill() {
            let total = 0;

            let priceContainers = document.querySelectorAll(".product_prices_containers");
            let allPrices = document.querySelectorAll(".product_prices_input");
            let allPricesAmount = document.querySelectorAll(".product_amount_input");
            let allAddOns = document.querySelectorAll(".product_addons_input");

            allPrices.forEach((element, index) => {
                total += parseInt(element.value * allPricesAmount[index].value);
                priceContainers[index].innerText = "Rs. " + parseInt(element.value * allPricesAmount[index].value);;
            });

            allAddOns.forEach((element, index) => {
                if (element.checked) {
                    total += parseInt(element.value);
                }
            });
            totalBillInput.value = total;
            totalBillTH.innerText = "Rs. " + total;
        }
    </script>

</body>

</html>


{{--
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
 --}}
