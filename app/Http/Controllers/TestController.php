<?php

namespace App\Http\Controllers;

use App\Models\PlantMed;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        // Récupérer la plante médicinale avec ses médias
        $plantmed = PlantMed::where('id', 2)->with('media')->first();

        if (!$plantmed) {
            return response()->json(['error' => 'PlantMed not found'], 404);
        }

        // Récupérer l'URL de l'image unique
        $singleImageUrl = $plantmed->getFirstMediaUrl('image');
        $plantmed->image = $singleImageUrl;

        // Inclure les URLs des images multiples
        $mediaItems = $plantmed->getMedia('images');
        $urls = $mediaItems->map(function ($item) {
            return $item->getUrl();
        })->toArray();

        // Enregistrer dans images le tableau des URLs
        $plantmed->images = $urls;

        // Sauvegarder les données
        $plantmed->save();

        // Afficher les données avec les URLs des images
        dd($plantmed);
    }
}
