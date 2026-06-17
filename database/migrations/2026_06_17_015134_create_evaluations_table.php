<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('presentation_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['classroom_id', 'name']);
        });

        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentation_type_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['presentation_id', 'name']);
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('reviewer_name');
            $table->unsignedTinyInteger('content_score');
            $table->unsignedTinyInteger('english_score');
            $table->unsignedTinyInteger('delivery_score');
            $table->unsignedTinyInteger('communication_score');
            $table->text('good_point')->nullable();
            $table->text('advice')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'reviewer_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('students');
        Schema::dropIfExists('presentations');
        Schema::dropIfExists('presentation_types');
        Schema::dropIfExists('classrooms');
    }
};
