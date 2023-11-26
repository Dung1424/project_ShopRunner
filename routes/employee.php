<?php
// giao diện nhân viên
Route::get('/nhan-vien-add-san-pham', [\App\Http\Controllers\NhanVienProductController::class,"AddSanPham"]);
Route::post('/nhan-vien-add-san-pham', [\App\Http\Controllers\NhanVienProductController::class,"store"]);
Route::get('/nhan-vien-quan-ly-san-pham', [\App\Http\Controllers\NhanVienProductController::class,"QuanLySanPham"]);
Route::get('/nhan-vien-edit-san-pham/{product}', [\App\Http\Controllers\NhanVienProductController::class,"editSanPham"]);
Route::put('/nhan-vien-edit-san-pham/{product}', [\App\Http\Controllers\NhanVienProductController::class,"update"]);
Route::delete('/nhan-vien-delete-san-pham/{product}', [\App\Http\Controllers\NhanVienProductController::class,"delete"]);

Route::get('/nhan-vien-quan-ly-đon-hang', [\App\Http\Controllers\NhanVienOrderController::class,"QuanLyDonHang"]);
Route::get('/nhan-vien-edit-đon-hang/{order}', [\App\Http\Controllers\NhanVienOrderController::class,"editDonHang"]);
Route::put('/nhan-vien-edit-đon-hang/{order}', [\App\Http\Controllers\NhanVienOrderController::class,"update"]);
Route::delete('/nhan-vien-delete-đon-hang/{order}', [\App\Http\Controllers\NhanVienOrderController::class,"delete"]);

Route::get('/nhan-vien-quan-ly-khach-hang', [\App\Http\Controllers\NhanVienController::class,"QuanLyKhachHang"]);
Route::get('/nhan-vien-quan-ly-thong-tin-khuyen-mai', [\App\Http\Controllers\NhanVienController::class,"QuanLyThongTinKhuyenMai"]);
Route::get('/nhan-vien-add-thong-tin-khuyen-mai', [\App\Http\Controllers\NhanVienController::class,"AddThongTinKhuyenMai"]);
