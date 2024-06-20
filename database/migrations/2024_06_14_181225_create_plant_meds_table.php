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
        Schema::create('plant_meds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('image');
            $table->json('symptoms');
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->text('habitat')->nullable();
            $table->text('propriete')->nullable();
            $table->text('usageInterne')->nullable();
            $table->text('usageExterne')->nullable();
            $table->text('precaution')->nullable();
            $table->json('sources')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_available')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_meds');
    }
};
