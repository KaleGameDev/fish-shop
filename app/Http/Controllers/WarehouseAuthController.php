<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('warehouse.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if ($request->password === env('WAREHOUSE_PASSWORD')) {
            session([
                'warehouse_authenticated' => true,
            ]);

            return redirect()
                ->route('warehouse.products.index')
                ->with('success', 'Đăng nhập kho thành công.');
        }

        return back()
            ->withInput()
            ->with('error', 'Mật khẩu kho không đúng.');
    }

    public function logout()
    {
        session()->forget('warehouse_authenticated');

        return redirect()
            ->route('shop.index')
            ->with('success', 'Đã thoát khỏi khu quản lý kho.');
    }
}