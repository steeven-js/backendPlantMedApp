<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Enjoy 40% Off On Select Items!',
            ],
            [
                'name' => 'Exclusive Weekend Deal! Save 20%!',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Promotion::create($item);
        }
    }
}
