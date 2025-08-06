@php
    $totalBill = 0;

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="container">
        {{-- {{session('message')}} --}}
        <form action="/user/orders/make_payment" method="POST" enctype="multipart/form-data"
            onsubmit="return checkPayment(this)">
            @csrf
            @method('post')
            <div class="grid grid-cols-3">
                <div class="col-span-3 xl:col-span-2">
                    <h1 class="text-2xl bolder">Pending Orders</h1>
                    <p class="my-5">You have following pending orders, select orders to pay and make order done.</p>
                    <div class="table-responsive p-5">
                        <table class="table table-auto table-bordered">
                            <thead>
                                <tr>
                                    <th class="th-settings">SR#</th>
                                    <th class="th-settings">OrderID</th>
                                    <th class="th-settings">Product</th>
                                    <th class="th-settings">Product Size</th>
                                    <th class="th-settings">Product Price</th>
                                    <th class="th-settings">Product Amount</th>
                                    <th class="th-settings">Add On Price</th>
                                    <th class="th-settings">Total Bill</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingOrders as $index => $order)
                                    @php
                                        $product = DB::table('products')->where('id', '=', $order->product_id)->get();
                                        $size = DB::table('product_sizes')
                                            ->where('id', '=', $order->product_size_id)
                                            ->get();
                                        $totalBill += $order->total_price;
                                    @endphp
                                    <tr>
                                        <td class="td-settings">{{ $index + 1 }}</td>
                                        <td class="td-settings">
                                            <input type="checkbox"
                                                onchange="updateBill(this,'{{ $order->total_price }}')" checked
                                                name="orders[]" id="orders_{{ $order->id }}" value="{{$order->id}}">
                                            <label for="orders_{{ $order->id }}">{{ $order->order_id }}</label>
                                        </td>
                                        <td class="td-settings">{{ $product[0]->name }}</td>
                                        <td class="td-settings">
                                            {{ $order->product_size_id == null ? $product[0]->size : $size[0]->name }}
                                        </td>
                                        <td class="td-settings">Rs. {{ number_format($order->price, 0, ',') }}</td>
                                        <td class="td-settings">{{ $order->order_amount }}</td>
                                        <td class="td-settings">Rs.
                                            {{ $order->add_on_price == null ? '00.0' : number_format($order->add_on_price, 0, ',') }}
                                        </td>
                                        <td class="td-settings">Rs. {{ number_format($order->total_price, 0, ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="td-settings text-xl text-redish" colspan="7">Curior and Shippment
                                        charges (All Over Pakistan)</td>
                                    <td class="td-settings text-xl text-redish text-center ">Rs. +270</td>
                                </tr>
                                <tr>
                                    <td class="td-settings text-xl text-redish" colspan="7">Final Bill</td>
                                    <td class="td-settings text-xl text-redish text-center ">Rs. <span
                                            class="totalBillContainer">{{ $totalBill + 270 }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="order-receiving-message p-10">
                        <div class="cod-message py-5 border-b border-b-gray-400">
                            <p class="bolder">Curior Service: TCS and Leopard</p>
                            <p class="bolder">Curior Charge: Rs. +270 (All Over Pakistan)</p>
                            <p class="bolder">Recieving Date: Within 7 to 14 working days</p>
                        </div>
                        <p class="my-5 md:w-[50%]"><i class="text-redish bolder">Note: </i> It may take 1 to 2 working
                            business days to confirm
                            your order. We will notify you throgh and email or message about your order status and
                            shippment details</p>
                    </div>
                </div>
                <input type="hidden" name="amount_payable" id="" value="{{ $totalBill + 270 }}">
                <div class="col-span-3 xl:col-span-1 my-5 xl:my-5">
                    <h1 class="text-2xl bolder">Payment Process</h1>
                    <p class="my-5">Select your payment methods and address to complete this order</p>
                    @if (count($paymentMethods) > 0)
                        @php
                            $address1 = $paymentMethods[0]->address_1;
                            $address2 = $paymentMethods[0]->address_2;
                            $paymentMethodBank = $paymentMethods[0]->payment_method_bank;
                            $paymentMethodNumber = $paymentMethods[0]->payment_method_number;
                            $paymentMethodTitle = $paymentMethods[0]->payment_method_title;
                        @endphp
                        <div class="form-group my-3">
                            <label for="">Select your address</label>
                            <select name="address"
                                onchange="setAddress(this.value,'{{ $address1 }}','{{ $address2 }}')"
                                id="" class="input-control">
                                <option value="address1">Permanant</option>
                                <option value="address2">Residency</option>
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label for="">Receiving Address <span class="text-redish">(Updatable)
                                </span></label>
                            <textarea required class="input-control" name="r_address" rows="3" placeholder="Enter residental address...">{{ $address1 }}</textarea>
                            @error('address_1')
                                <span class="text-redish">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <label for="">Payment Method <span class="text-redish">*</span></label>
                            <select name="payment_method" class="input-control payment_method_selection"
                                onchange="setPaymentMethod(this.value)">
                                <option value="cod">Cash on Delivery (COD)</option>
                                <option value="online">Bank Payment (Online)</option>
                            </select>
                        </div>
                        <div
                            class="my-3 setOnlinePaymentFields border shadow-lg p-5 rounded border-gray-200 shadow-gray-200 hidden">
                            <p class="text-redish">Please make an online payment as given instruction below and fill out
                                this form</p>
                            <div class="form-group my-1">
                                <label for="">Your Account Bank <span class="text-redish">*</span></label>
                                <input type="text" name="account_bank" id=""
                                    value="{{ $paymentMethodBank }}"
                                    class="input-control online_account_bank online_payment_field">
                            </div>
                            <div class="form-group my-1">
                                <label for="">Your Account Number / IBAN <span
                                        class="text-redish">*</span></label>
                                <input type="text" name="account_number" id=""
                                    value="{{ $paymentMethodNumber }}"
                                    class="input-control online_account_number online_payment_field">
                            </div>
                            <div class="form-group my-1">
                                <label for="">Your Account Title <span class="text-redish">*</span></label>
                                <input type="text" name="account_title" id=""
                                    value="{{ $paymentMethodTitle }}"
                                    class="input-control online_account_title online_payment_field">
                            </div>
                            <div class="form-group my-1">
                                <label for="">Amount Paid <span class="text-redish">*</span></label>
                                <input type="text" name="amount_paid" id=""
                                    class="input-control online_amount_paid online_payment_field"
                                    placeholder="{{ $totalBill + 270 }}" value="{{ $totalBill + 270 }}" readonly>
                            </div>
                            <div class="form-group my-1">
                                <label for="">Transaction ID <span class="text-redish">*</span></label>
                                <input type="text" name="transaction_id" id="" value=""
                                    class="input-control online_transaction_id online_payment_field"
                                    placeholder="Copy and Paste ID here">
                            </div>
                            <div class="form-group my-1">
                                <label for="">Upload Screenshot <span class="text-redish">*</span></label>
                                <input type="file" accept=".jpg,.jpeg,.png" name="screenshot" id=""
                                    value="" class="input-control online_screenshot online_payment_field">
                            </div>
                        </div>
                    @else
                        <div class="mb-5">
                            <p class="text-redish">Warning! you have not set any settings for making your order</p>
                            <div class="my-5"></div>
                            <a href="/user/settings/" class="primary-text underline">Manage User Settings</a>
                        </div>
                    @endif

                    <div class="online-payment-message hidden my-3 py-5 border-y border-y-gray-400">
                        <h1 class="text-xl bolder">Bank Payment (Process)</h1>
                        <ol class="px-10 my-5">
                            <li class="list-disc">Account Bank: JazzCash</li>
                            <li class="list-disc">Account Number: 03038177758</li>
                            <li class="list-disc">Account Title: Sakhawat Ali</li>
                        </ol>
                        <p class="py-3 text-redish">Please pay us on the given bank details, once you
                            made the payment follow these steps</p>
                        <ol class="px-10" type="1">
                            <li class=" list-decimal">Take screenshot of payment reciept</li>
                            <li class=" list-decimal">Copy transaction ID from your bank application</li>
                            <li class=" list-decimal">Attach/Upload screenshot</li>
                            <li class=" list-decimal">Paste transaction id in the field</li>
                        </ol>
                    </div>

                    <div class="cod-payment-message my-3 py-5 border-y border-y-gray-400">
                        <h1 class="text-xl bolder">Cash On Delivery Process</h1>
                        <p class="my-5">
                            You will receive your order at your given address within 7 to 14 days, Make your payment
                            (Rs. {{ $totalBill }}) ready and pay once you receive the order. In case of any queries
                            or issues with your order contact us on given accounts
                        <ol class="px-10">
                            <li class="list-disc">Email: alimsa@contactemail.com</li>
                            <li class="list-disc">Phone: 03079228819</li>
                            <li class="list-disc">WhatsApp: 03079228819</li>
                        </ol>
                        </p>
                    </div>

                    @if (count($paymentMethods) > 0)
                        <div class="my-5">
                            <button class="primary-btn complete_order_btn" type="submit">Complete My Order</button>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @include('footer')
    <script>
        function updateBill(input, price) {
            total = parseInt(document.querySelector('.totalBillContainer').innerText);
            price = parseInt(price);
            if (input.checked) {
                total += price;
            } else {
                total -= price;
            }
            if(parseInt(total) == 270){
                document.querySelector(".complete_order_btn").classList.add("hidden");
            }else{
                document.querySelector(".complete_order_btn").classList.remove("hidden");
            }
            document.querySelector('.totalBillContainer').innerText = total;
            document.querySelector(".online_amount_paid").value = total;
            document.querySelector(".online_amount_paid").setAttribue('placeholder',total);
        }

        function setAddress(setter, address1, address2) {
            if (setter == 'address1') {
                document.querySelector("textarea").value = address1;
            }
            if (setter == 'address2') {
                document.querySelector("textarea").value = address2;
            }
        }

        function setPaymentMethod(paymentMethod) {
            if (paymentMethod == 'online') {
                document.querySelector(".online-payment-message").classList.remove("hidden");
                document.querySelector(".setOnlinePaymentFields").classList.remove("hidden");
                document.querySelector(".cod-payment-message").classList.add("hidden");
            } else {
                document.querySelector(".online-payment-message").classList.add("hidden");
                document.querySelector(".setOnlinePaymentFields").classList.add("hidden");
                document.querySelector(".cod-payment-message").classList.remove("hidden");
            }
        }

        function checkPayment(form) {
            let payment_method_selection = form.querySelector(".payment_method_selection");
            let [bank, number, title, amount, transaction, screenshot] = form.querySelectorAll(
                "input.online_payment_field");
            if (payment_method_selection.value == "online") {
                if (bank.value.length <= 0) {
                    alert("Please enter valid bank name");
                    return false;
                } else if (number.value.length <= 0) {
                    alert("Please enter valid account number / IBAN");
                    return false;
                } else if (title.value.length <= 0) {
                    alert("Please enter valid account title / name");
                    return false;
                } else if (amount.value.length <= 0) {
                    alert("Please enter valid paid amount");
                    return false;
                } else if (transaction.value.length <= 0) {
                    alert("Please enter valid transaction id");
                    return false;
                } else if (screenshot.value.length <= 0) {
                    alert("Please enter screenshot of payment ");
                    return false;
                } else {
                    return true;
                }

            } else {
                return true;
            }
        }
    </script>
</body>

</html>
