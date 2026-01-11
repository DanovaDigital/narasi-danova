<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_settings(): void
    {
        $response = $this->get(route('admin.settings.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_and_update_settings_and_upload_logo(): void
    {
        Storage::fake('public');

        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $index = $this->actingAs($admin, 'admin')->get(route('admin.settings.index'));
        $index->assertOk();
        $index->assertSee('Admin: Settings');

        $logo = UploadedFile::fake()->image('logo.png');

        $update = $this->actingAs($admin, 'admin')->put(route('admin.settings.update'), [
            'settings' => [
                'site_name' => 'Danova News',
                'whatsapp_number' => '6281234567890',
            ],
            'site_logo' => $logo,
        ]);

        $update->assertRedirect(route('admin.settings.index'));

        $this->assertDatabaseHas('site_settings', [
            'key' => 'site_name',
            'value' => 'Danova News',
        ]);

        $this->assertDatabaseHas('site_settings', [
            'key' => 'whatsapp_number',
            'value' => '6281234567890',
        ]);

        $path = SiteSetting::query()->where('key', 'site_logo')->value('value');
        $this->assertNotEmpty($path);
        Storage::disk('public')->assertExists($path);
    }
}
