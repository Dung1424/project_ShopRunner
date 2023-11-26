@extends("layouts.customer.app")
@section("main")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="{{url('/')}}">Home</a>
                            <a href="{{url('/shop')}}">Shop</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="{{url("/check-out")}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Billing Details</h6>

                            <div class="checkout__input">
                                <p>Full Name<span>*</span></p>
                                <input name="full_name" value="{{auth()?auth()->user()->name:old("full_name")}}" type="text" placeholder="Full Name">
                                @error("full_name")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input value="{{old("email")}}" name="email" type="email" placeholder="Email">
                                        @error("email")
                                        <p class="text-danger"><i>{{$message}}</i></p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Telephone<span>*</span></p>
                                        <input value="{{old("tel")}}" name="tel" type="tel" placeholder="Telephone">
                                        @error("tel")
                                        <p class="text-danger"><i>{{$message}}</i></p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input name="address" value="{{old("address")}}" type="text" placeholder="Street Address" class="checkout__input__add">
                                @error("address")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <!-- Thêm data-shipping-cost để lưu giá vận chuyển của từng phương thức -->
                            <div class="checkout__input__checkbox">
                                <p style="font-size: 18px ; font-family: Roboto,sans-serif;">Shipping method<span>*</span></p>
                                <label for="acc" data-shipping-cost="5">
                                    Express
                                    <input name="shipping_method" @if(old("shipping_method")== "Express") checked @endif value="Express" type="radio" id="acc">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="free" data-shipping-cost="0">
                                    Free Shipping
                                    <input name="shipping_method" @if(old("shipping_method")== "Free_Shipping") checked @endif value="Free_Shipping" type="radio" id="free">
                                    <span class="checkmark"></span>
                                </label>
                                @error("shipping_method")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach($cartShop as $item)
                                        <li>{{$item->name}} (x{{$item->buy_qty}})<span>${{$item->price * $item->buy_qty}}</span></li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span>${{$subtotal}}</span></li>
                                    <li>Tax(10%) <span>${{$subtotal * 0.1}}</span></li>
                                    <li>Shipping Fee <span>$0</span></li>
                                    <li>Total <span>${{$total}}</span></li>
                                </ul>

                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        COD
                                        <input name="payment_method"  @if(old("payment_method")== "COD") checked @endif value="COD" type="radio" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input name="payment_method"  @if(old("payment_method")== "Paypal") checked @endif  value="Paypal" type="radio" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                @error("payment_method")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var shippingMethodInputs = document.querySelectorAll('input[name="shipping_method"]');
            var shippingCostSpan = document.querySelector('.checkout__total__all li:nth-child(3) span');

            shippingMethodInputs.forEach(function (input) {
                input.addEventListener('change', function () {
                    var shippingCost = input.parentElement.getAttribute('data-shipping-cost');
                    shippingCostSpan.innerText = '$' + shippingCost;
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var shippingMethodInputs = document.querySelectorAll('input[name="shipping_method"]');
            var shippingCostSpan = document.querySelector('.checkout__total__all li:nth-child(3) span');
            var subtotalSpan = document.querySelector('.checkout__total__all li:nth-child(1) span');
            var taxSpan = document.querySelector('.checkout__total__all li:nth-child(2) span');
            var totalSpan = document.querySelector('.checkout__total__all li:nth-child(4) span');

            updateTotal();

            shippingMethodInputs.forEach(function (input) {
                input.addEventListener('change', function () {
                    updateTotal();
                });
            });

            function updateTotal() {
                var shippingCost = getSelectedShippingCost();
                shippingCostSpan.innerText = '$' + shippingCost;

                var subtotal = parseFloat(subtotalSpan.innerText.replace('$', ''));
                var tax = subtotal * 0.1;
                var total = subtotal + tax + parseFloat(shippingCost);

                taxSpan.innerText = '$' + tax.toFixed(2);
                totalSpan.innerText = '$' + total.toFixed(2);
            }

            function getSelectedShippingCost() {
                var selectedShippingInput = document.querySelector('input[name="shipping_method"]:checked');
                if (selectedShippingInput) {
                    return selectedShippingInput.parentElement.getAttribute('data-shipping-cost');
                }
                return 0;
            }
        });
    </script>



@endsection
