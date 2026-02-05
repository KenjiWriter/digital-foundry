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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client_industry');
            $table->string('cover_image_path')->nullable();
            $table->text('challenge_summary');
            $table->text('solution_summary');
            $table->json('roi_stats'); // e.g. {"Time Saved": "40%", "Revenue Increase": "$10k/mo"}
            $table->json('tech_stack'); // e.g. ["Laravel", "Vue", "Redis"]
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
