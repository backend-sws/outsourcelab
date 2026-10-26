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
        Schema::table('agents', function (Blueprint $table) {
            $table->text('serviceable_pincodes')->nullable()->after('city');
            $table->unsignedInteger('max_orders_per_slot')->default(2)->after('serviceable_pincodes');
            $table->json('weekly_offs')->nullable()->after('max_orders_per_slot');
            $table->string('lis_collector_id')->nullable()->after('vehicle_number');
        });

        Schema::create('agent_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->date('leave_date');
            $table->string('slot_title')->nullable(); // null = whole day leave; otherwise specific slot
            $table->string('leave_type', 30)->default('full_day'); // full_day, slot_specific
            $table->string('reason')->nullable();
            $table->string('status', 30)->default('approved'); // approved, pending, cancelled
            $table->timestamps();

            $table->index(['agent_id', 'leave_date', 'status']);
            $table->index(['leave_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_leaves');

        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'serviceable_pincodes',
                'max_orders_per_slot',
                'weekly_offs',
                'lis_collector_id',
            ]);
        });
    }
};
