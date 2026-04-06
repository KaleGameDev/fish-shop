<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem tài khoản admin này đã tồn tại chưa để tránh tạo trùng lặp
        $admin = User::where('email', 'admin@fishshop.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Quản trị viên',
                'email' => 'admin@fishshop.com', // Tên đăng nhập
                'password' => Hash::make('123'), // Mật khẩu 123 đã được mã hóa chuẩn Laravel
                'role' => 'admin',               // Phân quyền là admin
            ]);
            
            $this->command->info('Đã tạo tài khoản Admin thành công!');
        } else {
            $this->command->info('Tài khoản Admin đã tồn tại rồi!');
        }
    }
}