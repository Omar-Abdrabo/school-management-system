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
        Schema::create('my_parents', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');

            //Fatherinformation
            $table->string('father_name');
            $table->string('father_national_id');
            $table->string('father_passport_id');
            $table->string('father_phone');
            $table->string('father_job');
            $table->foreignId('nationality_father_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->foreignId('blood_type_father_id')->references('id')->on('blood_types')->onDelete('cascade');
            $table->foreignId('religion_father_id')->references('id')->on('religions')->onDelete('cascade');
            // $table->bigInteger('nationality_father_id')->unsigned();
            // $table->bigInteger('blood_type_father_id')->unsigned();
            // $table->bigInteger('religion_father_id')->unsigned();
            $table->string('father_address');

            //Mother information
            $table->string('mother_name');
            $table->string('mother_national_id');
            $table->string('mother_passport_id');
            $table->string('mother_phone');
            $table->string('mother_job');
            $table->foreignId('nationality_mother_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->foreignId('blood_type_mother_id')->references('id')->on('blood_types')->onDelete('cascade');
            $table->foreignId('religion_mother_id')->references('id')->on('religions')->onDelete('cascade');
            // $table->bigInteger('nationality_mother_id')->unsigned();
            // $table->bigInteger('blood_type_mother_id')->unsigned();
            // $table->bigInteger('religion_mother_id')->unsigned();
            $table->string('mother_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_parents');
    }
};
