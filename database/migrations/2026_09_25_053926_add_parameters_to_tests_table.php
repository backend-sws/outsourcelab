<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add 'parameters' (JSON array of sub-test parameters) to the tests table.
     * Parameters belong to individual Tests (e.g. CBC → Hemoglobin, RBC, WBC),
     * NOT to Departments/TestCategories.
     */
    public function up(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            // Sub-test parameters list, e.g. ["Hemoglobin","RBC Count","WBC Count"]
            $table->json('parameters')->nullable()->after('report_delivery_time');
        });

        // Remove parameters column from test_categories — departments are just grouping labels
        if (Schema::hasColumn('test_categories', 'parameters')) {
            Schema::table('test_categories', function (Blueprint $table) {
                $table->dropColumn('parameters');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('parameters');
        });

        Schema::table('test_categories', function (Blueprint $table) {
            $table->json('parameters')->nullable()->after('name');
        });
    }
};
