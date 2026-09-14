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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('coupon_type')->default('general'); // welcome, banner, general
            $table->string('discount_type')->default('percentage'); // percentage, fixed
            $table->decimal('discount_value', 8, 2);
            $table->decimal('min_order_amount', 8, 2)->default(0);
            $table->decimal('max_discount_amount', 8, 2)->nullable();
            $table->boolean('is_banner')->default(false);
            $table->string('banner_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('usage_limit_per_user')->default(1);
            $table->timestamps();
        });

        Schema::create('patient_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            $table->timestamps();
        });

        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('coupon_code')->nullable()->after('amount');
                $table->decimal('discount_amount', 8, 2)->default(0)->after('coupon_code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn(['coupon_code', 'discount_amount']);
            });
        }
        Schema::dropIfExists('patient_coupons');
        Schema::dropIfExists('coupons');
    }
};
