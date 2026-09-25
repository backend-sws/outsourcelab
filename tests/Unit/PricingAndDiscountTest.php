<?php

namespace Tests\Unit;

use App\Models\Package;
use App\Models\Test;
use PHPUnit\Framework\TestCase;

class PricingAndDiscountTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_test_without_mrp_has_no_discount(): void
    {
        $test = new Test([
            'name' => 'Complete Blood Count',
            'price' => 500,
            'original_price' => null,
        ]);

        $this->assertFalse($test->hasDiscount());
        $this->assertNull($test->effective_mrp);
        $this->assertNull($test->discount_percentage);
    }

    public function test_test_with_mrp_calculates_discount(): void
    {
        $test = new Test([
            'name' => 'Lipid Profile',
            'price' => 600,
            'original_price' => 800,
        ]);

        $this->assertTrue($test->hasDiscount());
        $this->assertEquals(800.0, $test->effective_mrp);
        $this->assertEquals(25, $test->discount_percentage);
    }

    public function test_package_without_mrp_or_discount_has_no_discount(): void
    {
        $package = new Package([
            'name' => 'Full Body Health Check',
            'price' => 1499,
            'original_price' => null,
            'discount_percentage' => null,
        ]);

        $this->assertFalse($package->hasDiscount());
        $this->assertNull($package->effective_mrp);
        $this->assertEquals(0, $package->effective_discount_percentage);
    }

    public function test_package_with_mrp_calculates_discount(): void
    {
        $package = new Package([
            'name' => 'Executive Wellness Plan',
            'price' => 1500,
            'original_price' => 2000,
            'discount_percentage' => null,
        ]);

        $this->assertTrue($package->hasDiscount());
        $this->assertEquals(2000.0, $package->effective_mrp);
        $this->assertEquals(25, $package->effective_discount_percentage);
    }

    public function test_package_with_explicit_discount_percentage(): void
    {
        $package = new Package([
            'name' => 'Senior Citizen Checkup',
            'price' => 1200,
            'original_price' => null,
            'discount_percentage' => 40,
        ]);

        $this->assertTrue($package->hasDiscount());
        $this->assertEquals(40, $package->effective_discount_percentage);
        $this->assertEquals(2000.0, $package->effective_mrp);
    }
}
