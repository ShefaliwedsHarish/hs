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
        Schema::create('itr_forms', function (Blueprint $table) {
            $table->id();
            $table->string('Name'); 
            $table->string('Email'); 
            $table->string('Phone_number');
            $table->string('Addharcard'); 
            $table->string('Address'); 
            $table->string('Pan_card'); 
            $table->string('Password'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itr_forms');
    }
};
