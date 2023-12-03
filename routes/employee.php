<?php
// giao diện nhân viên
Route::get('/nhan-vien-add-san-pham', [\App\Http\Controllers\Employee\EmployeeProductController::class,"AddSanPham"]);
Route::post('/nhan-vien-add-san-pham', [\App\Http\Controllers\Employee\EmployeeProductController::class,"store"]);
Route::get('/nhan-vien-quan-ly-san-pham', [\App\Http\Controllers\Employee\EmployeeProductController::class,"QuanLySanPham"]);
Route::get('/nhan-vien-edit-san-pham/{product}', [\App\Http\Controllers\Employee\EmployeeProductController::class,"editSanPham"]);
Route::put('/nhan-vien-edit-san-pham/{product}', [\App\Http\Controllers\Employee\EmployeeProductController::class,"update"]);
Route::delete('/nhan-vien-delete-san-pham/{product}', [\App\Http\Controllers\Employee\EmployeeProductController::class,"delete"]);

Route::get('/nhan-vien-quan-ly-đon-hang', [\App\Http\Controllers\Employee\EmployeeOrderController::class,"QuanLyDonHang"]);
Route::get('/nhan-vien-edit-đon-hang/{order}', [\App\Http\Controllers\Employee\EmployeeOrderController::class,"editDonHang"]);
Route::put('/nhan-vien-edit-đon-hang/{order}', [\App\Http\Controllers\Employee\EmployeeOrderController::class,"update"]);
Route::delete('/nhan-vien-delete-đon-hang/{order}', [\App\Http\Controllers\Employee\EmployeeOrderController::class,"delete"]);

Route::get('/nhan-vien-quan-ly-khach-hang', [\App\Http\Controllers\Employee\EmployeeController::class,"QuanLyKhachHang"]);
Route::get('/nhan-vien-quan-ly-thong-tin-khuyen-mai', [\App\Http\Controllers\Employee\EmployeeController::class,"QuanLyThongTinKhuyenMai"]);
Route::get('/nhan-vien-add-thong-tin-khuyen-mai', [\App\Http\Controllers\Employee\EmployeeController::class,"AddThongTinKhuyenMai"]);
