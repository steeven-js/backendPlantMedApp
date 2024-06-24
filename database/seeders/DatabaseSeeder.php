<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SymptomSeeder::class,
            PlantMedSeeder::class,
            PromotionSeeder::class,
            SlideSeeder::class,
            BannerSeeder::class,
        ]);

        // Attribuer aléatoirement le booléen is_featured à 10 des plantes médicinales

        $plantMeds = \App\Models\PlantMed::all();
        $featuredPlantMeds = $plantMeds->random(10);
        $featuredPlantMeds->each(function ($plantMed) {
            $plantMed->update(['is_featured' => true]);
        });

        // Attribuer aléatoirement le booléen is_best_seller à 10 des plantes médicinales

        $bestSellerPlantMeds = $plantMeds->random(10);
        $bestSellerPlantMeds->each(function ($plantMed) {
            $plantMed->update(['is_best_seller' => true]);
        });
    }
}
