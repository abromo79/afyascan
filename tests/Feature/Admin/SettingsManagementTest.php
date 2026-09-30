<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingsManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_settings_page_is_reachable(): void
    {
        $this->get(route('admin.settings.edit'))->assertOk();
    }

    public function test_settings_can_be_saved(): void
    {
        $this->put(route('admin.settings.update'), [
            'site_name' => 'AfyaScan Health',
            'main_email' => 'hello@afyascan.com',
            'phone' => '+255 000 000 000',
            'address' => 'Zanzibar, Tanzania',
            'footer_text' => '© AfyaScan Health. All rights reserved.',
            'hero_title' => 'Advancing Breast Health Through AI',
            'hero_highlight' => 'Breast Health',
            'hero_description' => 'New hero description.',
            'hero_cta_label' => 'See our products',
            'hero_cta_url' => '/products',
        ])->assertRedirect(route('admin.settings.edit'));

        $this->assertDatabaseHas('site_settings', [
            'key' => 'site_name',
            'value' => 'AfyaScan Health',
        ]);

        SiteSetting::flushCache();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('AfyaScan Health')
            ->assertSee('New hero description.')
            ->assertSee('See our products');

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('hello@afyascan.com');
    }

    public function test_logo_and_favicon_can_be_uploaded(): void
    {
        Storage::fake('public');

        $this->put(route('admin.settings.update'), [
            'site_name' => 'AfyaScan',
            'site_logo_file' => UploadedFile::fake()->image('logo.png', 200, 60),
            'site_favicon_file' => UploadedFile::fake()->image('favicon.png', 64, 64),
        ])->assertRedirect(route('admin.settings.edit'));

        $logo = SiteSetting::where('key', 'site_logo')->value('value');
        $favicon = SiteSetting::where('key', 'site_favicon')->value('value');

        $this->assertNotNull($logo);
        $this->assertNotNull($favicon);

        Storage::disk('public')->assertExists($logo);
        Storage::disk('public')->assertExists($favicon);
    }

    public function test_saving_settings_keeps_existing_uploaded_files(): void
    {
        Storage::fake('public');

        $this->put(route('admin.settings.update'), [
            'site_logo_file' => UploadedFile::fake()->image('logo.png', 200, 60),
        ])->assertRedirect(route('admin.settings.edit'));

        $logo = SiteSetting::where('key', 'site_logo')->value('value');

        $this->put(route('admin.settings.update'), [
            'site_name' => 'AfyaScan Health',
        ])->assertRedirect(route('admin.settings.edit'));

        $this->assertSame($logo, SiteSetting::where('key', 'site_logo')->value('value'));
        $this->assertSame('AfyaScan Health', SiteSetting::where('key', 'site_name')->value('value'));

        Storage::disk('public')->assertExists($logo);
    }

    public function test_replacing_the_logo_deletes_the_previous_file(): void
    {
        Storage::fake('public');

        $this->put(route('admin.settings.update'), [
            'site_logo_file' => UploadedFile::fake()->image('old.png', 200, 60),
        ]);

        $previous = SiteSetting::where('key', 'site_logo')->value('value');

        $this->put(route('admin.settings.update'), [
            'site_logo_file' => UploadedFile::fake()->image('new.png', 200, 60),
        ]);

        $current = SiteSetting::where('key', 'site_logo')->value('value');

        $this->assertNotSame($previous, $current);
        Storage::disk('public')->assertMissing($previous);
        Storage::disk('public')->assertExists($current);
    }

    public function test_social_links_appear_in_the_footer_only_when_configured(): void
    {
        $this->get(route('home'))->assertDontSee('footer-social', false);

        $this->put(route('admin.settings.update'), [
            'facebook_url' => 'https://facebook.com/afyascan',
            'linkedin_url' => 'https://linkedin.com/company/afyascan',
        ])->assertRedirect(route('admin.settings.edit'));

        $this->assertSame(
            [
                ['label' => 'Facebook', 'icon' => 'bi-facebook', 'url' => 'https://facebook.com/afyascan'],
                ['label' => 'LinkedIn', 'icon' => 'bi-linkedin', 'url' => 'https://linkedin.com/company/afyascan'],
            ],
            SiteSetting::socialLinks()
        );

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('footer-social', false)
            ->assertSee('https://facebook.com/afyascan', false)
            ->assertSee('https://linkedin.com/company/afyascan', false)
            ->assertSee('bi-facebook', false);
    }

    public function test_editor_cannot_update_settings(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_EDITOR]));

        $this->put(route('admin.settings.update'), ['site_name' => 'Hacked'])
            ->assertForbidden();

        $this->assertDatabaseMissing('site_settings', ['key' => 'site_name']);
    }
}
