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
        Schema::create('online_classes', function (Blueprint $table) {
            $table->id();
            $table->boolean('integration');
            $table->foreignId('grade_id')->constrained('grades')->references('id')->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained('classrooms')->references('id')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->references('id')->cascadeOnDelete();
            // $table->foreignId('user_id')->constrained('users')->references('id')->cascadeOnDelete();
            $table->string('created_by');
            $table->string('meeting_id', 500);
            $table->string('topic');
            $table->string('start_at', 500);
            $table->string('duration', 500);
            $table->string('password', 500);
            $table->string('start_url', 500);
            $table->string('join_url', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_classes');
    }
};
