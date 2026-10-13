<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    /**
     * Get alias key for common synonyms.
     */
    public static function getAlias(string $key): ?string
    {
        return match ($key) {
            'contact_email' => 'support_email',
            'support_email' => 'contact_email',
            'working_hours' => 'collection_timing',
            'collection_timing' => 'working_hours',
            default => null,
        };
    }

    /**
     * Get a setting value by key with caching.
     */
    public static function get(string $key, $default = null)
    {
        $alias = static::getAlias($key);

        return Cache::remember("site_setting_{$key}", 86400, function () use ($key, $default, $alias) {
            $setting = static::where('key', $key)->first();
            if ($setting && $setting->value !== null && $setting->value !== '') {
                return $setting->value;
            }

            if ($alias) {
                $aliasSetting = static::where('key', $alias)->first();
                if ($aliasSetting && $aliasSetting->value !== null && $aliasSetting->value !== '') {
                    return $aliasSetting->value;
                }
            }

            return $default;
        });
    }

    /**
     * Set a setting value and clear its cache.
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'type' => $type,
            ]
        );

        Cache::forget("site_setting_{$key}");
        $alias = static::getAlias($key);
        if ($alias) {
            Cache::forget("site_setting_{$alias}");
        }
        Cache::forget('all_site_settings_grouped');

        return $setting;
    }

    /**
     * Get all settings grouped by group name with caching.
     */
    public static function getAllGrouped(): array
    {
        return Cache::remember('all_site_settings_grouped', 86400, function () {
            $all = static::all();
            $grouped = [];
            foreach ($all as $item) {
                $grouped[$item->group][$item->key] = $item->value;
            }

            return $grouped;
        });
    }

    /**
     * Clear all setting caches.
     */
    public static function clearSettingCache(): void
    {
        Cache::forget('all_site_settings_grouped');
        $allKeys = static::pluck('key');
        foreach ($allKeys as $key) {
            Cache::forget("site_setting_{$key}");
        }

        // Explicitly clear commonly used keys and aliases
        $knownKeys = [
            'site_name',
            'site_tagline',
            'site_logo',
            'site_favicon',
            'cin_number',
            'copyright_text',
            'footer_about',
            'helpline_primary',
            'helpline_secondary',
            'whatsapp_number',
            'support_email',
            'contact_email',
            'collection_timing',
            'working_hours',
            'company_legal_name',
            'registered_address',
            'reference_lab_address',
            'social_facebook',
            'social_twitter',
            'social_linkedin',
            'social_youtube',
            'social_instagram',
            'serviceable_pincodes',
            'banner_images',
        ];

        foreach ($knownKeys as $k) {
            Cache::forget("site_setting_{$k}");
        }
    }

    /**
     * Get default system hero background banners (relative paths).
     */
    public static function getDefaultBannerImages(): array
    {
        return [
            'hero_banner_dna.jpg',
            'banner.jpg',
            'biochemistry.jpg',
            'flask.jpg',
            'two-asian.jpg',
        ];
    }

    /**
     * Get raw stored banner image paths (returns default 5 if not customized yet).
     */
    public static function getRawBannerImages(): array
    {
        $raw = static::get('banner_images');

        // If never customized, return the 5 initial system defaults
        if ($raw === null) {
            return static::getDefaultBannerImages();
        }

        if (!empty($raw)) {
            $decoded = is_array($raw) ? $raw : json_decode($raw, true);
            if (is_array($decoded)) {
                return array_values($decoded);
            }
        }

        return [];
    }

    /**
     * Check if custom banner configuration exists.
     */
    public static function hasCustomBanners(): bool
    {
        return static::get('banner_images') !== null;
    }

    /**
     * Get resolved URLs of all active hero banner images.
     */
    public static function getBannerImages(): array
    {
        $rawBanners = static::getRawBannerImages();
        if (count($rawBanners) > 0) {
            return array_values(array_map(function ($img) {
                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                    return $img;
                }
                return asset(ltrim($img, '/'));
            }, $rawBanners));
        }

        // Safe fallback if all banners were deleted
        return [asset('hero_banner_dna.jpg')];
    }

    /**
     * Get the resolved URL for the site logo, with fallback.
     */
    public static function getLogoUrl(): string
    {
        $logo = static::get('site_logo');
        if (!empty($logo)) {
            if (str_starts_with($logo, 'http://') || str_starts_with($logo, 'https://')) {
                return $logo;
            }
            return asset(ltrim($logo, '/'));
        }

        return asset('logo.png');
    }

    /**
     * Get the resolved URL for the site favicon, with fallback.
     */
    public static function getFaviconUrl(): string
    {
        $favicon = static::get('site_favicon');
        if (!empty($favicon)) {
            if (str_starts_with($favicon, 'http://') || str_starts_with($favicon, 'https://')) {
                return $favicon;
            }
            return asset(ltrim($favicon, '/'));
        }

        return asset('favicon.png');
    }
}


