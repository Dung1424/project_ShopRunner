<?php

namespace App\Http\Controllers\Employee;

class EmployeeController
{
    public function QuanLyDonHang(){
        return view("NhanVien.pages.qlDonHang");
    }



    public function QuanLyKhachHang(){
        return view("NhanVien.pages.qlKhachHang");
    }

    public function QuanLyThongTinKhuyenMai(){
        return view("NhanVien.pages.qlThongTinKhuyenMai");
    }

    public function AddThongTinKhuyenMai(){
        return view("NhanVien.pages.addThongTinKhuyenMai");
    }
}
