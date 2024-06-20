<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlantMed;

class PlantMedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $symptoms = [
            'Fever',
            'Cough',
            'Shortness of breath',
            'Fatigue',
            'Muscle or body aches',
            'Headache',
            'New loss of taste or smell',
            'Sore throat',
            'Congestion or runny nose',
            'Nausea or vomiting',
            'Diarrhea',
        ];

        // Plant medicines list
        $plant_meds = [
            'Aloe Vera',
            'Basil',
            'Chamomile',
            'Echinacea',
            'Feverfew',
        ];

        // http image
        $image_url = 'https://everbloom.rn-admin.site/storage/b1XU1Z2Acr87FV6Qhh5sirw9E4v3Qqji5SxYXl6X.jpg';

        $images = [
            'https://everbloom.rn-admin.site/storage/VmrTiMPE50AVJBgZ5Vfxg2Zz9DoMZ3fOuVPBNfyh.jpg',
            'https://everbloom.rn-admin.site/storage/yvxkg5WrOv1FIRczJdWfKoOwxwfH3nB9qkwzyRaN.jpg',
            'https://everbloom.rn-admin.site/storage/pW1qWPMBl4zPUASMeKCw5iocCuw8XXO22ui2GIqz.jpg'
        ];

        $sources = [
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
        ];

        foreach ($plant_meds as $plant_med) {
            // Shuffle the symptoms array and pick a random number of symptoms
            shuffle($symptoms);
            $random_symptoms = array_slice($symptoms, 0, rand(1, count($symptoms)));

            PlantMed::create([
                'name' => $plant_med,
                'image' => $image_url,
                'images' => json_encode($images),
                'symptoms' => json_encode($random_symptoms),
                'description' => 'This is a description of ' . $plant_med,
                'habitat' => 'This is a habitat of ' . $plant_med,
                'propriete' => 'This is a propriete of ' . $plant_med,
                'usageInterne' => 'This is a usageInterne of ' . $plant_med,
                'usageExterne' => 'This is a usageExterne of ' . $plant_med,
                'precaution' => 'This is a precaution of ' . $plant_med,
                'sources' => $sources,
                'is_featured' => rand(false, true) ? true : false,
                'is_best_seller' => rand(false, true) ? true : false,
                'is_active' => true,
                'is_available' => true,
            ]);
        }
    }
}
