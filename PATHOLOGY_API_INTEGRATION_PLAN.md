# 🌐 OutsourceLab ⚡ Pathology SaaS LIS REST API Integration Plan

This document serves as the master architectural specification and step-by-step implementation guide for seamlessly connecting **OutsourceLab** (Frontend Marketing, Patient Booking & Franchise Portal) with **Pathology SaaS / LIS Software** (Laboratory Information System).

---

## 🏗️ 1. Architecture & Data Flow Overview

```mermaid
flowchart TD
    subgraph OutsourceLab ["🌐 OutsourceLab Portal (Client Facing & Storefront)"]
        AdminUI["Admin Panel (/admin/tests, /admin/packages)"]
        SyncEngine["Sync Engine (Command: pathology:sync-catalog & Admin GUI)"]
        PricingEngine["Pricing & Offer Manager (MRP, Selling Price, Discount %)"]
        BookingEngine["Booking & Checkout Engine (PatientBookingController)"]
        ReportPoller["Auto-Report Linker (SyncPendingReportsJob)"]
        ReportTrackUI["Report Download Page (/download-report)"]
        SSOLoginUI["LIS Patient Login Page (/lis-login)"]
        LocalDB[("Local MySQL DB (tests, packages, bookings)")]
    end

    subgraph PathologySaaS ["🏥 Pathology SaaS / LIS Cloud (REST API v1)"]
        APICatalog["GET /api/v1/departments\nGET /api/v1/tests\nGET /api/v1/packages\nGET /api/v1/packages/{id}"]
        APIBooking["POST /api/v1/bookings"]
        APITrack["POST /api/v1/reports/track"]
        APISSO["POST /api/v1/patient/login"]
        LISLabEngine["NABL LIS Lab Processing & Doctor Digital Signatures"]
        PortalDashboard["Patient Dashboard (/portal/dashboard)"]
    end

    %% Sync Catalog Flow
    SyncEngine -->|1. Fetch Tests, Packages, Base Lab Cost| APICatalog
    APICatalog -->|Returns Catalog JSON| SyncEngine
    SyncEngine -->|Save LIS IDs & Base Costs| LocalDB

    %% Admin Pricing Flow
    AdminUI -->|2. Admin sets custom Selling Price, MRP, Discount %| PricingEngine
    PricingEngine -->|Store Protected Custom Prices (lock_pricing)| LocalDB

    %% Booking Flow
    BookingEngine -->|3. On Checkout: Push Order Payload| APIBooking
    APIBooking -->|Returns LIS Booking Ref (e.g. WB-20260925-A8F2C)| BookingEngine
    BookingEngine -->|Save LIS Ref into Booking Record| LocalDB

    %% Report Linking Flow
    LISLabEngine -->|Doctor Approves & Signs NABL PDF| APITrack
    ReportPoller -->|4. Checks Status for Pending Orders| APITrack
    APITrack -->|Returns is_ready: true + Signed download_url| ReportPoller
    ReportPoller -->|5. Auto-binds PDF Link & Sets status='Report Ready'| LocalDB

    %% Patient UI Flow
    ReportTrackUI -->|Check Status on Demand| APITrack
    SSOLoginUI -->|Submit Patient ID + Mobile| APISSO
    APISSO -->|Returns Signed SSO URL| SSOLoginUI
    SSOLoginUI -->|Redirect Patient Browser| PortalDashboard
```

---

## 🔑 2. Environment Configuration & Settings

### 2.1 `.env` Settings
```env
# =========================================================================
# PATHOLOGY SAAS / LIS REST API CONFIGURATION
# =========================================================================
PATHOLOGY_API_BASE_URL="https://your-pathology-domain.com/api/v1"
PATHOLOGY_API_KEY="lab_your_secret_api_key_here"
PATHOLOGY_DEFAULT_BRANCH_ID=1
PATHOLOGY_API_TIMEOUT=20
PATHOLOGY_AUTO_SYNC_REPORTS=true
```

### 2.2 `config/pathology.php`
```php
<?php

return [
    'base_url' => env('PATHOLOGY_API_BASE_URL', 'https://your-pathology-domain.com/api/v1'),
    'api_key' => env('PATHOLOGY_API_KEY', ''),
    'default_branch_id' => env('PATHOLOGY_DEFAULT_BRANCH_ID', 1),
    'timeout' => env('PATHOLOGY_API_TIMEOUT', 20),
    'auto_sync_reports' => env('PATHOLOGY_AUTO_SYNC_REPORTS', true),
];
```

### 2.3 OutsourceLab Admin GUI Settings
Under `Admin -> Settings -> Pathology LIS Integration`:
- **API Base URL** input field
- **API Secret Key (`X-Lab-Api-Key`)** input field
- **Default Branch ID** dropdown (loaded live from `GET /api/v1/branches`)
- **[Test Connection]** Button: Pings `/branches` to verify handshake and displays Green/Red status badge.

---

## 🗄️ 3. Database Schema Changes (Migrations)

### 3.1 Migration: Update `tests` Table
```php
Schema::table('tests', function (Blueprint $table) {
    $table->unsignedBigInteger('lis_test_id')->nullable()->index()->after('id');
    $table->string('test_code', 50)->nullable()->index()->after('name');
    $table->decimal('lis_price', 10, 2)->nullable()->after('price'); // Base cost from LIS
    $table->decimal('original_price', 10, 2)->nullable()->after('lis_price'); // MRP for strike-through (e.g. ~₹600~)
    $table->string('sample_type', 100)->nullable()->after('home_collection_available');
    $table->unsignedInteger('tat_hours')->nullable()->after('sample_type');
    $table->boolean('fasting_required')->default(false)->after('tat_hours');
    $table->boolean('lock_pricing')->default(false)->after('is_active'); // If true, sync will NOT overwrite admin selling price
    $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
});
```

### 3.2 Migration: Update `packages` Table
```php
Schema::table('packages', function (Blueprint $table) {
    $table->unsignedBigInteger('lis_package_id')->nullable()->index()->after('id');
    $table->string('package_code', 50)->nullable()->index()->after('name');
    $table->decimal('lis_price', 10, 2)->nullable()->after('price'); // Base cost from LIS
    $table->decimal('original_price', 10, 2)->nullable()->after('lis_price'); // Strike-through MRP
    $table->unsignedTinyInteger('discount_percentage')->nullable()->after('original_price'); // e.g. 35% OFF
    $table->string('sample_type', 100)->nullable()->after('total_parameters');
    $table->unsignedInteger('tat_hours')->nullable()->after('sample_type');
    $table->boolean('lock_pricing')->default(false)->after('is_active'); // Admin protection flag
    $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
});
```

### 3.3 Migration: Update `bookings` Table
```php
Schema::table('bookings', function (Blueprint $table) {
    $table->string('lis_booking_reference', 64)->nullable()->index()->after('booking_reference'); // e.g. WB-20260925-A8F2C
    $table->string('lis_bill_number', 64)->nullable()->index()->after('lis_booking_reference'); // e.g. INV-2609-0012
    $table->string('lis_status', 50)->nullable()->after('status'); // LIS stage (e.g. Under Analysis, Report Ready)
    $table->timestamp('lis_synced_at')->nullable()->after('updated_at');
});
```

---

## 🛠️ 4. Dedicated Service Layer: `App\Services\PathologyApiService`

Create `app/Services/PathologyApiService.php` using Laravel's `Http` facade:

```php
<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PathologyApiService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(Setting::get('pathology_api_base_url', config('pathology.base_url')), '/');
        $this->apiKey = Setting::get('pathology_api_key', config('pathology.api_key'));
        $this->timeout = (int) config('pathology.timeout', 20);
    }

    /**
     * Send authenticated HTTP request to Pathology LIS.
     */
    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'X-Lab-Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])
            ->timeout($this->timeout);
    }

    /**
     * Test handshake connection.
     */
    public function ping(): bool
    {
        try {
            $response = $this->client()->get('/branches');
            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('Pathology API Ping Failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 1. Get Branches & Collection Centers
     */
    public function getBranches(): array
    {
        $res = $this->client()->get('/branches');
        return $res->json('data', []);
    }

    /**
     * 2. Get Test Departments
     */
    public function getDepartments(): array
    {
        $res = $this->client()->get('/departments');
        return $res->json('data', []);
    }

    /**
     * 3. Get Tests Catalog (with pagination & search)
     */
    public function getTests(array $params = []): array
    {
        $res = $this->client()->get('/tests', $params);
        return $res->json('data', []);
    }

    /**
     * 4. Get Packages Catalog
     */
    public function getPackages(): array
    {
        $res = $this->client()->get('/packages');
        return $res->json('data', []);
    }

    /**
     * 5. Get Package Details with sub-tests & parameters breakdown
     */
    public function getPackageDetails(int $packageId): ?array
    {
        $res = $this->client()->get("/packages/{$packageId}");
        return $res->successful() ? $res->json('data') : null;
    }

    /**
     * 6. Submit Online Booking to LIS
     */
    public function createBooking(array $bookingData): ?array
    {
        try {
            $res = $this->client()->post('/bookings', $bookingData);
            if ($res->successful()) {
                return $res->json('data');
            }
            Log::warning('LIS Booking Submission Failed: ' . $res->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('Pathology API Create Booking Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 7. Track Report Status & Fetch Signed PDF
     */
    public function trackReport(string $billNumberOrRef, string $phone): ?array
    {
        try {
            $res = $this->client()->post('/reports/track', [
                'bill_number' => $billNumberOrRef,
                'phone' => $phone,
            ]);
            return $res->successful() ? $res->json('data') : null;
        } catch (\Throwable $e) {
            Log::error('Pathology API Track Report Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 8. Patient Portal Single Sign-On (SSO)
     */
    public function patientLogin(string $patientIdOrBill, string $phone): ?array
    {
        try {
            $res = $this->client()->post('/patient/login', [
                'patient_id' => $patientIdOrBill,
                'phone' => $phone,
            ]);
            return $res->successful() ? $res->json('data') : null;
        } catch (\Throwable $e) {
            Log::error('Pathology API Patient Login Exception: ' . $e->getMessage());
            return null;
        }
    }
}
```

---

## 🎯 5. Feature Implementation Breakdown

### 5.1 Pillar 1: Test & Package Sync Engine

#### Command: `php artisan pathology:sync-catalog` & Admin GUI Button
When triggered:
1. Calls `getDepartments()`: Maps or updates `test_categories` / `categories`.
2. Calls `getTests(['per_page' => 100])`:
   - Matches test by `lis_test_id` or `test_code`.
   - Updates: `name`, `test_code`, `lis_price`, `sample_type`, `tat_hours`, `fasting_required`, `lis_synced_at`.
   - **Crucial Rule:** If `$test->lock_pricing == false` and `$test->price == 0`, default selling `price = lis_price`.
   - **If Admin has previously set a custom `price` or ticked `lock_pricing`, THE ADMIN'S SELLING PRICE & OFFERS ARE NEVER OVERWRITTEN!**
3. Calls `getPackages()`:
   - For each package, calls `getPackageDetails($pkg['id'])` to fetch the complete nested list of included tests and parameters.
   - Updates `packages` record with `lis_package_id`, `package_code`, `lis_price`, `parameters` JSON, `total_parameters`, `sample_type`, `tat_hours`.
   - Retains admin custom pricing, discounts, and section placements.

---

### 5.2 Pillar 2: OutsourceLab Admin Pricing & Offer Override

In OutsourceLab's Admin Panel (`/admin/tests/{id}/edit` & `/admin/packages/{id}/edit`):

```
┌────────────────────────────────────────────────────────────────────────┐
│ 🏥 LIS Synced Information (Reference Only)                             │
│ Test Code: CBC | Sample: EDTA Blood | LIS Base Cost: ₹350.00           │
│ Last Synced: 24 Sep 2026, 05:30 PM                                     │
├────────────────────────────────────────────────────────────────────────┤
│ 🏷️ OutsourceLab Website Commercial & Pricing Settings                   │
│                                                                        │
│ [X] Lock Custom Price (Protect from future LIS auto-sync overwrites)   │
│                                                                        │
│ Market MRP (Strike-through):   [ ₹ 600.00 ]                            │
│ Website Selling Price:        [ ₹ 399.00 ]                             │
│ Computed Customer Discount:    🎉 33% OFF (Calculated Automatically)   │
│                                                                        │
│ Badges / Promotion:            [ Recommended / Bestseller ▼ ]          │
│ Display Sections:              [X] Top Booked  [X] Full Body Checkup   │
└────────────────────────────────────────────────────────────────────────┘
```

#### Frontend Display (Card & Detail Page):
- **MRP**: `<span class="line-through text-slate-400">₹600</span>`
- **Selling Price**: `<span class="text-2xl font-black text-teal-700">₹399</span>`
- **Badge**: `<span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-0.5 rounded">33% OFF</span>`
- **Gross Profit Margin Tracking**: Admin can compare `price (₹399) - lis_price (₹350) = ₹49 net margin per test`.

---

### 5.3 Pillar 3: Web Booking Push to LIS

In `PatientBookingController@placeBooking`:
1. When a patient completes checkout (or Razorpay payment completes successfully):
   - Local `Booking` is created with unique reference `BK-XXXXXX`.
2. Construct LIS items payload:
   ```php
   $lisItems = [];
   foreach ($sanitizedCart as $item) {
       if ($item['type'] === 'test') {
           $test = Test::find($item['id']);
           if ($test && $test->lis_test_id) {
               $lisItems[] = ['type' => 'test', 'id' => (int) $test->lis_test_id];
           }
       } elseif ($item['type'] === 'package') {
           $pkg = Package::find($item['id']);
           if ($pkg && $pkg->lis_package_id) {
               $lisItems[] = ['type' => 'package', 'id' => (int) $pkg->lis_package_id];
           }
       }
   }
   ```
3. If `$lisItems` is not empty, call:
   ```php
   $lisResponse = app(PathologyApiService::class)->createBooking([
       'patient_name' => $patient->name,
       'patient_phone' => $patient->mobile,
       'patient_email' => $patient->email,
       'patient_gender' => $patient->gender ?? 'other',
       'patient_age' => $patient->age ?? 30,
       'collection_type' => $booking->collection_type === 'Home Collection' ? 'home_collection' : 'lab_visit',
       'collection_address' => $booking->address?->full_address ?? 'N/A',
       'preferred_date' => $booking->booking_date->toDateString(),
       'preferred_time_slot' => $booking->collection_slot,
       'branch_id' => (int) config('pathology.default_branch_id', 1),
       'notes' => "Website Order: #{$booking->booking_reference}",
       'items' => $lisItems,
   ]);

   if ($lisResponse && !empty($lisResponse['booking_reference'])) {
       $booking->lis_booking_reference = $lisResponse['booking_reference'];
       $booking->lis_synced_at = now();
       $booking->save();
   }
   ```
4. If the LIS API is momentarily slow or offline, dispatch `PushBookingToLisJob` to ensure checkout is instantaneous and zero orders are lost.

---

### 5.4 Pillar 4: Automatic Report Linking

#### Workflow:
1. When lab doctor completes analysis and digitally signs report in Pathology LIS:
2. **Auto-Poller (`SyncPendingReportsJob`):**
   - Scheduled in `routes/console.php` to run every 15 minutes:
     ```php
     Schedule::job(new \App\Jobs\SyncPendingReportsJob)->everyFifteenMinutes();
     ```
   - Fetches recent bookings where `status != 'Report Ready'` and `lis_booking_reference IS NOT NULL`.
   - Calls `POST /api/v1/reports/track` using `{ bill_number: $booking->lis_booking_reference, phone: $booking->patient->mobile }`.
   - When LIS returns:
     ```json
     {
       "is_ready": true,
       "download_url": "https://your-pathology-domain.com/v/aW52b2ljZV9pZF8xMjg=",
       "current_stage": "Report Ready"
     }
     ```
   - OutsourceLab automatically:
     1. Sets `$booking->report_file_path = $data['download_url'];`
     2. Sets `$booking->status = 'Report Ready';`
     3. Calls `app(NotificationService::class)->reportReady($booking);`
     4. Patient receives Email / WhatsApp / SMS with the direct download link!

#### On-Demand Tracking (`/download-report`):
- When a patient visits `/download-report` and enters their Booking ID / Bill No and Phone:
- Calls `POST /api/v1/reports/track` in real-time.
- If ready, shows Green Checkmark + **[Download Signed PDF Report]** button opening the tamper-proof NABL PDF.
- If in progress, renders real-time tracking stepper (*Sample Collected -> Under Processing -> Doctor Review*).

---

### 5.5 Pillar 5: Patient Single Sign-On (`/lis-login`)

On `/lis-login` page:
1. Patient enters **Patient ID / Bill Number** and **Mobile Number**.
2. Form submits to `/lis-login/authenticate`.
3. Calls `PathologyApiService::patientLogin($patientId, $phone)`.
4. Response returns signed URL:
   `https://your-pathology-domain.com/portal/auth/sso/20?expires=...&signature=...`
5. JavaScript immediately redirects:
   ```javascript
   window.location.href = response.data.redirect_url;
   ```
6. Patient lands straight inside their authenticated LIS Patient Portal (`/portal/dashboard`) with complete medical test history, past reports, and invoices.

---

## 🚀 6. Step-by-Step Implementation Roadmap

```
Phase 1: Foundations (Config, Credentials & Service Layer)
  ├── 1.1 Add .env and config/pathology.php
  ├── 1.2 Implement App\Services\PathologyApiService with error handling & logging
  └── 1.3 Add Admin Setting UI controls & "Test Connection" ping button

Phase 2: Database Enhancements (Migrations)
  ├── 2.1 Add lis_test_id, lis_price, original_price, lock_pricing to tests table
  ├── 2.2 Add lis_package_id, lis_price, original_price, lock_pricing to packages table
  └── 2.3 Add lis_booking_reference, lis_bill_number, lis_status to bookings table

Phase 3: Catalog Sync & Admin Pricing Overrides
  ├── 3.1 Create Artisan Command: pathology:sync-catalog
  ├── 3.2 Add "🔄 Sync Catalog with LIS" button in Admin Tests & Packages pages
  └── 3.3 Update Admin Form & Controller to allow setting MRP, Selling Price, Discount %

Phase 4: Booking Forwarding & Checkout Push
  ├── 4.1 Update PatientBookingController@placeBooking to push order to LIS
  └── 4.2 Save lis_booking_reference in Booking record

Phase 5: Auto-Report Linking & Patient Access
  ├── 5.1 Connect /download-report form to live POST /api/v1/reports/track
  ├── 5.2 Implement scheduled SyncPendingReportsJob to auto-link ready reports
  └── 5.3 Connect /lis-login to POST /api/v1/patient/login for seamless SSO
```

---

## 🛡️ 7. Key Safeguards & Design Decisions

1. **Price Protection Guarantee (`lock_pricing`):**
   Auto-syncing will **never** silently overwrite Admin's customized selling prices or discount campaigns.
2. **Zero Checkout Blocking:**
   If the Pathology LIS API server is experiencing downtime, OutsourceLab's patient checkout will still succeed locally, and orders will be queued for synchronization.
3. **SEO & Performance First:**
   All public test/package exploration pages load instantaneously from OutsourceLab's local MySQL cache and database, ensuring Google SEO rankings are maximized without external API latency.
4. **Digital Signature Preservation:**
   Reports linked from the LIS retain full cryptographic NABL signatures and QR code verification generated by the Pathology LIS software.
