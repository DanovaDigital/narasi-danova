<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_categories(): void
    {
        $response = $this->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_create_category(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.categories.store'), [
            'name' => 'Teknologi',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Teknologi']);
    }

    public function test_admin_can_create_tag(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.tags.store'), [
            'name' => 'Laravel',
        ]);

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', ['name' => 'Laravel']);
    }
}
