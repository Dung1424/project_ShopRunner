<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="/images/hay.jpg" width="50px" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><b>{{auth()->user()->name}}</b></p>
            <p class="app-sidebar__user-designation">Welcome back</p>
        </div>
    </div>
    <hr>
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="{{url("admin/admin-dashboard")}}"><i class='app-menu__icon bx bx-tachometer'></i>
                <span class="app-menu__label">
Dashboard</span></a></li>
        <li><a class="app-menu__item active" href="{{url("admin/admin-quan-ly-nhan-vien")}}"><i class='app-menu__icon bx bx-id-card'></i>
                <span class="app-menu__label">
Employee manager</span></a></li>

        <li><a class="app-menu__item" href="{{url("admin/admin-quan-ly-san-pham")}}"><i class='app-menu__icon bx bx-purchase-tag-alt'></i>
                <span class="app-menu__label">
Product Management</span></a>
        </li>
        <li><a class="app-menu__item" href="{{url("admin/admin-quan-ly-đon-hang")}}"><i class='app-menu__icon bx bx-task'></i><span
                    class="app-menu__label">Order management</span></a></li>

        <li><a class="app-menu__item" href="{{url("admin/admin-quan-ly-khach-hang")}}"><i class='fa-solid fa-users'></i>
                <span style="margin-left: 21px" class="app-menu__label">Customer management</span></a>
        </li>
        <li><a class="app-menu__item" href="{{url("admin/admin-rating")}}"><i class='app-menu__icon bx bx-calendar-check'></i>
                <span class="app-menu__label">Review management</span></a></li>

        <li><a class="app-menu__item active" href="{{url("admin/admin-bao-cao-doanh-thu")}}"><i class='app-menu__icon bx bx-pie-chart-alt-2'></i>
                <span class="app-menu__label">Sales report</span></a>
        </li>

{{--                <li><a class="app-menu__item haha" href="phan-mem-ban-hang.html"><i class='app-menu__icon bx bx-cart-alt'></i>--}}
{{--                        <span class="app-menu__label">POS Bán Hàng</span></a></li>--}}
{{--        <li><a class="app-menu__item" href="table-data-banned.html"><i class='app-menu__icon bx bx-run'></i><span--}}
{{--                    class="app-menu__label">Thêm Nhân Viên--}}
{{--          </span></a></li>--}}
{{--        <li><a class="app-menu__item" href="table-data-money.html"><i class='app-menu__icon bx bx-dollar'></i><span--}}
{{--                    class="app-menu__label">Thêm sản phẩm</span></a></li>--}}

{{--        <li><a class="app-menu__item" href="page-calendar.html"><i class='app-menu__icon bx bx-calendar-check'></i><span--}}
{{--                    class="app-menu__label">Lịch công tác </span></a></li>--}}
{{--        <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài--}}
{{--            đặt hệ thống</span></a></li>--}}
    </ul>
</aside>

