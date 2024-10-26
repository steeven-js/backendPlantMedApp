<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller {

  public function index() {
    return Promocode::all();
  }

  public function show(Request $request) {
    $voucher = $request->input('voucher');
    $promocode = Promocode::where('code', $voucher)->first();

    if ($promocode === null) {
      return response()->json(['message' => 'Promocode not found'], 404);
    }

    return response()->json([
      'message' => 'Promocode found',
      'promocode' => $promocode
    ], 200);
  }
}
