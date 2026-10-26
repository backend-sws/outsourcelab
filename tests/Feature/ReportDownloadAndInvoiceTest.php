<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\City;
use App\Models\Patient;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportDownloadAndInvoiceTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        City::firstOrCreate(
            ['name' => 'Patna'],
            [
                'state' => 'Bihar',
                'serviceable_pincodes' => ['800001', '800014'],
                'is_active' => true,
                'is_default' => true,
            ]
        );
    }

    public function test_external_report_url_redirects_cleanly(): void
    {
        $rand = rand(10000000, 99999999);
        $patient = Patient::create([
            'name' => 'Ajay Verma',
            'mobile' => '91'.$rand,
            'email' => 'ajay_'.$rand.'@example.com',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-TEST01',
            'patient_id' => $patient->id,
            'collection_type' => 'Home Collection',
            'booking_date' => now()->toDateString(),
            'amount' => 1019,
            'payment_method' => 'Online',
            'status' => 'Report Ready',
            'test_details' => [
                ['name' => 'Liver Function Test (LFT)', 'price' => 600, 'type' => 'test'],
                ['name' => 'Vitamin D (25-OH)', 'price' => 599, 'type' => 'test'],
            ],
            'report_file_path' => 'https://ojaselab.com/reports/download/test-report.pdf',
        ]);

        $this->assertEquals('https://ojaselab.com/reports/download/test-report.pdf', $booking->report_url);

        $response = $this->withSession(['patient_id' => $patient->id])
            ->get(route('patient.bookings.download_report', $booking->id));

        $response->assertRedirect('https://ojaselab.com/reports/download/test-report.pdf');
    }

    public function test_local_report_file_downloads_as_pdf(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('reports/sample_report.pdf', '%PDF-1.4 test dummy content');

        $rand = rand(10000000, 99999999);
        $patient = Patient::create([
            'name' => 'Ajay Verma',
            'mobile' => '91'.$rand,
            'email' => 'ajay_'.$rand.'@example.com',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-TEST02',
            'patient_id' => $patient->id,
            'collection_type' => 'Home Collection',
            'booking_date' => now()->toDateString(),
            'amount' => 500,
            'payment_method' => 'Online',
            'status' => 'Report Ready',
            'test_details' => [
                ['name' => 'Complete Blood Count (CBC)', 'price' => 500, 'type' => 'test'],
            ],
            'report_file_path' => 'reports/sample_report.pdf',
        ]);

        $response = $this->withSession(['patient_id' => $patient->id])
            ->get(route('patient.bookings.download_report', $booking->id));

        $response->assertOk();
        $this->assertStringContainsString('Report-BK-TEST02.pdf', (string) $response->headers->get('content-disposition'));
    }

    public function test_patient_can_view_and_print_booking_tax_invoice(): void
    {
        $rand = rand(10000000, 99999999);
        $patient = Patient::create([
            'name' => 'Ajay Verma',
            'mobile' => '91'.$rand,
            'email' => 'ajay_'.$rand.'@example.com',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-7E0B15',
            'patient_id' => $patient->id,
            'collection_type' => 'Home Collection',
            'booking_date' => now()->toDateString(),
            'amount' => 1019,
            'payment_method' => 'Online',
            'payment_status' => 'paid',
            'status' => 'Report Ready',
            'test_details' => [
                ['name' => 'Liver Function Test (LFT)', 'price' => 600, 'type' => 'test'],
                ['name' => 'Vitamin D (25-OH)', 'price' => 599, 'type' => 'test'],
            ],
        ]);

        $response = $this->withSession(['patient_id' => $patient->id])
            ->get(route('patient.bookings.invoice', $booking->id));

        $response->assertOk();
        $response->assertSee('TAX INVOICE');
        $response->assertSee('BK-7E0B15');
        $response->assertSee('Ajay Verma');
        $response->assertSee('Liver Function Test (LFT)');
        $response->assertSee('Vitamin D (25-OH)');
        $response->assertSee('1,019');
    }
}
