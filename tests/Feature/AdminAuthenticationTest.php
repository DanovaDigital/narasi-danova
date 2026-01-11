<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
    }

    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        config(['news.admin_key' => 'test-admin-key']);

        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
            'pin_hash' => Hash::make('123456'),
        ]);

        $response = $this->post('/admin/login', [
            'admin_key' => 'test-admin-key',
            'pin' => '123456',
        ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticated('admin');
    }

    public function test_admin_can_logout(): void
    {
        config(['news.admin_key' => 'test-admin-key']);

        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->post('/admin/logout');

        $response->assertRedirect(route('admin.login', absolute: false));
        $this->assertGuest('admin');
    }
}
