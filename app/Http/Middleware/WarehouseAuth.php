<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarehouseAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('warehouse_authenticated')) {
            return redirect()->route('warehouse.login.form')
                ->with('error', 'Vui lòng nhập mật khẩu kho để truy cập.');
        }

        return $next($request);
    }
}