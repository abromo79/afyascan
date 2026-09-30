<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Values are taken from the content that already existed in the Blade templates.
        $settings = [
            ['key' => 'site_name', 'value' => 'AfyaScan', 'type' => 'text'],
            ['key' => 'main_email', 'value' => 'info@afyascan.com', 'type' => 'text'],
            ['key' => 'secondary_email', 'value' => 'partnerships@afyascan.com', 'type' => 'text'],
            ['key' => 'phone', 'value' => '+255625951579', 'type' => 'text'],
            ['key' => 'address', 'value' => 'Zanzibar, Tanzania', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => null, 'type' => 'text'],
            ['key' => 'linkedin_url', 'value' => null, 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => null, 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => null, 'type' => 'text'],
            ['key' => 'youtube_url', 'value' => null, 'type' => 'text'],
            ['key' => 'footer_text', 'value' => null, 'type' => 'text'],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image'],
            ['key' => 'site_favicon', 'value' => null, 'type' => 'image'],
            ['key' => 'hero_title', 'value' => 'Advancing Breast Health Through Artificial Intelligence', 'type' => 'text'],
            ['key' => 'hero_highlight', 'value' => 'Breast Health', 'type' => 'text'],
            [
                'key' => 'hero_description',
                'value' => 'AfyaScan is a health technology startup developing AI-powered solutions that support breast cancer awareness, risk assessment, and medical image analysis.',
                'type' => 'text',
            ],
            ['key' => 'hero_media', 'value' => null, 'type' => 'media'],
            ['key' => 'hero_cta_label', 'value' => 'Explore Our Products', 'type' => 'text'],
            ['key' => 'hero_cta_url', 'value' => '/products', 'type' => 'text'],
        ];

        foreach ($settings as $order => $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'display_order' => $order,
                ]
            );
        }

        SiteSetting::flushCache();
    }
}
