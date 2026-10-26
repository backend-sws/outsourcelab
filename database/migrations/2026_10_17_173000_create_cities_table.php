<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->nullable();
            $table->string('state', 100)->nullable();
            $table->text('pincodes')->nullable(); // Comma or newline separated list of pincodes
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        // Pre-seed initial default cities with serviceable pincodes
        $now = now();
        $defaultCities = [
            [
                'name' => 'Patna',
                'slug' => 'patna',
                'state' => 'Bihar',
                'pincodes' => '800001, 800002, 800003, 800004, 800005, 800006, 800007, 800008, 800013, 800014, 800020, 800023, 800024, 800025',
                'is_default' => true,
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gaya',
                'slug' => 'gaya',
                'state' => 'Bihar',
                'pincodes' => '823001, 823002, 823003, 823004, 824231',
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Muzaffarpur',
                'slug' => 'muzaffarpur',
                'state' => 'Bihar',
                'pincodes' => '842001, 842002, 842003, 842004',
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ranchi',
                'slug' => 'ranchi',
                'state' => 'Jharkhand',
                'pincodes' => '834001, 834002, 834003, 834004, 834005',
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Delhi NCR',
                'slug' => 'delhi-ncr',
                'state' => 'Delhi',
                'pincodes' => '110001, 110002, 110003, 110005, 110020, 110025, 201301',
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('cities')->insert($defaultCities);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
