<?php

namespace App\Http\Controllers;

use App\Models\PlantType;
use Illuminate\Http\Request;

class PlantTypeController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return PlantType::all();
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantType $plantType) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(PlantType $plantType) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantType $plantType) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantType $plantType) {
    //
  }
}
