@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">Danh sách sản phẩm</li>
                <li class="breadcrumb-item"><a href="#">chỉnh sửa sản phẩm</a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tạo mới sản phẩm</h3>
                    <div class="tile-body">
                        <form class="row"  action="{{url("admin/admin-edit-đon-hang",['order'=>$order->id])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-group col-md-3">
                                <label class="control-label">User_id</label>
                                <input type="text" name="user_id" value="{{$order->user_id}}" class="form-control"  placeholder="Enter Full name" required>
                                @error("user_id")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label">Full Name</label>
                                <input type="text" name="full_name" value="{{$order->full_name}}" class="form-control"  placeholder="Enter Full name" required>
                                @error("full_name")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group  col-md-3">
                                <label for="exampleInputPassword1">Grand_total</label>
                                <input type="text" value="{{$order->grand_total}}" name="grand_total" class="form-control"  placeholder="Grand_total">
                                @error("grand_total")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>Shipping_method</label>
                                <input type="text" value="{{$order->shipping_method}}" name="shipping_method" class="form-control"  placeholder="shipping_method">
                                @error("shipping_method")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 ">
                                <label>Payment_method</label>
                                <input type="text" value="{{$order->payment_method}}" name="payment_method" class="form-control"  placeholder="payment_method">
                                @error("payment_method")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Paid</label>
                                <input type="number" value="{{$order->is_paid}}" name="is_paid" class="form-control"  placeholder="payment_method">
                                @error("is_paid")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Status</label>
                                <input type="text" value="{{$order->status}}" name="status" class="form-control"  placeholder="payment_method">
                                @error("status")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 ">
                                <label>Telephone</label>
                                <input type="text" value="{{$order->tel}}" name="tel" class="form-control" placeholder="Telephone">
                                @error("tel")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 ">
                                <label>Address</label>
                                <input type="text" value="{{$order->address}}" name="address" class="form-control"  placeholder="payment_method">
                                @error("address")
                                <p class="text-danger"><i>{{$message}}</i></p>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <button class="btn btn-save" type="submit">Submit</button>
                            </div>



                        </form>
                    </div>


                </div>
            </div>
        </div>
    </main>





    @include("admin.layouts.scripts-formAdd")
    @include("admin.layouts.js_formAddSanPham")
    @include("admin.layouts.scripts")
@endsection

