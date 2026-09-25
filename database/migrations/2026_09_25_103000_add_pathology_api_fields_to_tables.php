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
        Schema::table('tests', function (Blueprint $table) {
            $table->unsignedBigInteger('lis_test_id')->nullable()->index()->after('id');
            $table->string('test_code', 50)->nullable()->index()->after('name');
            $table->decimal('lis_price', 10, 2)->nullable()->after('price');
            $table->decimal('original_price', 10, 2)->nullable()->after('lis_price');
            $table->string('sample_type', 100)->nullable()->after('home_collection_available');
            $table->unsignedInteger('tat_hours')->nullable()->after('sample_type');
            $table->boolean('fasting_required')->default(false)->after('tat_hours');
            $table->boolean('lock_pricing')->default(false)->after('is_active');
            $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedBigInteger('lis_package_id')->nullable()->index()->after('id');
            $table->string('package_code', 50)->nullable()->index()->after('name');
            $table->decimal('lis_price', 10, 2)->nullable()->after('price');
            $table->decimal('original_price', 10, 2)->nullable()->after('lis_price');
            $table->unsignedTinyInteger('discount_percentage')->nullable()->after('original_price');
            $table->string('sample_type', 100)->nullable()->after('total_parameters');
            $table->unsignedInteger('tat_hours')->nullable()->after('sample_type');
            $table->boolean('lock_pricing')->default(false)->after('is_active');
            $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('lis_booking_reference', 64)->nullable()->index()->after('booking_reference');
            $table->string('lis_bill_number', 64)->nullable()->index()->after('lis_booking_reference');
            $table->string('lis_status', 50)->nullable()->after('status');
            $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn([
                'lis_test_id',
                'test_code',
                'lis_price',
                'original_price',
                'sample_type',
                'tat_hours',
                'fasting_required',
                'lock_pricing',
                'lis_synced_at',
            ]);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'lis_package_id',
                'package_code',
                'lis_price',
                'original_price',
                'discount_percentage',
                'sample_type',
                'tat_hours',
                'lock_pricing',
                'lis_synced_at',
            ]);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'lis_booking_reference',
                'lis_bill_number',
                'lis_status',
                'lis_synced_at',
            ]);
        });
    }
};
