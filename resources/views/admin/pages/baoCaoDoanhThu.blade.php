@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="app-title">
                    <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><b>
                                    Sales report </b></a></li>
                    </ul>
                    <div id="clock"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class='icon  bx bxs-user fa-3x'></i>
                    <div class="info">
                        <h4>Total number of employees</h4>
                        <p><b>{{ $totalEmployees }} staff</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-purchase-tag-alt fa-3x'></i>
                    <div class="info">
                        <h4>Total number of products</h4>
                        <p><b>{{ $totalProducts }} product</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-shopping-bag-alt'></i>
                    <div class="info">
                        <h4>
                            Total order</h4>
                        <p><b>{{ $totalOrders }}Order</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class='icon fa-3x bx bxs-chart'></i>
                    <div class="info">
                        <h4>total income</h4>
                        <p><b>${{ number_format($totalRevenue, 2) }}</b></p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class='icon fa-3x bx bxs-tag-x'></i>
                    <div class="info">
                        <h4>Out of stock</h4>
                        <p><b>{{ $outOfStockProductCount }}Product</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class='icon fa-3x bx bxs-receipt'></i>
                    <div class="info">
                        <h4>
                            Order canceled</h4>
                        <p><b>{{ $totalCancelledOrders }} Order</b></p>
                    </div>
                </div>
            </div>
        </div>

        <!--thống kê -->
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">SALES STATISTICS BY YEAR</h3>
                    <form autocomplete="off" class="input-row">
                        <div class="input-col">
                            <p class="input-label">
                                Filter by:</p>
                            <select id="yearSelect1" onchange="changeYearProductSold(this.value)"
                                    class="dashboard-filter form-control">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023" selected>2023</option>
                            </select>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <canvas id="productSoldChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">
                        REVENUE STATISTICS BY YEAR</h3>
                    <form autocomplete="off" class="input-row">
                        <div class="input-col">
                            <p class="input-label">
                                Filter by:</p>
                            <select id="yearSelect2" onchange="changeYearRevenue(this.value)"
                                    class="dashboard-filter form-control">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023" selected>2023</option>
                            </select>
                        </div>
                    </form>
                    <div class="col-md-12">
                        <canvas id="revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">
                        SALES STATISTICS BY DAY </h3>
                    <form autocomplete="off" class="input-row">

                        <div class="input-col">
                            <p class="input-label">Since:</p>
                            <input type="text" id="datepicker1" class="form-control">
                            <input style="margin-top: 15px" type="button" id="btn-dashboard-filter"
                                   class="btn btn-primary btn-sm" value="Lọc kết quả">
                        </div>
                        <div class="input-col">
                            <p class="input-label">
                                To date:</p>
                            <input type="text" id="datepicker2" class="form-control">
                        </div>
                    </form>
                    <div class="col-md-12">
                        <canvas id="productSoldChartDay"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">
                        REVENUE STATISTICS BY DAY</h3>
                    <form autocomplete="off" class="input-row">

                        <div class="input-col">
                            <p class="input-label">Since:</p>
                            <input type="text" id="datepicker3" class="form-control">
                            <input style="margin-top: 15px" type="button" id="btn-dashboard-filter1"
                                   class="btn btn-primary btn-sm" value="Lọc kết quả">
                        </div>
                        <div class="input-col">
                            <p class="input-label">
                                To date:</p>
                            <input type="text" id="datepicker4" class="form-control">
                        </div>

                    </form>
                    <div class="col-md-12">
                        <canvas id="revenueDay"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tổng đơn hàng -->
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">
                            TOTAL ORDER</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTableOrder">
                            <thead>
                            <tr>
                                <th>ID </th>
                                <th>
                                    Customer</th>
                                <th>Order</th>
                                <th>Quantity</th>
                                <th>
                                    Total amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orderTotals as $orderTotal)
                                <tr>
                                    <td>{{ $orderTotal['order_id'] }}</td>
                                    <td>{{ $orderTotal['customer'] }}</td>
                                    <td>{{ $orderTotal['products'] }}</td>
                                    <td>{{ $orderTotal['total_quantity'] }}</td>
                                    <td>{{ $orderTotal['total_amount'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $orders->links("pagination::bootstrap-4") !!}
                    </div>
                </div>
            </div>
        </div>
        <!--đơn hàng chưa xử lý-->
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">ORDER HAS NOT BEEN PROCESSED </h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTableOrder">
                            <thead>
                            <tr>
                                <th>ID </th>
                                <th>Customer name</th>
                                <th> Customer Email</th>
                                <th>Telephone</th>
                                <th>Total amount</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pendingOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->full_name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->tel }}</td>
                                    <td>{{ $order->getGrandTotal() }}</td>
                                    <td>{!! $order->getStatus() !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $pendingOrders->links("pagination::bootstrap-4") !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Sản phẩm bán chạy -->
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">
                            SELLING PRODUCTS</h3>
                    </div>
                    <div class="tile-body">
                        @if ($bestSellingProducts->count() > 0)
                        <table class="table table-hover table-bordered" id="sampleTableFavorite">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product's name</th>
                                <th>Price</th>
                                <th>Quantity sold</th>
                                <th>Category</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($bestSellingProductDetails as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <img src="{{ $product->thumbnail }}" style="width: 100px; height: auto;" alt="">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->total_qty_sold }}</td> <!-- Thay $product-> total_sold thành $product->total_qty_sold -->
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        @else
                            <p>There are no best-selling products.</p>
                        @endif
                        {!! $bestSellingProducts->links("pagination::bootstrap-4") !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm đã hết -->
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div>
                        <h3 class="tile-title">PRODUCT IS SOLD OUT</h3>
                    </div>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTableProduct">
                            <thead>

                            <tr>
                                <th>ID</th>
                                <th>
                                    Product's name</th>
                                <th>image</th>
                                <th>
                                    Quantity</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Category</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($outOfStockProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ $product->thumbnail }}" alt="Product Image" width="100px"></td>
                                    <td>{{ $product->qty }}</td>
                                    <td><span class="badge bg-danger">Out of stock</span></td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->Category->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $outOfStockProducts->links("pagination::bootstrap-4") !!}
                    </div>
                </div>
            </div>

        </div>

        <div class="text-right" style="font-size: 12px">
            <p><b>Hệ thống quản lý V2.0 | Code by Trường</b></p>
        </div>
    </main>
        @include("admin.layouts.js_BaoCao")

    @endsection


