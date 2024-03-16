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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('recipe_id');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->string('name');
            // $table->string('quantity');

            $table->string('image_url')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreients');
    }
};
