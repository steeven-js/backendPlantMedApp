<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('app_users', function (Blueprint $table) {
      $table->id();
      $table->timestamps();

      // USER DATA //
      $table->string('name');
      $table->string('email');
      $table->string('password');
      $table->string('location')->nullable();
      $table->string('phone_number')->nullable();

      // EMAIL VERIFICATION //
      $table->string('email_otp')->nullable();
      $table->boolean('email_verified')->default(false);
      $table->timestamp('email_otp_expires_at')->nullable();

      // PHONE VERIFICATION //
      $table->string('phone_otp')->nullable();
      $table->boolean('phone_verified')->default(false);
      $table->timestamp('phone_otp_expires_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('app_users');
  }
};
