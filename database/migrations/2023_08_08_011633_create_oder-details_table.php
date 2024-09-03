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
        Schema::create('oder-details', function (Blueprint $table) {
            $table->id();
            $table->string('Booking_side'); 
            $table->string('Start_data'); 
            $table->string('End_data'); 
            $table->string('Groom_name'); 
            $table->string('Place_Marrage'); 
            $table->string('Address_groom'); 
            $table->string('Father_name'); 
            $table->string('Mother_name'); 
            $table->string('Extra_word'); 
            $table->string('Bride_name'); 
            $table->string('Phone_number');
            $table->string('Bride_Father'); 
            $table->string('Bride_Mother'); 
            $table->string('Address'); 
            $table->string('Image'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oder-details');
    }
};
