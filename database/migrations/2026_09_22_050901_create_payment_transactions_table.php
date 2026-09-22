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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference')->unique();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->foreignId('patient_membership_id')->nullable()->constrained('patient_memberships')->onDelete('set null');
            $table->string('type')->default('booking'); // booking, membership
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('INR');
            $table->string('gateway', 30)->default('razorpay');
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable()->index();
            $table->string('razorpay_signature')->nullable();
            $table->string('payment_method', 50)->nullable(); // upi, card, netbanking, wallet, cash
            $table->string('bank', 100)->nullable();
            $table->string('wallet', 100)->nullable();
            $table->string('vpa', 150)->nullable();
            $table->string('status', 30)->default('created')->index(); // created, authorized, captured, failed, refunded
            $table->string('error_code')->nullable();
            $table->text('error_description')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->json('webhook_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
