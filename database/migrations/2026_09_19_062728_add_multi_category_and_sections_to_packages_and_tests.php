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
        Schema::table('packages', function (Blueprint $table) {
            $table->json('display_sections')->nullable()->after('type'); // ['top_booked', 'habit', 'femcliffe']
            $table->json('category_ids')->nullable()->after('display_sections'); // [1, 2, 5]
        });

        Schema::table('tests', function (Blueprint $table) {
            $table->json('category_ids')->nullable()->after('test_category_id'); // [1, 3]
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['display_sections', 'category_ids']);
        });

        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['category_ids']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['otp_expires_at']);
        });
    }
};
