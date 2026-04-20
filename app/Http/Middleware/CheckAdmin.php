<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- ĐÂY CHÍNH LÀ DÒNG BẠN ĐANG THIẾU NÈ

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu đã đăng nhập và có quyền admin thì cho qua
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Nếu không phải admin, đuổi về trang chủ và báo lỗi
        return redirect()->route('shop.index')->with('error', 'Bạn không có quyền truy cập khu vực quản trị!');
    }
}