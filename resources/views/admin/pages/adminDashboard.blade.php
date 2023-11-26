@extends("admin.layouts.app")
@section("main")
    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><b>Dashboard</b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <!--Left-->
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
                            <div class="info">
                                <h4>Total Customer</h4>
                                <p><b>{{$totalUser}} Customer</b></p>
                                <p class="info-tong">Total number of customers.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
                            <div class="info">
                                <h4>Total number of products</h4>
                                <p><b>{{ $totalProducts }} product</b></p>
                                <p class="info-tong">The total number of products is managed.</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
                            <div class="info">
                                <h4>Total order</h4>
                                <p><b>{{ $totalOrders }} Order</b></p>
                                <p class="info-tong">Total sales invoice number</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-6 -->
                    <div class="col-md-6">
                        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
                            <div class="info">
                                <h4>Out of stock</h4>
                                <p><b>{{ $outOfStockProductCount }} Product</b></p>
                                <p class="info-tong">Number of products out of stock</p>
                            </div>
                        </div>
                    </div>
                    <!-- col-12 -->
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">Order status</h3>
                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>Customer name</th>
                                        <th>Total amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($pendingOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->full_name }}</td>
                                            <td>{{ $order->getGrandTotal() }}</td>
                                            <td>{!! $order->getStatus() !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- / div trống-->
                        </div>
                    </div>
                    <!-- / col-12 -->
                    <!-- col-12 -->
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">SELLING PRODUCTS</h3>
                            <div>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID Product</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity sold</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($bestSellingProductDetails as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->total_qty_sold }}</td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- / col-12 -->
                </div>
            </div>
            <!--END left-->
            <!--Right-->
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">Sales statistics of 2023</h3>
                            <div class="col-md-12">
                                <canvas id="productSoldChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="tile">
                            <h3 class="tile-title">Statistics of revenue of 2023</h3>
                            <div class="col-md-12">
                                <canvas id="revenue"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--END right-->
        </div>


        <div class="text-center" style="font-size: 13px">
            <p><b>Copyright
                    <script type="text/javascript">
                        document.write(new Date().getFullYear());
                    </script> Phần mềm quản lý bán hàng | Dev By Trường
                </b></p>
        </div>
    </main>
    @include("admin.layouts.js_BaoCao")
@endsection
