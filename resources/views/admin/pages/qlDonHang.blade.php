@extends("admin.layouts.app")
@section("main")

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách đơn hàng</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row element-button">
                            <div class="col-sm-2">

                                <a class="btn btn-add btn-sm" href="form-add-don-hang.html" title="Thêm"><i class="fas fa-plus"></i>
                                    Tạo mới đơn hàng</a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                        class="fas fa-file-upload"></i> Tải từ file</a>
                            </div>

                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                        class="fas fa-print"></i> In dữ liệu</a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                        class="fas fa-copy"></i> Sao chép</a>
                            </div>

                            <div class="col-sm-2">
                                <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                        class="fas fa-file-pdf"></i> Xuất PDF</a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                        class="fas fa-trash-alt"></i> Xóa tất cả </a>
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th>ID đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Tình trạng</th>
                                <th style="width: 70px;">Tính năng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>MD0837</td>
                                <td>Triệu Thanh Phú</td>
                                <td>Ghế làm việc Zuno, Bàn ăn gỗ Theresa</td>
                                <td>2</td>
                                <td>9.400.000 đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td><button class="btn btn-primary btn-sm trash"  type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp"
                                            data-toggle="modal" data-target="#ModalUP"><i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>MĐ8265</td>
                                <td>Nguyễn Thị Ngọc Cẩm</td>
                                <td>Ghế ăn gỗ Lucy màu trắng</td>
                                <td>1</td>
                                <td>3.800.000 đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"><i class="fa fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>MT9835</td>
                                <td>Đặng Hoàng Phúc</td>
                                <td>Giường ngủ Jimmy, Bàn ăn mở rộng cao cấp Dolas, Ghế làm việc Zuno</td>
                                <td>3 </td>
                                <td>40.650.000 đ</td>
                                <td><span class="badge bg-success">Hoàn thành</span></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"><i class="fa fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>ER3835</td>
                                <td>Nguyễn Thị Mỹ Yến</td>
                                <td>Bàn ăn mở rộng Gepa</td>
                                <td>1 </td>
                                <td>16.770.000 đ</td>
                                <td><span class="badge bg-info">Chờ thanh toán</span></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"><i class="fa fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>AL3947</td>
                                <td>Phạm Thị Ngọc</td>
                                <td>Bàn ăn Vitali mặt đá, Ghế ăn gỗ Lucy màu trắng</td>
                                <td>2 </td>
                                <td>19.770.000 đ</td>
                                <td><span class="badge bg-warning">Đang giao hàng</span></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"><i class="fa fa-edit"></i></button></td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>QY8723</td>
                                <td>Ngô Thái An</td>
                                <td>Giường ngủ Kara 1.6x2m</td>
                                <td>1 </td>
                                <td>14.500.000 đ</td>
                                <td><span class="badge bg-danger">Đã hủy</span></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa"><i class="fa fa-edit"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--
 MODAL
-->
    <div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-md-12">
            <span class="thong-tin-thanh-toan">
              <h5>Chỉnh sửa thông tin đơn hàng</h5>
            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ID đơn hàng</label>
                            <input class="form-control" type="text" required value="MD0837" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Khách hàng </label>
                            <input class="form-control" type="text" required value="Triệu Thanh Phú">
                        </div>
                        <div class="form-group  col-md-12">
                            <label class="control-label">Đơn hàng</label>
                            <!-- <input class="form-control" type="text" required value="Ghế làm việc Zuno, Bàn ăn gỗ Theresa"> -->
                            <textarea class="form-control" name="đơn hàng" id="đơn hàng">Ghế làm việc Zuno, Bàn ăn gỗ Theresa</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Số lượng</label>
                            <input class="form-control" type="number" required value="2">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Tổng tiền</label>
                            <input class="form-control" type="text" value="9.400.000 đ">
                        </div>
                        <div class="form-group  col-md-12">
                            <label for="exampleSelect1" class="control-label">Tình trạng</label>
                            <select class="form-control" id="exampleSelect1">
                                <option>Đã thanh toán </option>
                                <option>Chờ thanh toán</option>
                                <option>Đang giao hàng</option>
                                <option>Đã hủy</option>

                            </select>
                        </div>
                    </div>
                    <BR>

                    <BR>
                    <BR>
                    <button class="btn btn-save" type="button">Lưu lại</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    <BR>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!--
    MODAL
    -->

    @include("admin.layouts.scripts")

@endsection
