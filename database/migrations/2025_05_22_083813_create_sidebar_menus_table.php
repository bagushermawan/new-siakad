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
        Schema::create('sidebar_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');            
            $table->string('route_name');       
            $table->string('icon')->nullable(); 
            $table->string('group')->nullable(); 
            $table->integer('order')->default(0); 
            $table->boolean('is_submenu')->default(false); 
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->string('roles')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_menus');
    }
};
