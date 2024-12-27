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
        Schema::create('library', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_name');
            $table->foreignId('grade_id')->constrained('grades')->references('id')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->references('id')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->references('id')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library');
    }
};
