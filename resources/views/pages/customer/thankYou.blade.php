@extends("layouts.customer.app")
@section("main")

    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Thank You</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Thank You</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="order_details section_gap">
        <div class="container">
            @if($order->payment_method == "Paypal" && !$order->is_paid)
                <h3 style="margin-top: 80px; color: #e0a800" class="title_confirmation">Please pay again</h3>
            @else
                <h3 style="margin-top: 80px;font-size: 28px ; font-family: Roboto,sans-serif;" class="title_confirmation">Thank you. Your order has been received.</h3>
            @endif
            <div class="row order_d_inner">
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <ul class="list">
                            <li><a href="#"><span>Order number</span>: {{$order->id}}</a></li>
                            <li><a href="#"><span>Date</span>: {{ $order->created_at->format('d/m/Y') }}</a></li>

                                <li><a href="#"><span>Total</span>: ${{$order->grand_total}}</a></li>

                            <li><a href="#"><span>Payment method</span>: {{ $order->payment_method }}</a></li>
                            @if ($order->getStatus() != '<span class="text-danger">Huỷ</span>')
                                <li><a href="#"><span>Status</span>: {!! $order->getStatus() !!}</a></li>
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Customer Information</h4>
                        <ul class="list">
                            <li><a href="#"><span>Full Name</span>: {{ $order->full_name}}</a></li>
                            <li><a href="#"><span>Telephone</span>: {{ $order->tel}}</a></li>
                            <li><a href="#"><span>Email</span>: {{ $order->email }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Shipping</h4>
                        <ul class="list">
                            <li><a href="#"><span>Shipping method</span>: {{ $order->shipping_method }}</a></li>
                            <li><a href="#"><span>Address</span>: {{ $order->address }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->Products as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{$item->thumbnail}}" width="120"/></td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->pivot->price}}</td>
                                <td>{{$item->pivot->qty}}</td>
                                <td>${{$item->pivot->qty*$item->pivot->price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($order->payment_method == "Paypal" && !$order->is_paid)
                <a style="float: right; margin-top: 10px;" href="{{url('/check-out')}}" class="btn btn-warning">
                    Payment again</a>
            @endif
        </div>

    </section>
@endsection
