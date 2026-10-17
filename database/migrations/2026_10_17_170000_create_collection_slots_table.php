<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collection_slots', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('period', 30)->default('morning'); // morning, afternoon, evening
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedInteger('max_bookings')->default(0); // 0 = unlimited
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['period', 'is_active', 'sort_order']);
        });

        // Pre-seed standard 15 collection slots
        $now = now();
        $defaultSlots = [
            // Morning
            ['title' => '05:00 AM - 06:00 AM', 'period' => 'morning', 'start_time' => '05:00:00', 'end_time' => '06:00:00', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '06:00 AM - 07:00 AM', 'period' => 'morning', 'start_time' => '06:00:00', 'end_time' => '07:00:00', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '07:00 AM - 08:00 AM', 'period' => 'morning', 'start_time' => '07:00:00', 'end_time' => '08:00:00', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '08:00 AM - 09:00 AM', 'period' => 'morning', 'start_time' => '08:00:00', 'end_time' => '09:00:00', 'sort_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '09:00 AM - 10:00 AM', 'period' => 'morning', 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'sort_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '10:00 AM - 11:00 AM', 'period' => 'morning', 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'sort_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '11:00 AM - 12:00 PM', 'period' => 'morning', 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'sort_order' => 7, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],

            // Afternoon
            ['title' => '12:00 PM - 01:00 PM', 'period' => 'afternoon', 'start_time' => '12:00:00', 'end_time' => '13:00:00', 'sort_order' => 8, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '01:00 PM - 02:00 PM', 'period' => 'afternoon', 'start_time' => '13:00:00', 'end_time' => '14:00:00', 'sort_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '02:00 PM - 03:00 PM', 'period' => 'afternoon', 'start_time' => '14:00:00', 'end_time' => '15:00:00', 'sort_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '03:00 PM - 04:00 PM', 'period' => 'afternoon', 'start_time' => '15:00:00', 'end_time' => '16:00:00', 'sort_order' => 11, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '04:00 PM - 05:00 PM', 'period' => 'afternoon', 'start_time' => '16:00:00', 'end_time' => '17:00:00', 'sort_order' => 12, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],

            // Evening
            ['title' => '05:00 PM - 06:00 PM', 'period' => 'evening', 'start_time' => '17:00:00', 'end_time' => '18:00:00', 'sort_order' => 13, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '06:00 PM - 07:00 PM', 'period' => 'evening', 'start_time' => '18:00:00', 'end_time' => '19:00:00', 'sort_order' => 14, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => '07:00 PM - 08:00 PM', 'period' => 'evening', 'start_time' => '19:00:00', 'end_time' => '20:00:00', 'sort_order' => 15, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('collection_slots')->insert($defaultSlots);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_slots');
    }
};
