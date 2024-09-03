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
        Schema::create('contactdetails', function (Blueprint $table) {
            $table->id();
            $table->string('Address');
            $table->string('Location');
            $table->string('Phone_number1');
            $table->string('Phone_number2');
            $table->string('Email_id');
            $table->string('Facebook');
            $table->string('Instagram');
            $table->string('Twitter');
            $table->string('Ifram'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactdetails');
    }
};
