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
            $table->boolean('is_prenium')->after('phone_otp_expires_at')->default(false)->nullable();
            $table->json('subscription_info')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->boolean('is_prenium')->after('phone_otp_expires_at')->default(false)->nullable();
            $table->json('subscription_info')->nullable();
        });

    }
};
