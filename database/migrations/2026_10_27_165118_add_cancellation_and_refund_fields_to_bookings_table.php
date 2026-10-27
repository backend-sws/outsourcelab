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
            $table->string('cancellation_request_status', 30)->nullable()->index()->after('status');
            $table->text('cancellation_reason')->nullable()->after('cancellation_request_status');
            $table->timestamp('cancellation_requested_at')->nullable()->after('cancellation_reason');
            $table->text('cancellation_admin_notes')->nullable()->after('cancellation_requested_at');
            $table->timestamp('cancellation_processed_at')->nullable()->after('cancellation_admin_notes');

            $table->string('refund_status', 30)->nullable()->index()->after('cancellation_processed_at');
            $table->decimal('refund_amount', 10, 2)->nullable()->after('refund_status');
            $table->string('refund_id')->nullable()->index()->after('refund_amount');
            $table->timestamp('refunded_at')->nullable()->after('refund_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_request_status',
                'cancellation_reason',
                'cancellation_requested_at',
                'cancellation_admin_notes',
                'cancellation_processed_at',
                'refund_status',
                'refund_amount',
                'refund_id',
                'refunded_at',
            ]);
        });
    }
};
