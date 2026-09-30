<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['key', 'value', 'type', 'display_order'])]
class SiteSetting extends Model
{
    /**
     * The social networks the website can link to, with their icons.
     *
     * @var array<string, array{label: string, icon: string}>
     */
    private const SOCIAL_NETWORKS = [
        'facebook_url' => ['label' => 'Facebook', 'icon' => 'bi-facebook'],
        'linkedin_url' => ['label' => 'LinkedIn', 'icon' => 'bi-linkedin'],
        'twitter_url' => ['label' => 'X', 'icon' => 'bi-twitter-x'],
        'instagram_url' => ['label' => 'Instagram', 'icon' => 'bi-instagram'],
        'youtube_url' => ['label' => 'YouTube', 'icon' => 'bi-youtube'],
    ];

    /**
     * @var array<string, string>|null
     */
    protected static ?array $cache = null;

    /**
     * All settings as a key => value map, loaded once per request.
     *
     * @return array<string, string>
     */
    public static function map(): array
    {
        return static::$cache ??= static::query()->pluck('value', 'key')->all();
    }

    public static function value(string $key, ?string $default = null): ?string
    {
        $value = static::map()[$key] ?? null;

        return filled($value) ? $value : $default;
    }

    /**
     * The social networks that have a URL saved, ready for the footer.
     *
     * @return array<int, array{label: string, icon: string, url: string}>
     */
    public static function socialLinks(): array
    {
        $links = [];

        foreach (static::SOCIAL_NETWORKS as $key => $network) {
            if ($url = static::value($key)) {
                $links[] = [
                    'label' => $network['label'],
                    'icon' => $network['icon'],
                    'url' => $url,
                ];
            }
        }

        return $links;
    }

    /**
     * A setting holding an uploaded file, resolved to a public URL.
     */
    public static function image(string $key, ?string $default = null): ?string
    {
        $value = static::value($key);

        return filled($value) ? Storage::disk('public')->url($value) : $default;
    }

    public static function flushCache(): void
    {
        static::$cache = null;
    }

    public static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }
}
