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
     * Get a setting value by key with caching.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 86400, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            if (! $setting || $setting->value === null || $setting->value === '') {
                return $default;
            }

            return $setting->value;
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
    }
}
