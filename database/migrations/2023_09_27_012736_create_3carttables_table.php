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
        Schema::create('3carttables', function (Blueprint $table) {
            $table->id();
            $table->string('Product_id'); 
            $table->string('Product_Name'); 
            $table->string("Image"); 
            $table->string("Quantity"); 
            $table->string("price"); 
            $table->string("Total"); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('3carttables');
    }
};
