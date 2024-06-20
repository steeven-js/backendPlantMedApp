<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->json('colors');
            $table->string('image');
            $table->json('pot_types');
            $table->json('categories');
            $table->json('plant_types');
            $table->decimal('price', 10, 2);
            $table->json('images')->nullable();
            $table->float('rating')->default(0);
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->string('promotion')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_top')->default(false);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->boolean('is_best_seller')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
