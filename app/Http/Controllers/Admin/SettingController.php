<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    use HandlesUploads;

    /**
     * The only website-wide settings worth managing.
     *
     * @var array<string, array{label: string, type: string}>
     */
    private const FIELDS = [
        'site_name' => ['label' => 'Website name', 'type' => 'text'],
        'site_logo' => ['label' => 'Logo', 'type' => 'image'],
        'site_favicon' => ['label' => 'Favicon', 'type' => 'image'],
        'main_email' => ['label' => 'Main email', 'type' => 'text'],
        'secondary_email' => ['label' => 'Partnerships email', 'type' => 'text'],
        'phone' => ['label' => 'Phone', 'type' => 'text'],
        'address' => ['label' => 'Address', 'type' => 'text'],
        'facebook_url' => ['label' => 'Facebook URL', 'type' => 'text'],
        'linkedin_url' => ['label' => 'LinkedIn URL', 'type' => 'text'],
        'twitter_url' => ['label' => 'X / Twitter URL', 'type' => 'text'],
        'instagram_url' => ['label' => 'Instagram URL', 'type' => 'text'],
        'youtube_url' => ['label' => 'YouTube URL', 'type' => 'text'],
        'footer_text' => ['label' => 'Footer text', 'type' => 'text'],
        'hero_title' => ['label' => 'Home hero title', 'type' => 'text'],
        'hero_highlight' => ['label' => 'Home hero highlighted words', 'type' => 'text'],
        'hero_description' => ['label' => 'Home hero description', 'type' => 'text'],
        'hero_media' => ['label' => 'Home hero image or video', 'type' => 'media'],
        'hero_cta_label' => ['label' => 'Home hero primary button label', 'type' => 'text'],
        'hero_cta_url' => ['label' => 'Home hero primary button URL', 'type' => 'text'],
    ];

    public function edit(): View
    {
        return view('admin.settings', [
            'fields' => self::FIELDS,
            'settings' => SiteSetting::all()->keyBy('key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (self::FIELDS as $key => $field) {
            if (self::isFileField($field['type'])) {
                $rules[$key.'_file'] = [
                    'nullable',
                    'file',
                    'mimes:'.self::mimesFor($field['type']),
                    'max:20480',
                ];

                continue;
            }

            $rules[$key] = ['nullable', 'string', 'max:2000'];
        }

        $data = $request->validate($rules);

        $order = 0;

        foreach (self::FIELDS as $key => $field) {
            $existing = SiteSetting::where('key', $key)->value('value');

            if (self::isFileField($field['type'])) {
                $value = $request->hasFile($key.'_file')
                    ? $this->storeImage($request->file($key.'_file'), 'settings', $existing)
                    : $existing;
            } else {
                $value = $request->exists($key) ? ($data[$key] ?? null) : $existing;
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $field['type'],
                    'display_order' => $order++,
                ]
            );
        }

        SiteSetting::flushCache();

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved.');
    }

    private static function isFileField(string $type): bool
    {
        return $type === 'image' || $type === 'media';
    }

    private static function mimesFor(string $type): string
    {
        return $type === 'media'
            ? 'jpg,jpeg,png,webp,svg,mp4,webm'
            : 'jpg,jpeg,png,webp,svg';
    }
}
