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
        Schema::create('wali_santris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('santri_id')->nullable();
            $table->foreign('santri_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('nohp')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt('123'));
            $table->rememberToken();
            $table->timestamps();
            $table->string('user_type')->default('wali_santris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_santris');
    }
};
