<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();

            // Foreign key to tracer table
            $table->unsignedBigInteger('alumni_id');
            $table->foreign('alumni_id')->references('id')->on('tracer')->onDelete('cascade');

            // Ratings (1 = Poor, 2 = Fair, 3 = Good, 4 = Excellent)
            $table->tinyInteger('teamwork')->nullable();
            $table->tinyInteger('it_skills')->nullable();
            $table->tinyInteger('foreign_language')->nullable();
            $table->tinyInteger('communication')->nullable();
            $table->tinyInteger('self_development')->nullable();
            $table->tinyInteger('leadership')->nullable();
            $table->tinyInteger('work_ethic')->nullable();

            // Free text responses
            $table->text('unmet_competencies')->nullable();
            $table->text('curriculum_suggestions')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
