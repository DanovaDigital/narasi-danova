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
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticated('admin');
    }

    public function test_admin_can_logout(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->post('/admin/logout');

        $response->assertRedirect(route('admin.login', absolute: false));
        $this->assertGuest('admin');
    }
}
