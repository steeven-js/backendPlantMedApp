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
            $table->boolean('is_prenium')->after('phone_otp_expires_at')->default(false)->nullable(false);
            $table->string('transactionDate')->nullable()->after('is_prenium');
            $table->string('transactionId')->nullable()->after('transactionDate');
            $table->string('transactionReceipt')->nullable()->after('transactionId');
            $table->string('productId')->nullable()->after('transactionReceipt');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->boolean('is_prenium')->after('phone_otp_expires_at')->default(false)->nullable(false);
            $table->string('transactionDate')->nullable()->after('is_prenium');
            $table->string('transactionId')->nullable()->after('transactionDate');
            $table->string('transactionReceipt')->nullable()->after('transactionId');
            $table->string('productId')->nullable()->after('transactionReceipt');
        });

    }
};
