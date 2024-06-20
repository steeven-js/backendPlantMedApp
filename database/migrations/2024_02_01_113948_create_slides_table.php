<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('slides', function (Blueprint $table) {
      $table->id();
      $table->timestamps();

      $table->string('image');
      $table->string('promotion');
      $table->string('title_line_1');
      $table->string('title_line_2');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('slides');
  }
};
