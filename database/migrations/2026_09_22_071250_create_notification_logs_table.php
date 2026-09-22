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
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('notifiable'); // notifiable_type + notifiable_id
            $table->string('channel', 20);        // email | sms | whatsapp
            $table->string('event', 80);          // booking_placed | report_ready | …
            $table->string('recipient_name')->nullable();
            $table->string('recipient_contact')->nullable(); // email or phone
            $table->string('subject')->nullable();
            $table->text('body')->nullable();     // short preview / template name
            $table->string('status', 20)->default('sent'); // sent | failed | skipped
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['channel', 'event']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
