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
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">Danh sách chương trình khuyến mãi</li>
                <li class="breadcrumb-item"><a href="#">Thêm chương trình khuyến mãi</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Thêm chương trình khuyến mãi</h3>
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group  col-md-8">
                                <label class="control-label">Tên chương trình khuyến mãi</label>
                                <input class="form-control" type="text" placeholder="Nhập tên chương trình">
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label">Ngày bắt đầu</label>
                                <input class="form-control" type="date" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleSelect1" class="control-label">Loại chương trình khuyến mãi </label>
                                <select class="form-control" id="exampleSelect1">
                                    <option>Giảm theo số tiền </option>
                                    <option>Giảm theo phần trăm</option>

                                </select>
                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label">Mức giảm</label>
                                <input class="form-control" type="text" placeholder="Theo % hoặc vnd" >

                            </div>
                            <div class="form-group  col-md-4">
                                <label class="control-label">Ngày kết thúc</label>
                                <input class="form-control" type="date">
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="control-label">Áp dụng cho  </label>
                                <select class="form-control" id="exampleSelect1">
                                    <option>Sản phẩm </option>
                                    <option>Nhóm sản phẩm</option>
                                    <option>Một category </option>

                                </select>
                            </div>

                            <div class="form-group  col-md-6">
                                <label class="control-label">Tìm kiếm thông tin</label>
                                <input type="text" class="form-control" placeholder="Nhập thông tin....">


                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Mô tả chương trình khuyến mãi</label>
                                <textarea class="form-control" name="mota" id="mota"placeholder="Mô tả thông tin khuyến mãi"></textarea>

                            </div>

                            <div class="form-group col-md-6">
                                <div class="filter-container__selected-filter-header clearfix">
                                    <span class="filter-container__selected-filter-header-title">Bạn chọn</span>
                                    <a href="javascript:void(0)" class="filter-container__clear-all d-lg-none">Bỏ hết </a>
                                    <a href="javascript:void(0)" class="filter-container__clear-all close_destop d-none d-lg-block">Bỏ hết</a>
                                </div>
                                <div class="filter-container__selected-filter-list">
                                    <ul>
                                        <li  class="filter-container__selected-filter-item" for="#"><i class="fa fa-close"></i>  Mũ</li>
                                        <li class="filter-container__selected-filter-item" for="#"><i class="fa fa-close"></i>  Quần áo</li>
                                        <li class="filter-container__selected-filter-item" for="#"><i class="fa fa-close"></i>  Phụ kiện</li>
                                        <li class="filter-container__selected-filter-item" for="#"><i class="fa fa-close"></i>  Nike</li>
                                        <li class="filter-container__selected-filter-item" for="#"><i class="fa fa-close"></i>  Adidas</li>
                                        <li class="filter-container__selected-filter-item" for="#"></i>  Puma</li>
                                        <li class="filter-container__selected-filter-item" for="#"></i>  Giày</li>
                                        <li class="filter-container__selected-filter-item" for="#"></i>  Đồng hồ thông minh</li>
                                    </ul>
                                </div>

                            </div>
                        </form>

                    </div>
                    <button class="btn btn-save" type="button">Lưu lại</button>
                    <a class="btn btn-cancel" href="/doc/table-data-oder.html">Hủy bỏ</a>
                </div>
            </div>
        </div>
    </main>


    <script>
        function removeFilteredItem(filterId) {
            const filterItem = document.querySelector(`.filter-container__selected-filter-item[for='${filterId}']`);
            filterItem.remove();
        }
    </script>

    @include("admin.layouts.scripts")
@endsection
