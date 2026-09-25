<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pathology SaaS / LIS REST API Configuration
    |--------------------------------------------------------------------------
    |
    | OutsourceLab connects with the Pathology Laboratory Information System
    | via REST API v1 for catalog synchronization, online web booking submissions,
    | automated signed report linking, and patient SSO dashboard redirects.
    |
    */

    'enabled' => (bool) env('PATHOLOGY_API_ENABLED', true),

    'sso_enabled' => (bool) env('PATHOLOGY_SSO_ENABLED', true),

    'admin_sync_enabled' => (bool) env('PATHOLOGY_ADMIN_SYNC_ENABLED', false),

    'base_url' => env('PATHOLOGY_API_BASE_URL', 'https://your-pathology-domain.com/api/v1'),

    'api_key' => env('PATHOLOGY_API_KEY', ''),

    'default_branch_id' => (int) env('PATHOLOGY_DEFAULT_BRANCH_ID', 1),

    'timeout' => (int) env('PATHOLOGY_API_TIMEOUT', 20),

    'ssl_verify' => (bool) env('PATHOLOGY_SSL_VERIFY', env('APP_ENV') === 'production'),

    'auto_sync_reports' => (bool) env('PATHOLOGY_AUTO_SYNC_REPORTS', true),
];
