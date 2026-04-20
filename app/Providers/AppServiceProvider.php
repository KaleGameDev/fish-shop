<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- THÊM DÒNG NÀY

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // BẬT PHÂN TRANG BẰNG BOOTSTRAP 5
        Paginator::useBootstrapFive(); 
    }
}