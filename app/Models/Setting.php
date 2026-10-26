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
            'floating_video_enabled',
            'floating_video_url',
            'floating_video_file_path',
            'floating_video_title',
            'floating_video_badge',
            'floating_video_description',
            'floating_video_button_text',
            'floating_video_position',
            'floating_video_autoplay',
            'floating_video_homepage_only',
            'floating_video_thumbnail',
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

        if (! empty($raw)) {
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
        if (! empty($logo)) {
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
        if (! empty($favicon)) {
            if (str_starts_with($favicon, 'http://') || str_starts_with($favicon, 'https://')) {
                return $favicon;
            }

            return asset(ltrim($favicon, '/'));
        }

        return asset('favicon.png');
    }

    /**
     * Get floating promotional / tour video details.
     */
    public static function getFloatingVideoDetails(): ?array
    {
        $enabled = (string) static::get('floating_video_enabled', '0') === '1';
        $rawUrl = trim(static::get('floating_video_url', ''));
        $uploadedFile = trim(static::get('floating_video_file_path', ''));

        // If neither URL nor uploaded file exists, nothing can be played
        if (empty($rawUrl) && empty($uploadedFile)) {
            return null;
        }

        $type = 'youtube';
        $embedUrl = '';
        $videoId = null;
        $autoThumbnail = '';

        if (! empty($uploadedFile)) {
            $type = 'html5';
            $embedUrl = asset(ltrim($uploadedFile, '/'));
        } elseif (! empty($rawUrl)) {
            // Check YouTube: standard watch, youtu.be, shorts, embed
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $rawUrl, $matches)) {
                $type = 'youtube';
                $videoId = $matches[1];
                $embedUrl = "https://www.youtube-nocookie.com/embed/{$videoId}?autoplay=1&rel=0&modestbranding=1&enablejsapi=1";
                $autoThumbnail = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
            } elseif (preg_match('/(?:vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|))(\d+)/i', $rawUrl, $matches)) {
                $type = 'vimeo';
                $videoId = end($matches);
                $embedUrl = "https://player.vimeo.com/video/{$videoId}?autoplay=1";
            } elseif (preg_match('/\.(mp4|webm|ogg)($|\?)/i', $rawUrl)) {
                $type = 'html5';
                $embedUrl = $rawUrl;
            } else {
                $type = 'embed';
                $embedUrl = $rawUrl;
            }
        }

        $customThumb = static::get('floating_video_thumbnail');
        $resolvedThumb = ! empty($customThumb)
            ? (str_starts_with($customThumb, 'http') ? $customThumb : asset(ltrim($customThumb, '/')))
            : $autoThumbnail;

        return [
            'enabled' => $enabled,
            'type' => $type,
            'embed_url' => $embedUrl,
            'raw_url' => $rawUrl,
            'file_path' => $uploadedFile,
            'video_id' => $videoId,
            'thumbnail_url' => $resolvedThumb,
            'title' => static::get('floating_video_title', 'Virtual Lab Tour & Diagnostics Overview'),
            'badge' => static::get('floating_video_badge', 'Watch Lab Tour'),
            'description' => static::get('floating_video_description', 'Explore our state-of-the-art diagnostic facilities and automated pathology analyzers.'),
            'button_text' => static::get('floating_video_button_text', 'Watch Video'),
            'position' => static::get('floating_video_position', 'bottom-right'),
            'autoplay' => (string) static::get('floating_video_autoplay', '1') === '1',
            'homepage_only' => (string) static::get('floating_video_homepage_only', '1') === '1',
        ];
    }
}
