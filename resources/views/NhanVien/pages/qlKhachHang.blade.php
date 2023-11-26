@extends("admin.layouts.app")
@section("main")

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/admin/images/hay.jpg" width="50px"
                                            alt="User Image">
            <div>
                <p class="app-sidebar__user-name"><b>Võ Trường</b></p>
                <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
            </div>
        </div>
        <hr>
        <ul class="app-menu">
            <li ><a class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-san-pham")}}"><i
                        class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sản phẩm</span></a>
            </li>
            <li style=" background: #c6defd; border-radius: .375rem;"><a style="color: rgb(22 22 72)" class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-khach-hang")}}"><i class="fa-solid fa-users"></i><span style="margin-left: 21px"
                                                                                                                                class="app-menu__label">Quản lý khách hàng</span></a></li>
            <li ><a class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-đon-hang")}}"><i class='app-menu__icon bx bx-task'></i><span
                        class="app-menu__label">Quản lý đơn hàng</span></a></li>
            <li ><a class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-thong-tin-khuyen-mai")}}"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Quản lý thông tin khuyến mãi</span></a></li>

        </ul>
    </aside>



    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách khách hàng</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered js-copytextarea" cellpadding="0" cellspacing="0" border="0"
                               id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th width="150">Họ và tên</th>
                                <th >Ảnh thẻ</th>
                                <th width="200">Email</th>
                                <th >Giới tính</th>
                                <th >SĐT</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img width="100"  class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>

                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>Tạ Quang Long</td>
                                <td><img class="img-card-person" src="admin/images/hay.jpg" alt=""></td>
                                <td>QuangLong@gmail.com </td>
                                <td>Nam</td>
                                <td>0926737168</td>
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
                <h5>Chỉnh sửa thông tin nhân viên cơ bản</h5>
              </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ID nhân viên</label>
                            <input class="form-control" type="text" required value="#CD2187" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Họ và tên</label>
                            <input class="form-control" type="text" required value="Võ Trường">
                        </div>
                        <div class="form-group  col-md-6">
                            <label class="control-label">Số điện thoại</label>
                            <input class="form-control" type="number" required value="09267312388">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Địa chỉ email</label>
                            <input class="form-control" type="text" required value="truong.vd2000@gmail.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Ngày sinh</label>
                            <input class="form-control" type="date" value="15/03/2000">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="exampleSelect1" class="control-label">Chức vụ</label>
                            <select class="form-control" id="exampleSelect1">
                                <option>Bán hàng</option>
                                <option>Tư vấn</option>
                                <option>Dịch vụ</option>
                                <option>Thu Ngân</option>
                                <option>Quản kho</option>
                                <option>Bảo trì</option>
                                <option>Kiểm hàng</option>
                                <option>Bảo vệ</option>
                                <option>Tạp vụ</option>
                            </select>
                        </div>
                    </div>
                    <BR>
                    <a href="#" style="    float: right;
        font-weight: 600;
        color: #ea0000;">Chỉnh sửa nâng cao</a>
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

    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }



    </style>

    @include("admin.layouts.scripts")

@endsection
