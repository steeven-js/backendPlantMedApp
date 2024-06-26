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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('email');
            $table->string('total');
            $table->json('products');
            $table->string('address');
            $table->integer('user_id');
            $table->string('subtotal');
            $table->string('phone_number');
            $table->string('card_holder_name');
            $table->string('discount')->nullable();
            $table->string('delivery')->nullable();
            $table->string('order_status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
