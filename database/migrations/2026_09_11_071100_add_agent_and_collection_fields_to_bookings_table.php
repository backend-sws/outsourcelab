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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('agent_id')->nullable()->after('address_id');
            $table->string('sample_status')->default('Pending')->after('status'); 
            // Pending, Assigned, Out for Collection, Sample Collected, Delivered to Lab
            $table->timestamp('sample_collected_at')->nullable()->after('sample_status');
            $table->text('sample_notes')->nullable()->after('sample_collected_at');
            $table->timestamp('money_collected_at')->nullable()->after('payment_status');
            $table->unsignedBigInteger('money_collected_by')->nullable()->after('money_collected_at');
            $table->string('money_payment_mode')->nullable()->after('money_collected_by'); // Cash, UPI_QR
            
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn([
                'agent_id',
                'sample_status',
                'sample_collected_at',
                'sample_notes',
                'money_collected_at',
                'money_collected_by',
                'money_payment_mode'
            ]);
        });
    }
};
