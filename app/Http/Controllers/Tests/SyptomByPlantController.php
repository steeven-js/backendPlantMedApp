<?php

namespace App\Http\Controllers\Tests;

use App\Models\PlantMed;
use Illuminate\Http\Request;

class SyptomByPlantController extends Controller
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
            ],
            [
                "plant_name" => "Amandier",
                "symptoms" => [
                    "Acné",
                    "Cholestérol",
                    "Constipation",
                    "Dermatite",
                    "Peau sèche"
                ]
            ],
            [
                "plant_name" => "Amarante",
                "symptoms" => [
                    "Acné",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Aneth",
                "symptoms" => [
                    "Douleur menstruelle",
                    "Flatulence",
                    "Mauvaise haleine",
                    "Varices",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Angélique",
                "symptoms" => [
                    "Anémie",
                    "Anorexie",
                    "Dépression",
                    "Maux d'estomac",
                    "amnésie",
                    "Toux",
                    "Vertiges",
                    "Viellissement",
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Arbre à thé",
                "symptoms" => [
                    "Acné",
                    "Mauvaise haleine",
                    "Pharyngite",
                    "Psoriasis",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Argousier",
                "symptoms" => [
                    "Constipation",
                    "Tendinite",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Armoise commune",
                "symptoms" => [
                    "Anorexie",
                    "Bronchite",
                    "Circulation sanguine",
                    "Douleur menstruelle",
                    "Fatigue",
                    "Maladie rhumatismale",
                    "Manque d'appétit"
                ]
            ],
            [
                "plant_name" => "Arnica",
                "symptoms" => [
                    "Anti-inflammatoire"
                ]
            ],
            [
                "plant_name" => "Artichaut",
                "symptoms" => [
                    "Cholestérol",
                    "Maladies cardiovasculaires",
                    "Maladie du foie",
                    "Nausées",
                    "Parasites intestinaux",
                    "perdre du poids",
                    "Psoriasis"
                ]
            ],
            [
                "plant_name" => "Ashwagandha",
                "symptoms" => [
                    "Anémie",
                    "Anxiété",
                    "Arthrite",
                    "Dépression",
                    "Douleur menstruelle",
                    "Fatigue",
                    "Fertilité",
                    "Insomnie",
                    "Maladie rhumatismale",
                    "amnésie",
                    "Stress",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Aubépine monogyne",
                "symptoms" => [
                    "Anxiété",
                    "Boulimie",
                    "Circulation sanguine",
                    "Hypertension",
                    "Hypotension",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires"
                ]
            ],
            [
                "plant_name" => "Açaï",
                "symptoms" => [
                    "Anémie",
                    "Anxiété",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Constipation",
                    "Diabète",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fatigue",
                    "Fertilité",
                    "Fièvre",
                    "Hypertension",
                    "Maladies cardiovasculaires",
                    "Manque d'appétit",
                    "perdre du poids",
                    "amnésie",
                    "Stress",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Badianer de Chine",
                "symptoms" => [
                    "Anorexie",
                    "Brûlures d'estomac",
                    "Côlon irritable",
                    "Diarrhée",
                    "Flatulence",
                    "Indigestion",
                    "Manque d'appétit",
                    "Nausées",
                    "Parasites intestinaux",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Bardane",
                "symptoms" => [
                    "Acné",
                    "Dermatite",
                    "Diabète",
                    "Cystite (infection urinaire)",
                    "Psoriasis",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Basilic",
                "symptoms" => [
                    "Acné",
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Démangeaisons",
                    "Dépression",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Hypertension",
                    "Infection de la gorge",
                    "Maux d'estomac",
                    "Nausées",
                    "Plaies dans la bouche",
                    "Sinusite",
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Bistorte",
                "symptoms" => [
                    "Anémie",
                    "Diarrhée",
                    "Fatigue",
                    "Hémorroïdes",
                    "Infection de la gorge",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "amnésie",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Bleuet",
                "symptoms" => [
                    "Acné",
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Démangeaisons",
                    "Dermatite",
                    "Fièvre",
                    "Jambes fatiguées",
                    "Peau sèche",
                    "Stress"
                ]
            ],
            [
                "plant_name" => "Boldo",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Calculs biliaires",
                    "Cholestérol",
                    "Flatulence",
                    "Grippe",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Insomnie",
                    "Maladie du foie",
                    "Maux d'estomac",
                    "Nausées",
                    "perdre du poids"
                ]
            ],
            [
                "plant_name" => "Bougainvillea",
                "symptoms" => [
                    "Acné",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Bronchite",
                    "Démangeaisons",
                    "Dermatite",
                    "Diabète",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Grippe",
                    "Indigestion",
                    "Ménoapuse",
                    "Peau sèche",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Bouleau",
                "symptoms" => [
                    "Cellulite",
                    "Hémorroïdes",
                    "perdre du poids",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Bourrache",
                "symptoms" => [
                    "Prostate",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Brocoli",
                "symptoms" => [
                    "Prostate",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Buchu",
                "symptoms" => []
            ],
            [
                "plant_name" => "Cacao",
                "symptoms" => [
                    "Fatigue"
                ]
            ],
            [
                "plant_name" => "Callune",
                "symptoms" => [
                    "Antiseptique",
                    "Arthrite",
                    "Dermatite",
                    "Grippe",
                    "Cystite (infection urinaire)",
                    "Urétite",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Camomille",
                "symptoms" => [
                    "Allergie",
                    "Anorexie",
                    "Anxiété",
                    "Arthrite",
                    "Asthme",
                    "Brûlures d'estomac",
                    "Côlon irritable",
                    "Constipation",
                    "Démangeaisons",
                    "Dermatite",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Hyperhidrose",
                    "Indigestion",
                    "Infection de la gorge",
                    "Insomnie",
                    "Irritabilité",
                    "Mal de dents",
                    "Maladies cardiovasculaires",
                    "Maladie du foie",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Ménoapuse",
                    "Nausées",
                    "Pancréatite",
                    "Peau sèche",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "Psoriasis",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Cannabis",
                "symptoms" => []
            ],
            [
                "plant_name" => "Cannelier",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Diabète",
                    "Douleur menstruelle",
                    "Flatulence",
                    "Hypertension",
                    "Indigestion",
                    "Maladies cardiovasculaires",
                    "Manque d'appétit"
                ]
            ],
            [
                "plant_name" => "Cardamome",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Manque d'appétit",
                    "Mauvaise haleine",
                    "Ménoapuse",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Caroubier",
                "symptoms" => [
                    "Constipation",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Centaurée rude",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Diabète",
                    "Manque d'appétit",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Centella asiatica",
                "symptoms" => [
                    "Cellulite",
                    "Jambes fatiguées"
                ]
            ],
            [
                "plant_name" => "Chardon Marie",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Cholestérol",
                    "Indigestion",
                    "Maladie du foie",
                    "Pancréatite"
                ]
            ],
            [
                "plant_name" => "Chicorée",
                "symptoms" => [
                    "Anorexie",
                    "Cholestérol",
                    "Constipation",
                    "Hypertension",
                    "Maladie du foie",
                    "Manque d'appétit",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Chélidoine",
                "symptoms" => [
                    "Toux",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Citronelle",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Anxiété",
                    "Arthrite",
                    "Asthme",
                    "Brûlures d'estomac",
                    "Cholestérol",
                    "Constipation",
                    "Diarrhée",
                    "Fièvre",
                    "Grippe",
                    "Indigestion",
                    "Insomnie",
                    "Maladies cardiovasculaires",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Nausées",
                    "Spasmes intestinaux",
                    "Toux",
                    "Viellissement",
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Citronnier",
                "symptoms" => [
                    "Démangeaisons",
                    "Hyperhidrose",
                    "Infection de la gorge",
                    "Nausées",
                    "Parasites intestinaux"
                ]
            ],
            [
                "plant_name" => "Coffea",
                "symptoms" => []
            ],
            [
                "plant_name" => "Consoude",
                "symptoms" => [
                    "Acné",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Arthrite",
                    "Asthme",
                    "Bronchite",
                    "Cellulite",
                    "Circulation sanguine",
                    "Dermatite",
                    "Diarrhée",
                    "Maladie rhumatismale",
                    "Peau sèche",
                    "Pharyngite",
                    "Psoriasis",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Coquelicot",
                "symptoms" => [
                    "Asthme",
                    "Dépression",
                    "Grippe",
                    "Insomnie",
                    "Irritabilité"
                ]
            ],
            [
                "plant_name" => "Coriandre",
                "symptoms" => [
                    "Anémie",
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Cholestérol",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Flatulence",
                    "Indigestion",
                    "Manque d'appétit",
                    "Mauvaise haleine",
                    "amnésie"
                ]
            ],
            [
                "plant_name" => "Cresson",
                "symptoms" => [
                    "Acné",
                    "Anémie",
                    "Arthrite",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Dermatite",
                    "Fatigue",
                    "Hypertension",
                    "Cystite (infection urinaire)",
                    "Maladies cardiovasculaires",
                    "Maladie rhumatismale",
                    "amnésie",
                    "Urétite",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Cumin",
                "symptoms" => [
                    "Anorexie",
                    "Douleur menstruelle",
                    "Flatulence",
                    "Indigestion",
                    "Manque d'appétit",
                    "Nausées",
                    "Parasites intestinaux"
                ]
            ],
            [
                "plant_name" => "Cumin des près",
                "symptoms" => [
                    "Flatulence",
                    "Nausées",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Curcuma",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Asthme",
                    "Cholestérol",
                    "Dermatite",
                    "Hémorroïdes",
                    "Infection de la gorge",
                    "Cystite (infection urinaire)",
                    "Mal de dents",
                    "Maladie du foie",
                    "Maladie rhumatismale",
                    "Manque d'appétit",
                    "Pancréatite",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Céleri",
                "symptoms" => [
                    "Arthrite",
                    "Constipation",
                    "Hémorroïdes",
                    "Maladie rhumatismale",
                    "perdre du poids",
                    "Psoriasis",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Damiana",
                "symptoms" => [
                    "Asthme",
                    "Bronchite",
                    "Constipation",
                    "Dépression",
                    "Fatigue",
                    "Fertilité",
                    "Cystite (infection urinaire)",
                    "Ménoapuse"
                ]
            ],
            [
                "plant_name" => "Droséra",
                "symptoms" => [
                    "Asthme",
                    "Hémorroïdes",
                    "Pharyngite",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Estragon",
                "symptoms" => [
                    "Insomnie",
                    "Maladie du foie",
                    "Mauvaise haleine"
                ]
            ],
            [
                "plant_name" => "Eucalyptus",
                "symptoms" => [
                    "Antiseptique",
                    "Arthrite",
                    "Asthme",
                    "Bronchite",
                    "Diabète",
                    "Grippe",
                    "Hémorroïdes",
                    "Infection de la gorge",
                    "Mauvaise haleine",
                    "Maux de tête",
                    "Parasites intestinaux",
                    "Pharyngite",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Tachycardie",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Fenouil",
                "symptoms" => [
                    "Anorexie",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Calculs biliaires",
                    "Côlon irritable",
                    "Flatulence",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Manque d'appétit",
                    "Maux d'estomac",
                    "Nausées",
                    "perdre du poids",
                    "Pharyngite"
                ]
            ],
            [
                "plant_name" => "Fleur d'oranger ",
                "symptoms" => [
                    "Anxiété",
                    "Bronchite",
                    "Fatigue",
                    "Nausées"
                ]
            ],
            [
                "plant_name" => "Fumeterre",
                "symptoms" => [
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Gattillier",
                "symptoms" => [
                    "Anxiété",
                    "Constipation",
                    "Dépression",
                    "Douleur menstruelle",
                    "Fertilité",
                    "Irritabilité",
                    "Maux de tête",
                    "Ménoapuse"
                ]
            ],
            [
                "plant_name" => "Gentiana",
                "symptoms" => [
                    "Anorexie",
                    "Calculs biliaires",
                    "Hypotension",
                    "Pancréatite",
                    "Parasites intestinaux",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Gimgembre",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Mal de dents",
                    "Tendinite",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Ginkgo",
                "symptoms" => [
                    "Allergie",
                    "Anxiété",
                    "Cellulite",
                    "Circulation sanguine",
                    "Dépression",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Maux de tête"
                ]
            ],
            [
                "plant_name" => "Ginseng",
                "symptoms" => [
                    "Boulimie",
                    "Cholestérol",
                    "Dépression",
                    "Diabète",
                    "Fatigue",
                    "Hypotension",
                    "Ménoapuse",
                    "Urétite",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Giroflier",
                "symptoms" => [
                    "Anorexie",
                    "Antiseptique",
                    "Boulimie",
                    "Bronchite",
                    "Démangeaisons",
                    "Flatulence",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Mal de dents",
                    "Mauvaise haleine",
                    "Maux de tête",
                    "Plaies dans la bouche"
                ]
            ],
            [
                "plant_name" => "Grand Plantain",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Cholestérol",
                    "Côlon irritable",
                    "Constipation",
                    "Diarrhée",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Hypertension",
                    "Indigestion",
                    "Infection de la gorge",
                    "Jambes fatiguées",
                    "Maux d'estomac",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Grande Aunée",
                "symptoms" => [
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Groseillier à maquereau",
                "symptoms" => [
                    "Asthme",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Guimauve",
                "symptoms" => [
                    "Côlon irritable",
                    "Constipation",
                    "Démangeaisons",
                    "Cystite (infection urinaire)",
                    "Maux d'estomac",
                    "Peau sèche",
                    "Stress",
                    "Tachycardie",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Hamamélis",
                "symptoms" => [
                    "Démangeaisons",
                    "Dermatite",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Ménoapuse",
                    "Peau sèche",
                    "Plaies dans la bouche",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Helichrysum",
                "symptoms" => [
                    "Acné",
                    "Allergie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Arthrite",
                    "Asthme",
                    "Bronchite",
                    "Cellulite",
                    "Circulation sanguine",
                    "Démangeaisons",
                    "Dermatite",
                    "Grippe",
                    "Infection de la gorge",
                    "Cystite (infection urinaire)",
                    "Jambes fatiguées",
                    "Maladie rhumatismale",
                    "Peau sèche",
                    "Plaies dans la bouche"
                ]
            ],
            [
                "plant_name" => "Hibiscus",
                "symptoms" => [
                    "Anorexie",
                    "Antiseptique",
                    "Cholestérol",
                    "Fièvre",
                    "Hypertension",
                    "Maladie du foie",
                    "perdre du poids",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Houblon",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Indigestion",
                    "Insomnie",
                    "Ménoapuse"
                ]
            ],
            [
                "plant_name" => "Ibéris amer",
                "symptoms" => [
                    "Flatulence",
                    "Indigestion",
                    "Nausées",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Jasmin",
                "symptoms" => [
                    "Maux de tête"
                ]
            ],
            [
                "plant_name" => "Laurier",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Dermatite",
                    "Hémorroïdes",
                    "Maladie rhumatismale",
                    "Maux de tête",
                    "Plaies dans la bouche",
                    "Tachycardie",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Lavande",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Démangeaisons",
                    "Dermatite",
                    "Flatulence",
                    "Hémorroïdes",
                    "Hypertension",
                    "Indigestion",
                    "Insomnie",
                    "Irritabilité",
                    "Mal de dents",
                    "Maladie rhumatismale",
                    "Maux de tête",
                    "Nausées",
                    "Tachycardie",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Lichen d'Islande",
                "symptoms" => [
                    "Anémie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Bronchite",
                    "Constipation",
                    "Diarrhée",
                    "Fatigue",
                    "Grippe",
                    "Infection de la gorge",
                    "Cystite (infection urinaire)",
                    "Nausées",
                    "Parasites intestinaux",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "amnésie"
                ]
            ],
            [
                "plant_name" => "Lin",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Cholestérol",
                    "Côlon irritable",
                    "Constipation",
                    "Démangeaisons",
                    "Spasmes intestinaux",
                    "Tachycardie",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Luzerne",
                "symptoms" => [
                    "Anémie",
                    "Démangeaisons",
                    "Maladies cardiovasculaires",
                    "Ménoapuse",
                    "amnésie",
                    "Prostate"
                ]
            ],
            [
                "plant_name" => "Malva",
                "symptoms" => [
                    "Allergie",
                    "Antiseptique",
                    "Bronchite",
                    "Constipation",
                    "Démangeaisons",
                    "Dermatite",
                    "Grippe",
                    "Irritabilité",
                    "Mal de dents",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "Sinusite",
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Manioc",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Brûlures d'estomac",
                    "Circulation sanguine",
                    "Fatigue",
                    "Hypertension",
                    "Cystite (infection urinaire)",
                    "Maladies cardiovasculaires",
                    "Manque d'appétit"
                ]
            ],
            [
                "plant_name" => "Marcela",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Brûlures d'estomac",
                    "Cholestérol",
                    "Diarrhée",
                    "Flatulence",
                    "Grippe",
                    "Hypertension",
                    "Insomnie",
                    "Maladies cardiovasculaires",
                    "Maux d'estomac",
                    "Nausées",
                    "Spasmes intestinaux",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Marjolaine",
                "symptoms" => [
                    "Boulimie",
                    "Cystite (infection urinaire)",
                    "Insomnie",
                    "Maladie du foie",
                    "Maux d'estomac",
                    "Stress",
                    "Tachycardie",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Marronnier",
                "symptoms" => [
                    "Cellulite",
                    "Circulation sanguine",
                    "Douleur menstruelle",
                    "Jambes fatiguées",
                    "Prostate",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Marrube blanc",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Bronchite",
                    "Constipation",
                    "Diarrhée",
                    "Flatulence",
                    "Grippe",
                    "Hypertension",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Manque d'appétit"
                ]
            ],
            [
                "plant_name" => "Maté",
                "symptoms" => [
                    "Arthrite",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Constipation",
                    "Dépression",
                    "Diabète",
                    "Fatigue",
                    "Hémorroïdes",
                    "Hypotension",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Maux de tête",
                    "perdre du poids"
                ]
            ],
            [
                "plant_name" => "Menthe",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Asthme",
                    "Calculs biliaires",
                    "Côlon irritable",
                    "Constipation",
                    "Démangeaisons",
                    "Diarrhée",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Hypotension",
                    "Indigestion",
                    "Infection de la gorge",
                    "Insomnie",
                    "Irritabilité",
                    "Manque d'appétit",
                    "Mauvaise haleine",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Nausées",
                    "Plaies dans la bouche",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Menthe poivrée",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Calculs biliaires",
                    "Côlon irritable",
                    "Constipation",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Hypotension",
                    "Indigestion",
                    "Manque d'appétit",
                    "Mauvaise haleine",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Spasmes intestinaux",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Millepertuis perforé",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Anxiété",
                    "Asthme",
                    "Démangeaisons",
                    "Dépression",
                    "Dermatite",
                    "Diarrhée",
                    "Fatigue",
                    "Psoriasis",
                    "Spasmes intestinaux",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Molène thapsus",
                "symptoms" => [
                    "Asthme",
                    "Bronchite",
                    "Grippe",
                    "Hémorroïdes",
                    "Tachycardie",
                    "Ulcère de l'estomac",
                    "Varices",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Maringa",
                "symptoms" => [
                    "Stress",
                    "Vertiges",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Myrtille",
                "symptoms" => [
                    "Diabète",
                    "Diarrhée",
                    "Cystite (infection urinaire)",
                    "Tendinite",
                    "Vertiges",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Mélisse",
                "symptoms" => [
                    "Anorexie",
                    "Anxiété",
                    "Boulimie",
                    "Circulation sanguine",
                    "Côlon irritable",
                    "Dépression",
                    "Douleur menstruelle",
                    "Indigestion",
                    "Insomnie",
                    "Irritabilité",
                    "Mal de dents",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Ménoapuse",
                    "Nausées",
                    "Spasmes intestinaux",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Noyer",
                "symptoms" => [
                    "Hyperhidrose",
                    "Prostate"
                ]
            ],
            [
                "plant_name" => "Olivier",
                "symptoms" => [
                    "Arthrite",
                    "Brûlures d'estomac",
                    "Calculs biliaires",
                    "Constipation",
                    "Diabète",
                    "Grippe",
                    "Hypertension",
                    "Peau sèche",
                    "Tendinite",
                    "Ulcère de l'estomac",
                    "Varices",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Onagre",
                "symptoms" => [
                    "Acné",
                    "Anti-inflammatoire",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Dermatite",
                    "Hypertension",
                    "Maux de tête",
                    "Ménoapuse",
                    "Peau sèche",
                    "Psoriasis"
                ]
            ],
            [
                "plant_name" => "Origan",
                "symptoms" => [
                    "Asthme",
                    "Bronchite",
                    "Constipation",
                    "Fièvre",
                    "Flatulence",
                    "Hypertension",
                    "Maux d'estomac",
                    "Pharyngite"
                ]
            ],
            [
                "plant_name" => "Orthosiphon",
                "symptoms" => [
                    "Cholestérol",
                    "perdre du poids",
                    "Prostate"
                ]
            ],
            [
                "plant_name" => "Ortie",
                "symptoms" => [
                    "Allergie",
                    "Anémie",
                    "Arthrite",
                    "Bronchite",
                    "Calculs biliaires",
                    "Cellulite",
                    "Circulation sanguine",
                    "Constipation",
                    "Dermatite",
                    "Fertilité",
                    "Maladie du foie",
                    "Ménoapuse",
                    "amnésie",
                    "Prostate",
                    "Sinusite",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Oseille",
                "symptoms" => [
                    "Manque d'appétit",
                    "Plaies dans la bouche",
                    "Toux",
                    "Urétite",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Passiflora",
                "symptoms" => [
                    "Anxiété",
                    "Asthme",
                    "Hypertension",
                    "Insomnie",
                    "Irritabilité",
                    "Ménoapuse",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Pensée",
                "symptoms" => [
                    "Acné",
                    "Dermatite",
                    "Fièvre",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Persil",
                "symptoms" => [
                    "Calculs biliaires",
                    "Douleur menstruelle",
                    "Cystite (infection urinaire)",
                    "Jambes fatiguées",
                    "Mal de dents",
                    "Maladie du foie",
                    "Mauvaise haleine",
                    "Ménoapuse",
                    "Psoriasis",
                    "Tendinite",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Pin",
                "symptoms" => [
                    "Bronchite",
                    "Pharyngite"
                ]
            ],
            [
                "plant_name" => "Pissenlit",
                "symptoms" => [
                    "Anémie",
                    "Anorexie",
                    "Calculs biliaires",
                    "Cellulite",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Constipation",
                    "Dermatite",
                    "Fertilité",
                    "Flatulence",
                    "Hypertension",
                    "Jambes fatiguées",
                    "Maladie du foie",
                    "Maux d'estomac",
                    "Pancréatite",
                    "perdre du poids",
                    "amnésie",
                    "Prostate",
                    "Psoriasis"
                ]
            ],
            [
                "plant_name" => "Poivron",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Constipation",
                    "Dermatite",
                    "Hypertension",
                    "Maladies cardiovasculaires",
                    "Ménoapuse",
                    "Tendinite",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Pourpier",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Constipation",
                    "Dermatite",
                    "Diabète",
                    "Diarrhée",
                    "Hypertension",
                    "Indigestion",
                    "Mal de dents",
                    "Maladies cardiovasculaires",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Peau sèche",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Prunellier",
                "symptoms" => [
                    "Spasmes intestinaux"
                ]
            ],
            [
                "plant_name" => "Prêle des champs",
                "symptoms" => [
                    "Anémie",
                    "Calculs biliaires",
                    "Cellulite",
                    "Circulation sanguine",
                    "Dermatite",
                    "Diarrhée",
                    "Fatigue",
                    "Hyperhidrose",
                    "Hypertension",
                    "Cystite (infection urinaire)",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Maladie rhumatismale",
                    "Peau sèche",
                    "perdre du poids",
                    "Pharyngite",
                    "amnésie",
                    "Prostate",
                    "Psoriasis",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Pâquerette",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Arthrite",
                    "Asthme",
                    "Bronchite",
                    "Dermatite",
                    "Diarrhée",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Hémorroïdes",
                    "Hypertension",
                    "Indigestion",
                    "Maladie rhumatismale",
                    "Manque d'appétit",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Pérille",
                "symptoms" => [
                    "Allergie"
                ]
            ],
            [
                "plant_name" => "Romarin",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Brûlures d'estomac",
                    "Circulation sanguine",
                    "Démangeaisons",
                    "Dermatite",
                    "Fatigue",
                    "Flatulence",
                    "Hypotension",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Maladie du foie",
                    "Maladie rhumatismale",
                    "Mauvaise haleine",
                    "Maux de tête",
                    "Ménoapuse",
                    "Pancréatite",
                    "Parasites intestinaux",
                    "Spasmes intestinaux",
                    "Toux",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Rooibos",
                "symptoms" => []
            ],
            [
                "plant_name" => "Rosier des chiens",
                "symptoms" => [
                    "Constipation",
                    "Diarrhée",
                    "Grippe",
                    "Cystite (infection urinaire)"
                ]
            ],
            [
                "plant_name" => "Rosier rouillé",
                "symptoms" => [
                    "Démangeaisons",
                    "Dermatite",
                    "Hémorroïdes"
                ]
            ],
            [
                "plant_name" => "Ruda",
                "symptoms" => [
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Maladies cardiovasculaires",
                    "Maux de tête",
                    "Spasmes intestinaux",
                    "Stress",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Réglisse",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Asthme",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Constipation",
                    "Dermatite",
                    "Fertilité",
                    "Grippe",
                    "Hypotension",
                    "Infection de la gorge",
                    "Maux d'estomac",
                    "Ménoapuse",
                    "Pancréatite",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "Psoriasis"
                ]
            ],
            [
                "plant_name" => "Safran",
                "symptoms" => [
                    "Anorexie",
                    "Dépression",
                    "Insomnie",
                    "Mal de dents",
                    "Manque d'appétit",
                    "Stress",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Salsepareille",
                "symptoms" => [
                    "Dermatite",
                    "Cystite (infection urinaire)",
                    "Psoriasis",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Sarriette vivace",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Fertilité",
                    "Pharyngite"
                ]
            ],
            [
                "plant_name" => "Sauge",
                "symptoms" => [
                    "Anémie",
                    "Anorexie",
                    "Antiseptique",
                    "Brûlures d'estomac",
                    "Côlon irritable",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Hyperhidrose",
                    "Infection de la gorge",
                    "Mauvaise haleine",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Ménoapuse",
                    "Pancréatite",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "amnésie",
                    "Spasmes intestinaux",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Saule blanc",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Circulation sanguine",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Mal de dents",
                    "Maux de tête",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Serpolet",
                "symptoms" => [
                    "Anorexie",
                    "Antiseptique",
                    "Maux d'estomac",
                    "Parasites intestinaux",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Shatavari",
                "symptoms" => [
                    "Douleur menstruelle",
                    "Fertilité",
                    "Ménoapuse"
                ]
            ],
            [
                "plant_name" => "Soies de maïs",
                "symptoms" => [
                    "Hyperhidrose",
                    "Cystite (infection urinaire)",
                    "Tendinite",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Souci",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Dermatite",
                    "Fièvre",
                    "Plaies dans la bouche",
                    "Psoriasis",
                    "Urétite"
                ]
            ],
            [
                "plant_name" => "Stevia",
                "symptoms" => [
                    "Diabète",
                    "Vertiges",
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Sureau",
                "symptoms" => [
                    "Acné",
                    "Fièvre",
                    "Grippe",
                    "Infection de la gorge",
                    "Urétite",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Séné",
                "symptoms" => [
                    "Constipation",
                    "Stress",
                    "Vertiges"
                ]
            ],
            [
                "plant_name" => "Thym",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Bronchite",
                    "Côlon irritable",
                    "Démangeaisons",
                    "Dépression",
                    "Dermatite",
                    "Diarrhée",
                    "Fièvre",
                    "Grippe",
                    "Infection de la gorge",
                    "Cystite (infection urinaire)",
                    "Insomnie",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Parasites intestinaux",
                    "Pharyngite",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Thé",
                "symptoms" => [
                    "Allergie",
                    "Arthrite",
                    "Cellulite",
                    "Cholestérol",
                    "Diabète",
                    "Diarrhée",
                    "Fertilité",
                    "Hyperhidrose",
                    "Hypertension",
                    "Infection de la gorge",
                    "Cystite (infection urinaire)",
                    "Mal de dents",
                    "Maladies cardiovasculaires",
                    "Maladie du foie",
                    "Mauvaise haleine",
                    "Ménoapuse",
                    "Pancréatite",
                    "perdre du poids",
                    "Psoriasis",
                    "Spasmes intestinaux"
                ]
            ],
            [
                "plant_name" => "Tilia",
                "symptoms" => [
                    "Anorexie",
                    "Anxiété",
                    "Boulimie",
                    "Brûlures d'estomac",
                    "Démangeaisons",
                    "Fièvre",
                    "Grippe",
                    "Hypertension",
                    "Hypotension",
                    "Insomnie",
                    "Irritabilité",
                    "Maladie du foie",
                    "Peau sèche"
                ]
            ],
            [
                "plant_name" => "Trèfle des prés",
                "symptoms" => [
                    "Dermatite",
                    "Diarrhée",
                    "Hémorroïdes",
                    "Ménoapuse",
                    "Plaies dans la bouche",
                    "Prostate",
                    "Spasmes intestinaux",
                    "Tachycardie",
                    "Viellissement"
                ]
            ],
            [
                "plant_name" => "Tussilage",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Asthme",
                    "Bronchite",
                    "Dermatite",
                    "Diarrhée",
                    "Fièvre",
                    "Grippe",
                    "Infection de la gorge",
                    "Ulcère de l'estomac",
                    "Varices"
                ]
            ],
            [
                "plant_name" => "Ulmarie",
                "symptoms" => [
                    "Cellulite",
                    "Dermatite",
                    "Indigestion",
                    "Cystite (infection urinaire)",
                    "Maux d'estomac"
                ]
            ],
            [
                "plant_name" => "Valérianne",
                "symptoms" => [
                    "Anorexie",
                    "Anti-inflammatoire",
                    "Anxiété",
                    "Boulimie",
                    "Côlon irritable",
                    "Dépression",
                    "Hypertension",
                    "Insomnie",
                    "Irritabilité",
                    "Maladies cardiovasculaires",
                    "Maux de tête",
                    "Ménoapuse",
                    "Spasmes intestinaux"
                ]
            ],
            [
                "plant_name" => "Vanilla",
                "symptoms" => [
                    "Hémorroïdes",
                    "Stress",
                    "Tendinite"
                ]
            ],
            [
                "plant_name" => "Verge d'or",
                "symptoms" => [
                    "Vomissements"
                ]
            ],
            [
                "plant_name" => "Verveine",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Constipation",
                    "Diarrhée",
                    "Flatulence",
                    "Hémorroïdes",
                    "Indigestion",
                    "Insomnie",
                    "Nausées",
                    "Pancréatite",
                    "Parasites intestinaux",
                    "Sinusite",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Verveine citronée",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Anxiété",
                    "Asthme",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Flatulence",
                    "Grippe",
                    "Indigestion",
                    "Insomnie",
                    "Mauvaise haleine",
                    "Maux d'estomac",
                    "Nausées",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Vigne",
                "symptoms" => [
                    "Jambes fatiguées",
                    "Ménoapuse",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Échinacée",
                "symptoms" => [
                    "Fatigue",
                    "Grippe",
                    "Cystite (infection urinaire)",
                    "Pharyngite",
                    "Plaies dans la bouche",
                    "Sinusite",
                    "Tachycardie"
                ]
            ],
            [
                "plant_name" => "Épazote",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Antiseptique",
                    "Arthrite",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Constipation",
                    "Dermatite",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Flatulence",
                    "Grippe",
                    "Indigestion",
                    "Infection de la gorge",
                    "Maladie rhumatismale",
                    "Maux d'estomac",
                    "Parasites intestinaux",
                    "Sinusite",
                    "Spasmes intestinaux",
                    "Tachycardie",
                    "Ulcère de l'estomac"
                ]
            ],
            [
                "plant_name" => "Épine-vinette",
                "symptoms" => [
                    "Calculs biliaires",
                    "Toux"
                ]
            ],
            [
                "plant_name" => "Fenugrec",
                "symptoms" => [
                    "Anorexie",
                    "Fièvre",
                    "Grippe",
                    "Pancréatite"
                ]
            ],
            [
                "plant_name" => "Framboisier",
                "symptoms" => [
                    "Anti-inflammatoire",
                    "Arthrite",
                    "Circulation sanguine",
                    "Constipation",
                    "Dermatite",
                    "Diabète",
                    "Hypertension",
                    "Infection de la gorge",
                    "Maladies cardiovasculaires",
                    "Maladie rhumatismale",
                    "Ménoapuse",
                    "perdre du poids",
                    "Pharyngite"
                ]
            ],
            [
                "plant_name" => "Gingembre",
                "symptoms" => [
                    "Anorexie",
                    "Arthrite",
                    "Asthme",
                    "Bronchite",
                    "Brûlures d'estomac",
                    "Circulation sanguine",
                    "Côlon irritable",
                    "Dépression",
                    "Diarrhée",
                    "Douleur menstruelle",
                    "Fièvre",
                    "Grippe",
                    "Hypotension",
                    "Indigestion",
                    "Infection de la gorge",
                    "Maladies cardiovasculaires",
                    "Maladie rhumatismale",
                    "Mauvaise haleine",
                    "Maux d'estomac",
                    "Maux de tête",
                    "Nausées",
                    "perdre du poids",
                    "Pharyngite",
                    "Prostate",
                    "Sinusite"
                ]
            ],
            [
                "plant_name" => "Moringa",
                "symptoms" => [
                    "Arthrite",
                    "Brûlures d'estomac",
                    "Cholestérol",
                    "Circulation sanguine",
                    "Démangeaisons",
                    "Diabète",
                    "Fatigue",
                    "Hypertension",
                    "Cystite (infection urinaire)",
                    "Jambes fatiguées",
                    "Maladies cardiovasculaires",
                    "Maladie du foie",
                    "Maladie rhumatismale",
                    "Maux de tête",
                    "Parasites intestinaux",
                    "amnésie"
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
