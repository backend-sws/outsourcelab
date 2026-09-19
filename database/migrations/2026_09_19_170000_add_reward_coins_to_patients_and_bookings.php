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
        Schema::table('patients', function (Blueprint $table) {
            if (! Schema::hasColumn('patients', 'reward_coins')) {
                $table->unsignedInteger('reward_coins')->default(0)->after('cart');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'coins_redeemed')) {
                $table->unsignedInteger('coins_redeemed')->default(0)->after('discount_amount');
            }
            if (! Schema::hasColumn('bookings', 'coins_discount')) {
                $table->decimal('coins_discount', 10, 2)->default(0)->after('coins_redeemed');
            }
            if (! Schema::hasColumn('bookings', 'coins_earned')) {
                $table->unsignedInteger('coins_earned')->default(0)->after('coins_discount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'reward_coins')) {
                $table->dropColumn('reward_coins');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['coins_redeemed', 'coins_discount', 'coins_earned']);
        });
    }
};
