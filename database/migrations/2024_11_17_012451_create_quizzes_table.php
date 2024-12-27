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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('subject_id')->constrained('subjects')->references('id')->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->references('id')->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained('classrooms')->references('id')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->references('id')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
