<?php
// dashboard
Route::get('/admin-dashboard', [\App\Http\Controllers\Admin\DashboardController::class,"adminDashboard"]);
// quản lý nhân viên
Route::get('/admin-quan-ly-nhan-vien', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"qlNhanVien"]);
Route::get('/admin-edit-nhan-vien/{user}', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"editNhanVien"]);
Route::put('/admin-edit-nhan-vien/{user}', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"update"]);
Route::get('/admin-add-nhan-vien', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"addNhanVien"]);
Route::post('/admin-add-nhan-vien', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"store"]);
Route::delete('/admin-delete-nhan-vien/{user}', [\App\Http\Controllers\Admin\EmployeeManagerController::class,"delete"]);

// quản lý khách hàng
Route::get('/admin-quan-ly-khach-hang', [\App\Http\Controllers\Admin\CustomerManagerController::class,"qlKhachHang"]);
Route::get('/admin-order-user/{user}', [\App\Http\Controllers\Admin\CustomerManagerController::class,"orderUser"]);
Route::get('/admin-order-user-detail/{order}', [\App\Http\Controllers\Admin\CustomerManagerController::class,"orderDetailUser"]);


// quản lý đơn hàng
Route::get('/admin-quan-ly-đon-hang', [\App\Http\Controllers\Admin\OrderManagerController::class,"qlDonHang"]);
Route::get('/admin-detail/{order}', [\App\Http\Controllers\Admin\OrderManagerController::class, "detail"]);
Route::post('update-order-status/{order}', [\App\Http\Controllers\Admin\OrderManagerController::class, "updateOrderStatus"])->name('update_order_status');
Route::post('update-order-status-cancel/{order}', [\App\Http\Controllers\Admin\OrderManagerController::class, "updateOrderStatusCancel"])->name('update_order_status_cancel');

// quản lý sản phẩm
Route::get('/admin-quan-ly-san-pham', [\App\Http\Controllers\Admin\ProductManagerController::class,"qlSanPham"]);
Route::get('/admin-add-san-pham', [\App\Http\Controllers\Admin\ProductManagerController::class,"addSanPham"]);
Route::post("/admin-add-san-pham", [\App\Http\Controllers\Admin\ProductManagerController::class, "store"]);
Route::get('/admin-edit-san-pham/{product}', [\App\Http\Controllers\Admin\ProductManagerController::class,"editSanPham"]);
Route::put('/admin-edit-san-pham/{product}', [\App\Http\Controllers\Admin\ProductManagerController::class,"update"]);
Route::delete("/admin-delete-san-pham/{product}", [\App\Http\Controllers\Admin\ProductManagerController::class, "delete"]);


// rating
Route::get('/admin-rating', [\App\Http\Controllers\Admin\ReviewManagerController::class,"adminRating"]);
Route::get('/admin-rating-details/{product_id}', [\App\Http\Controllers\Admin\ReviewManagerController::class, 'ratingDetails'])->name('admin-rating-details');

// báo cáo doanh thu
Route::get('/admin-bao-cao-doanh-thu', [\App\Http\Controllers\Admin\SalesReport::class, "baoCaoDoanhThu"]);
// theo năm
Route::get("/revenue-chart", [\App\Http\Controllers\Admin\SalesReport::class, "revenueChart"]);
Route::get("/revenue-chart-doanh-thu", [\App\Http\Controllers\Admin\SalesReport::class, "revenueChartDoanhThu"]);
//theo ngày
Route::get("/revenue-chart-day", [\App\Http\Controllers\Admin\SalesReport::class, "revenueChartDay"]);
Route::get("/revenue-chart-doanh-thu-day", [\App\Http\Controllers\Admin\SalesReport::class, "revenueChartDoanhThuDay"]);
