<?php

namespace Tests\Unit;

use App\Models\ContactEnquiry;
use PHPUnit\Framework\TestCase;

class ContactEnquiryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_extracts_prescription_url_and_filename_from_message(): void
    {
        $enquiry = new ContactEnquiry([
            'message' => "Patient Mobile: 9876543210\nPrescription Document: /storage/prescriptions/sample_prescription.jpg\nNotes: Urgent callback needed.",
        ]);

        $this->assertEquals('/storage/prescriptions/sample_prescription.jpg', $enquiry->prescription_url);
        $this->assertEquals('sample_prescription.jpg', $enquiry->attachment_filename);
        $this->assertTrue($enquiry->is_image);
        $this->assertFalse($enquiry->is_pdf);
        $this->assertEquals('Urgent callback needed.', $enquiry->clean_notes);
    }

    public function test_identifies_pdf_prescription(): void
    {
        $enquiry = new ContactEnquiry([
            'message' => "Patient Mobile: 9876543210\nPrescription Document: /storage/prescriptions/doctor_slip.pdf\nNotes: Please check fasting tests.",
        ]);

        $this->assertEquals('/storage/prescriptions/doctor_slip.pdf', $enquiry->prescription_url);
        $this->assertEquals('doctor_slip.pdf', $enquiry->attachment_filename);
        $this->assertFalse($enquiry->is_image);
        $this->assertTrue($enquiry->is_pdf);
    }

    public function test_returns_null_when_no_prescription_in_message(): void
    {
        $enquiry = new ContactEnquiry([
            'message' => 'Regular enquiry without any attachment or document.',
        ]);

        $this->assertNull($enquiry->prescription_url);
        $this->assertNull($enquiry->attachment_filename);
        $this->assertFalse($enquiry->is_image);
        $this->assertFalse($enquiry->is_pdf);
        $this->assertEquals('Regular enquiry without any attachment or document.', $enquiry->clean_notes);
    }
}
