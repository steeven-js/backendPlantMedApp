<?php

namespace App\Http\Controllers\Tests;

use App\Models\PlantMed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TestsController extends Controller
{
    public function index()
    {
        PlantMed::generateAllDefaultSourcesUrls();
        return response()->json(['message' => 'URLs générées avec succès pour toutes les plantes']);
    }
}
