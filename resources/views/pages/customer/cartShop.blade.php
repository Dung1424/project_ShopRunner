@extends("layouts.customer.app")
@section("main")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <a href="{{url("/category")}}">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            @if(count($cartShop)==0)
                <p>There are no products in the cart</p>
            @else

                <div class="row">
                    <div class="col-lg-8">
                        <div class="shopping__cart__table">
                            <table>
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($cartShop)
                                    @foreach ($cartShop as $item)
                                        <tr>
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="{{ $item->thumbnail }}" width="100" height="100" alt="">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6>{{ $item->name }}</h6>
                                                </div>
                                            </td>

                                            <td class="cart__price">${{ $item->price }}</td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <form action="{{ url("/update-cart", ["product" => $item->id]) }}" method="post">
                                                        @csrf
                                                        <div class="pro-qty" style="margin-top: 41px" >
                                                            <input  type="text" name="buy_qty" value="{{ $item->buy_qty }}">
                                                        </div>
                                                        @if ($item->buy_qty > $item->qty)
                                                            <p class="text-danger">The product is out of stock</p>
                                                        @endif
                                                        <button type="submit" class="btn btn-update update-button">Update</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="cart__price">${{ $item->price * $item->buy_qty }}</td>
                                            <td class="cart__close">
                                                <a href="/delete-from-cart/{{ $item->id }}"><i class="fa fa-close"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Display error message below the product -->
                                        <td colspan="5">
                                            @if(session()->has("cart_errors") && array_key_exists("error_".$item->id, session("cart_errors")))
                                                <div class="alert alert-danger" role="alert">
                                                    {{ session("cart_errors")["error_".$item->id] }}
                                                </div>
                                            @endif
                                        </td>

                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn">
                                    <a href="{{url("/category")}}">Countinue Shopping</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn update__btn">
                                    <a href="/clear-cart"><i class="fa fa-spinner"></i> Clear Cart</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">

                         <div class="cart__total">
                            <h6>Cart total</h6>
                             <ul>
                                <li>Subtotal <span>${{$subtotal}}</span></li>
                                 <li>Tax(10%) <span>${{$subtotal * 0.1}}</span></li>
                                <li>Total <span>${{$total}}</span></li>
                             </ul>
                         <a style="padding: 14px 60px;" href="{{url('/check-out')}}" class="site-btn btn @if(!$can_checkout)disabled @endif">Proceed to checkout</a>
                     </div>
                </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    <style>
        .btn-update {
            color: #fff;

            width: 120px;
            transition: background-color 0.3s;
        }

        .btn-update:hover {
            background-color: #007bff;
            color:#fff ; /* Giữ màu chữ xanh mặc định */

            width: 120px;
        }
    </style>



@endsection
