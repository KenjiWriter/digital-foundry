<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained()->cascadeOnDelete();
            $table->json('question_text'); // Translatable question
            $table->string('variable_name'); // For internal ref
            $table->decimal('cost_per_unit', 10, 2);
            $table->json('suggestion_text'); // Translatable suggestion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_questions');
    }
};
