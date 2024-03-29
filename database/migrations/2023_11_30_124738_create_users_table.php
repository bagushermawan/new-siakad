<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default(bcrypt('123'));
            $table->date('tanggal_lahir')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('status_siswa')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('nohp')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('set null');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('user_type')->default('user');
            $table->string('foto_user')->nullable();
        });

        // Mengubah nilai default id menjadi genap
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 10000000;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
