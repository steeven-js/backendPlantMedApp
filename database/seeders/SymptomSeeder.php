<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Symptoms list
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

        // http image
        $image_url = 'https://everbloom.rn-admin.site/storage/b1XU1Z2Acr87FV6Qhh5sirw9E4v3Qqji5SxYXl6X.jpg';

        foreach ($symptoms as $symptom) {
            \App\Models\Symptom::create([
                'name' => $symptom,
                'image' => $image_url,
            ]);
        }
    }
}
