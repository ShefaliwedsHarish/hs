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
        Schema::create('kst_requirements', function (Blueprint $table) {
            $table->id();
            $table->integer('betch_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('number_of_person');
            $table->string('total_pay');
            $table->string('profit');
            $table->string('booking_date');
            $table->string('last_date'); 
            $table->string('phone_number'); 
            $table->string('company_name'); 
            $table->tinyInteger('paymentstatus')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kst_requirements');
    }
};
