<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {

  public function index($id) {
    $reviews = Review::where('plant_id', $id)->get();
    return response()->json([
      'reviews' => $reviews
    ], 200);
  }

  public function create(Request $request) {

    $plant = Plant::find($request->plant_id);

    $review = new Review();
    $review->plant = $plant->name;
    $review->name = $request->name;
    $review->rating = $request->rating;
    $review->comment = $request->comment;
    $review->plant_id = $request->plant_id;

    // Находим продукт по id
    $plant = Plant::find($request->plant_id);

    if (!$plant) {
      return response()->json([
        'message' => 'Plant not found'
      ], 404);
    }

    if ($request->rating < 1 || $request->rating > 5) {
      return response()->json([
        'message' => 'Rating must be between 1 and 5'
      ], 400);
    }

    $review->save();

    // Вычисляем новый рейтинг
    $newRating = ($plant->rating * $plant->rating_count + $request->rating) / ($plant->rating_count + 1);

    // Обновляем рейтинг и количество оценок
    $plant->rating = $newRating;
    $plant->rating_count += 1;

    // Сохраняем изменения
    $plant->save();

    return response()->json([
      'message' => 'Review created successfully',
      'rating_message' => 'Rating updated successfully',
      'review' => $review,
      'new_rating' => $newRating
    ], 200);
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
  public function show(Review $review) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Review $review) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Review $review) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Review $review) {
    //
  }
}
