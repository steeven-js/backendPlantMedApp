<?php

namespace App\Http\Controllers;

use App\Models\PlantMed;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $plants = [
            [
                "plant_name" => "Absinthe",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Brûlures d'estomac",
                    "Circulation sanguine",
                    "Côlon irritable",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Indigestion",
                    "Maladie du foie",
                    "Manque d'appétit",
                    "Ménoapuse",
                    "Parasites intestinaux",
                    "Spasmes intestinaux",
                    "Tachycardie",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Achillée",
                "symptoms" => [
                    "Acné",
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Bronchite",
                    "Calculs biliaires",
                    "Circulation sanguine",
                    "Côlon irritable",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Hypertension",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Manque d'appétit",
                    "Maux d'estomac",
                    "Ménoapuse",
                    "Nausées",
                    "Parasites intestinaux"
                ]
            ],
            [
                "plant_name" => "Actée à grappe",
                "symptoms" => [
                    "Ménoapuse"
                ]
            ],
            [
                "plant_name" => "Agave",
                "symptoms" => [
                    "Prostate",
                    "Tachycardie",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Agripaume",
                "symptoms" => [
                    "Hypotension",
                    "Maladies cardiovasculaires"
                ]
            ],
            [
                "plant_name" => "Aigremoine",
                "symptoms" => [
                    "Anorexie"
                ]
            ],
            [
                "plant_name" => "Ail",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Asthme",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Hypertension",
                    "Hypotension",
                    "Mal de dents",
                    "Maladies cardiovasculaires",
                    "Maladie rhumatismale",
                    "Parasites intestinaux",
                    "Pharyngite",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Aloe vera",
                "symptoms" => [
                    "Acné",
                    "Arthrite",
                    "Boulimie",
                    "Brûlures d'estomac",
                    "Constipation",
                    "Démangeaisons",
                    "Dermatite",
                    "Diarrhée",
                    "Hémorroïdes",
                    "Peau sèche",
                    "Plaies dans la bouche",
                    "Psoriasis",
                    "Viellissement"
                ]
            ]
        ];

        foreach ($plants as $plant) {
            PlantMed::updateOrCreate(
                ['name' => $plant['plant_name']],
                ['symptoms' => $plant['symptoms']]
            );
        }

        return response()->json(['message' => 'Plants updated successfully']);
    }
}
