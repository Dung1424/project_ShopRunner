@extends("admin.layouts.app")
@section("main")
    <main class="app-content">
        <section class="order_details section_gap">
            <div class="container">
                <div class="row order_d_inner">
                    <div class="col-lg-4">
                        <div class="details_item">
                            <h4>Order Info</h4>
                            <ul class="list">
                                <li><a href="#"><span>Order number</span>: {{$order->id}}</a></li>
                                <li><a href="#"><span>Date</span>: {{ $order->created_at->format('d/m/Y') }}</a></li>

                                <li><a href="#"><span>grand_total</span>: ${{$order->grand_total}}</a></li>

                                <li><a href="#"><span>Payment method</span>: {{ $order->payment_method }}</a></li>
                                <li><a href="#"><span>Status</span>: {!! $order->getStatus() !!}</a></li>

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
                @if($order->status === 5 || $order->status === 4 || $order->status === 3 )
                    <button type="submit" class="btn btn-warning" style="float: right; margin-top: 10px;"><a
                            href="admin/admin-quan-ly-đon-hang">Back</a></button>

                @elseif($order->status === 2 )
                    <form method="post" action="{{ route('update_order_status', ['order' => $order->id]) }}">
                        @csrf
                        <button onclick="return confirm('Surely you want to update the status to: Shipped')" type="submit" class="btn btn-warning" style="float: right; margin-top: 10px;">Shipped</button>
                    </form>
                @elseif($order->status === 1 )
                    <form method="post" action="{{ route('update_order_status', ['order' => $order->id]) }}">
                        @csrf
                        <button onclick="return confirm('Definitely want to update the status to: Shipping')" type="submit" class="btn btn-warning" style="float: right; margin-top: 10px;">Shipping</button>
                    </form>

                    <form method="post" action="{{ route('update_order_status_cancel', ['order' => $order->id]) }}">
                        @csrf
                        <button onclick="return confirm('Definitely want to cancel the order')" type="submit" class="btn btn-danger" style="float: right; margin-top: 10px; margin-right: 10px;">Cancel</button>
                    </form>
                @elseif($order->status === 0 )
                    <form method="post" action="{{ route('update_order_status', ['order' => $order->id]) }}">
                        @csrf
                        <button onclick="return confirm('Surely you want to update the status to: Confirmed')" type="submit" class="btn btn-warning" style="float: right; margin-top: 10px;">Confirmed</button>
                    </form>

                    <form method="post" action="{{ route('update_order_status_cancel', ['order' => $order->id]) }}">
                        @csrf
                        <button onclick="return confirm('Definitely want to cancel the order')" type="submit" class="btn btn-danger" style="float: right; margin-top: 10px; margin-right: 10px;">Cancel</button>
                    </form>
                @endif
            </div>

        </section>
    </main>





    @include("admin.layouts.scripts-formAdd")
    @include("admin.layouts.js_formAddSanPham")
    @include("admin.layouts.scripts")
@endsection

