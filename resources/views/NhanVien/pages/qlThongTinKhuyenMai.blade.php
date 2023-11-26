@extends("admin.layouts.app")
@section("main")


    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="admin/images/hay.jpg" width="50px"
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
            <li><a class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-khach-hang")}}"><i class="fa-solid fa-users"></i><span style="margin-left: 21px"
                                                                                          class="app-menu__label">Quản lý khách hàng</span></a></li>
            <li ><a class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-đon-hang")}}"><i class='app-menu__icon bx bx-task'></i><span
                        class="app-menu__label">Quản lý đơn hàng</span></a></li>
            <li style=" background: #c6defd; border-radius: .375rem;"><a style="color: rgb(22 22 72)" class="app-menu__item" href="{{url("employee/nhan-vien-quan-ly-thong-tin-khuyen-mai")}}"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Quản lý thông tin khuyến mãi</span></a></li>

        </ul>
    </aside>

    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách thông tin khuyến mãi</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div style="justify-content: space-between;" class="row element-button">
                            <div class="col-sm-2">
                                <p >Danh sách thông tin khuyến mãi</p>
                            </div>

                            <div class="col-sm-2">

                                <a class="btn btn-add btn-sm" href="{{url("nhan-vien-add-thong-tin-khuyen-mai")}}" title="Thêm"><i class="fas fa-plus"></i>
                                    Thêm khuyến mãi mới</a>
                            </div>

                        </div>
                        <table  class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th width="10"><input type="checkbox" id="all"></th>
                                <th width="30px">ID</th>
                                <th>Tên chương trình khuyến mãi</th>
                                <th>Giảm giá</th>
                                <th width="100px">Trạng thái</th>
                                <th>Áp dụng cho</th>
                                <th>Thông tin</th>
                                <th>Ngày bắt đầu </th>
                                <th>Ngày kết thúc</th>
                                <th width="70px">Tính năng</th>
                                <th width="70px">Hành Động</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                <td>01</td>
                                <td>Giảm giá 40% cho Giày</td>
                                <td>400.000vnđ</td>
                                <td><span class="badge bg-success">Ngừng áp dụng</span></td>
                                <td>Sản Phẩm</td>
                                <td>Áo</td>
                                <td>15-07-2021 17:00:00</td>
                                <td>15-07-2021 18:00:00</td>
                                <td><button> áp dụng</button></td>
                                <td><button class="btn btn-primary btn-sm trash" type="button" title="Xóa"
                                            onclick="myFunction(this)"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                            data-target="#ModalUP"><i class="fas fa-edit"></i></button>

                                </td>
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
            <h5>Chỉnh sửa thông tin sản phẩm cơ bản</h5>
          </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Mã sản phẩm </label>
                            <input class="form-control" type="number" value="71309005">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Tên sản phẩm</label>
                            <input class="form-control" type="text" required value="Bàn ăn gỗ Theresa">
                        </div>
                        <div class="form-group  col-md-6">
                            <label class="control-label">Số lượng</label>
                            <input class="form-control" type="number" required value="20">
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="exampleSelect1" class="control-label">Tình trạng sản phẩm</label>
                            <select class="form-control" id="exampleSelect1">
                                <option>Còn hàng</option>
                                <option>Hết hàng</option>
                                <option>Đang nhập hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Giá bán</label>
                            <input class="form-control" type="text" value="5.600.000">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1" class="control-label">Danh mục</label>
                            <select class="form-control" id="exampleSelect1">
                                <option>Bàn ăn</option>
                                <option>Bàn thông minh</option>
                                <option>Tủ</option>
                                <option>Ghế gỗ</option>
                                <option>Ghế sắt</option>
                                <option>Giường người lớn</option>
                                <option>Giường trẻ em</option>
                                <option>Bàn trang điểm</option>
                                <option>Giá đỡ</option>
                            </select>
                        </div>
                    </div>
                    <BR>
                    <a href="#" style="    float: right;
    font-weight: 600;
    color: #ea0000;">Chỉnh sửa sản phẩm nâng cao</a>
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
    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }



    </style>
    @include("admin.layouts.scripts")
@endsection
