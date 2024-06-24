<?php

namespace App\Http\Controllers\Tests;

use App\Models\PlantMed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImagePlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Définir le chemin du dossier contenant les images des plantes
        $directory = public_path('plantes');

        // Vérifier si le dossier existe
        if (!File::exists($directory)) {
            dd('Le dossier des plantes n\'existe pas.');
        }

        // Récupérer tous les fichiers du dossier
        $files = File::files($directory);

        // Boucler à travers chaque fichier trouvé
        foreach ($files as $file) {
            // Obtenir le nom du fichier sans extension
            $fileNameWithoutExtension = pathinfo($file->getFilename(), PATHINFO_FILENAME);

            // Débogage : Afficher le nom du fichier
            // dd('Nom du fichier : ' . $fileNameWithoutExtension);

            // Rechercher la plante dans la base de données en utilisant le nom du fichier
            $plant = PlantMed::where('name', $fileNameWithoutExtension)->first();

            // Vérifier si la plante existe
            if ($plant) {
                // Débogage : Afficher le nom de la plante trouvée
                // dd('Plante trouvée : ' . $plant->name);

                // Ajouter le fichier image à la collection 'image' de Spatie Media Library
                $plant->addMedia($file->getPathname())->toMediaCollection('image');

                // Ajouter le fichier image à la collection 'images' de Spatie Media Library
                $plant->addMedia($file->getPathname())->toMediaCollection('images');

                // Mettre à jour l'attribut image
                $plant->image = $plant->getImageAttribute();

                // Urls des images de la collection 'images'
                $urls = $plant->getMedia('images')->map(function ($item) {
                    return $item->getUrl();
                })->toArray();

                // Enregistrer dans images le tableau des URLs
                $plant->images = $urls;

                // Sauvegarder les données
                $plant->save();

                // Débogage : Confirmer l'ajout de l'image
                // dd('Image ajoutée à la plante : ' . $plant->name);
            } else {
                // Débogage : Aucune plante trouvée pour ce fichier
                dd('Aucune plante trouvée pour : ' . $fileNameWithoutExtension);
            }
        }

        // Débogage : Processus terminé
        dd('Processus terminé.');
    }
}
