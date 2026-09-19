<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General & Branding
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Av Wellcare Diagnostics', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Fast, Reliable Diagnostics', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => '/logo.png', 'type' => 'image'],
            ['group' => 'general', 'key' => 'cin_number', 'value' => 'CIN: U85190UP2021PTC149892', 'type' => 'text'],
            ['group' => 'general', 'key' => 'copyright_text', 'value' => 'Av Wellcare Diagnostics © 2026. All rights reserved.', 'type' => 'text'],

            // Contact & Helpdesk
            ['group' => 'contact', 'key' => 'helpline_primary', 'value' => '898 898 8787', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'helpline_secondary', 'value' => '+91 9876543210', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'whatsapp_number', 'value' => '8988988787', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'support_email', 'value' => 'care@avwellcarediagnostics.com', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'collection_timing', 'value' => 'Daily 6:00 AM – 9:00 PM (Trained Phlebotomists)', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'registered_address', 'value' => "Av Wellcare Lifetech Pvt. Ltd.\nH-21, 2nd Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301", 'type' => 'text'],
            ['group' => 'contact', 'key' => 'reference_lab_address', 'value' => "Av Wellcare Lifetech Pvt. Ltd.\nH-21, 4th Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301", 'type' => 'text'],

            // Social Media Links
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => 'https://twitter.com', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://linkedin.com', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => 'https://youtube.com', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://instagram.com', 'type' => 'text'],

            // Homepage Healthcare Stats
            ['group' => 'stats', 'key' => 'stat_lives_touched_val', 'value' => '1', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_lives_touched_text', 'value' => 'Crore+ Lives Touched', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_owned_labs_val', 'value' => '80', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_owned_labs_text', 'value' => '+ Self-Owned Labs', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_collection_centres_val', 'value' => '2000', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_collection_centres_text', 'value' => '+ Collection Centres', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_phlebotomists_val', 'value' => '1500', 'type' => 'text'],
            ['group' => 'stats', 'key' => 'stat_phlebotomists_text', 'value' => '+ Trained Phlebotomists', 'type' => 'text'],

            // Serviceable Pincodes
            ['group' => 'service', 'key' => 'serviceable_pincodes', 'value' => '800001, 800002, 110001, 201301, 201309, 400001, 560001', 'type' => 'text'],
        ];

        foreach ($settings as $s) {
            Setting::set($s['key'], $s['value'], $s['group'], $s['type']);
        }
    }
}
