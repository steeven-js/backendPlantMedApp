<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'image' => 'https://everbloom.rn-admin.site/storage/MuVAapQZ8kQIVA5LquIIRMFHkdv0CD8hicIT6zg8.png',
                'promotion' => 'Enjoy 40% Off On Select Items!',
            ],
            [
                'image' => 'https://everbloom.rn-admin.site/storage/MuVAapQZ8kQIVA5LquIIRMFHkdv0CD8hicIT6zg8.png',
                'promotion' => 'Exclusive Weekend Deal! Save 20%!',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Banner::create($item);
        }
    }
}
