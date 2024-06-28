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
        Schema::table('app_users', function (Blueprint $table) {
            // Colonnes pour l'abonnement
            $table->boolean('is_premium')->default(false);
            $table->timestamp('premium_expires_at')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_users', function (Blueprint $table) {
            // Colonnes pour l'abonnement
            $table->boolean('is_premium')->default(false);
            $table->timestamp('premium_expires_at')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
        });
    }
};
