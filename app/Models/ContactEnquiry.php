<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'subject', 'message', 'status',
    ];

    /**
     * Extract prescription / document URL from enquiry message.
     */
    public function getPrescriptionUrlAttribute(): ?string
    {
        if (empty($this->message)) {
            return null;
        }

        if (preg_match('#(?:Prescription Document:\s*)?(https?://[^\s\n\r"\'<>]+|/storage/[^\s\n\r"\'<>]+|storage/[^\s\n\r"\'<>]+)#i', $this->message, $matches)) {
            $url = $matches[1];
            if (str_starts_with($url, 'storage/')) {
                return '/'.$url;
            }

            return $url;
        }

        return null;
    }

    /**
     * Check if attachment is an image.
     */
    public function getIsImageAttribute(): bool
    {
        $url = $this->prescription_url;
        if (! $url) {
            return false;
        }

        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg']);
    }

    /**
     * Check if attachment is a PDF.
     */
    public function getIsPdfAttribute(): bool
    {
        $url = $this->prescription_url;
        if (! $url) {
            return false;
        }

        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));

        return $extension === 'pdf';
    }

    /**
     * Get attachment filename for display/download.
     */
    public function getAttachmentFilenameAttribute(): ?string
    {
        $url = $this->prescription_url;
        if (! $url) {
            return null;
        }

        return basename(parse_url($url, PHP_URL_PATH) ?? '');
    }

    /**
     * Get clean patient notes without technical file paths and redundant mobile prefixes.
     */
    public function getCleanNotesAttribute(): string
    {
        $message = $this->message ?? '';

        if (preg_match('/Notes:\s*(.*)/is', $message, $matches)) {
            $notes = trim($matches[1]);
            if (! empty($notes)) {
                return $notes;
            }
        }

        $clean = preg_replace('/Prescription Document:\s*[^\s\n\r]+/i', '', $message);
        $clean = preg_replace('/Patient Mobile:\s*[^\n\r]+/i', '', $clean);
        $clean = trim($clean);

        return ! empty($clean) ? $clean : $message;
    }
}
