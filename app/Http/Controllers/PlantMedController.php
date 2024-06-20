<?php

namespace App\Http\Controllers;

use App\Models\PlantMed;
use Illuminate\Http\Request;

class PlantMedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plants = PlantMed::where('is_available', 1)->get();
        $plants->map(function ($plant) {
            $plant->images = json_decode($plant->images, true);
            return $plant;
        });
        return $plants;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantMed $plantMed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantMed $plantMed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlantMed $plantMed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantMed $plantMed)
    {
        //
    }
}
