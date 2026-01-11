<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSubscribersTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_subscribers(): void
    {
        $response = $this->get(route('admin.subscribers.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_subscribers_and_export_csv_and_delete(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $subscriber = Subscriber::query()->create([
            'email' => 'sub@example.com',
            'name' => 'Sub',
            'is_active' => true,
            'is_verified' => true,
        ]);

        $index = $this->actingAs($admin, 'admin')->get(route('admin.subscribers.index'));
        $index->assertOk();
        $index->assertSee('sub@example.com');

        $export = $this->actingAs($admin, 'admin')->get(route('admin.subscribers.export'));
        $export->assertOk();
        $export->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $csv = $export->streamedContent();
        $this->assertStringContainsString('sub@example.com', $csv);

        $delete = $this->actingAs($admin, 'admin')->delete(route('admin.subscribers.destroy', $subscriber));
        $delete->assertRedirect(route('admin.subscribers.index'));
        $this->assertDatabaseMissing('subscribers', ['email' => 'sub@example.com']);
    }
}
