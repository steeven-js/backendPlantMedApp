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
            'Acné',
            'Allergie',
            'Anémie',
            'Anorexie',
            'Anti-inflammatoire',
            'Antiseptique',
            'Anxiété',
            'Aphrodisiaque',
            'Arthrite',
            'Asthme',
            'Boulimie',
            'Bronchite',
            'Brûlures d\'estomac',
            'Brûlures',
            'Calculs biliaires',
            'Cellulite',
            'Cheveux',
            'Engelures',
            'Cholestérol',
            'Circulation sanguine',
            'Colite',
            'Côlon irritable',
            'Constipation',
            'Cystite (infection urinaire)',
            'Démangeaisons',
            'Dépression',
            'Dermatite',
            'Diabète',
            'Diarrhée',
            'Douleur menstruelle',
            'Elimination des toxines',
            'Fatigue',
            'Fertilité',
            'Fièvre',
            'Flatulence',
            'Foie gras',
            'Foie propre',
            'Froid',
            'glaucome',
            'Goutte',
            'Grippe',
            'Guérison',
            'Hémorroïdes',
            'Hyperhidrose',
            'Hypertension',
            'Hypotension',
            'Indigestion',
            'Infection de la gorge',
            'Cystite (infection urinaire)',
            'Insomnie',
            'Irritabilité',
            'Jambes fatiguées',
            'Mal de dents',
            'Maladies cardiovasculaires',
            'Maladie du foie',
            'Maladie rhumatismale',
            'Manque d\'appétit',
            'Mauvaise haleine',
            'Maux d\'estomac',
            'Maux de tête',
            'Ménoapuse',
            'Migraine',
            'Nausées',
            'Nerfs',
            'Névralgie',
            'Pancréatite',
            'Parasites intestinaux',
            'Peau sèche',
            'perdre du poids',
            'Pharyngite',
            'Plaies dans la bouche',
            'amnésie',
            'Problèmes digestifs',
            'Prostate',
            'Psoriasis',
            'Purifier les reins',
            'Rétention d\'eau',
            'Salpingite',
            'Sinusite',
            'Spasmes intestinaux',
            'Piqûres d\'insectes',
            'Stress',
            'Tache de peau',
            'Tachycardie',
            'Tendinite',
            'Toux',
            'Ulcère de l\'estomac',
            'Urétite',
            'Varices',
            'Vertiges',
            'Viellissement',
            'Vomissements',
        ];

        // http image
        $image_url = 'https://everbloom.rn-admin.site/storage/b1XU1Z2Acr87FV6Qhh5sirw9E4v3Qqji5SxYXl6X.jpg';

        $sources = [
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
            'https://www.healthline.com/nutrition/10-proven-benefits-of-spirulina',
        ];

        foreach ($symptoms as $symptom) {
            \App\Models\Symptom::create([
                'name' => $symptom,
                'image' => $image_url,
                'description' => 'This is a description for ' . $symptom,
                'sources' => json_encode($sources),
            ]);
        }
    }
}
