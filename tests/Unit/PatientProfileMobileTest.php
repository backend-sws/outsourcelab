<?php

namespace Tests\Unit;

use App\Models\Patient;
use PHPUnit\Framework\TestCase;

class PatientProfileMobileTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_patient_model_allows_mobile_assignment(): void
    {
        $patient = new Patient([
            'email' => 'backend.sws@gmail.com',
            'mobile' => '9876543210',
            'name' => 'John Doe',
        ]);

        $this->assertEquals('9876543210', $patient->mobile);
        $this->assertEquals('backend.sws@gmail.com', $patient->email);
    }

    public function test_mobile_number_cleaning_logic(): void
    {
        $input = '+91 98765-43210';
        $cleaned = preg_replace('/[^0-9]/', '', $input);
        if (strlen($cleaned) > 10 && str_starts_with($cleaned, '91')) {
            $cleaned = substr($cleaned, 2);
        }

        $this->assertEquals('9876543210', $cleaned);
    }
}
