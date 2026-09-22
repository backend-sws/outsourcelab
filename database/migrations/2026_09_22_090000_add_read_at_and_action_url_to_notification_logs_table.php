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
        Schema::table('notification_logs', function (Blueprint $table) {
            $table->timestamp('read_at')->nullable()->after('sent_at');
            $table->string('action_url', 500)->nullable()->after('read_at');

            $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'notif_logs_target_read_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_logs', function (Blueprint $table) {
            $table->dropIndex('notif_logs_target_read_idx');
            $table->dropColumn(['read_at', 'action_url']);
        });
    }
};
