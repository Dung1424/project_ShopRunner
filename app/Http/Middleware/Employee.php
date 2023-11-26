<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!auth()->check()) {
            return redirect()->route("login");
        }

        // Kiểm tra xem người dùng có quyền "Admin" hoặc "EMPLOYEE" hay không
        $user = auth()->user();
        if ($user->role == "ADMIN" || $user->role == "EMPLOYEE") {
            return $next($request); // Cho phép truy cập cả trang "Admin" và "Employee"
        }
        return abort(404);
    }

}
