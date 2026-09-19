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
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->enum('duration_type', ['months', 'years'])->default('years');
            $table->integer('duration_value')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->integer('discount_percentage')->default(20);
            $table->boolean('free_home_collection')->default(true);
            $table->boolean('free_teleconsultation')->default(true);
            $table->boolean('priority_reports')->default(true);
            $table->integer('family_coverage_limit')->default(4);
            $table->json('benefits')->nullable();
            $table->string('theme_color')->default('gold'); // gold, platinum, emerald, purple
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
