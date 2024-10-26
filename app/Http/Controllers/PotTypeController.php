<?php

namespace App\Http\Controllers;

use App\Models\PotType;
use Illuminate\Http\Request;

class PotTypeController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return PotType::all();
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
  public function show(PotType $potType) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(PotType $potType) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PotType $potType) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PotType $potType) {
    //
  }
}
