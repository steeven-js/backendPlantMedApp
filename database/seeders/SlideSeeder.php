<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $table->string('image')->nullable();
        // $table->string('promotion');
        // $table->string('title_line_1');
        // $table->string('title_line_2');

        $slides = [
            [
                'image' => 'https://everbloom.rn-admin.site/storage/elLSiuFkKzDlbNVs7FB9X0aNm3gH8DRQ6lEWdcg7.jpg',
                'promotion' => 'Enjoy 40% Off On Select Items!',
                'title_line_1' => 'Ashwagandha',
                'title_line_2' => 'Collection',
            ],
            [
                'image' => 'https://everbloom.rn-admin.site/storage/elLSiuFkKzDlbNVs7FB9X0aNm3gH8DRQ6lEWdcg7.jpg',
                'promotion' => 'Exclusive Weekend Deal! Save 20%!',
                'title_line_1' => 'Aloe vera',
                'title_line_2' => 'Collection',
            ],
            [
                'image' => 'https://everbloom.rn-admin.site/storage/elLSiuFkKzDlbNVs7FB9X0aNm3gH8DRQ6lEWdcg7.jpg',
                'promotion' => 'Enjoy 40% Off On Select Items!',
                'title_line_1' => 'Framboisier',
                'title_line_2' => 'Collection',
            ],
        ];

        foreach ($slides as $slide) {
            \App\Models\Slide::create($slide);
        }
    }
}
