<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Cá hồi Nauy',
                'price' => 150000,
                'stock' => 10,
                'image' => 'https://picsum.photos/seed/salmon/600/400',
                'description' => 'Thịt chắc, tươi ngon.'
            ],
            [
                'name' => 'Cá thu',
                'price' => 90000,
                'stock' => 20,
                'image' => 'https://picsum.photos/seed/mackerel/600/400',
                'description' => 'Ít xương, hợp chiên.'
            ],
        ]);
    }
}
