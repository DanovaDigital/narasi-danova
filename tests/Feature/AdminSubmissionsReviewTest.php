<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\NewsSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSubmissionsReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_submissions(): void
    {
        $response = $this->get(route('admin.submissions.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_list_and_update_submission_status(): void
    {
        $admin = Admin::query()->create([
            'name' => 'Admin',
            'role' => 'super_admin',
        ]);

        $submission = NewsSubmission::query()->create([
            'name' => 'Reporter',
            'phone' => '081234567890',
            'email' => 'reporter@example.com',
            'subject' => 'Breaking',
            'message' => 'Something happened',
            'status' => 'pending',
        ]);

        $index = $this->actingAs($admin, 'admin')->get(route('admin.submissions.index'));
        $index->assertOk();
        $index->assertSee('Reporter');

        $show = $this->actingAs($admin, 'admin')->get(route('admin.submissions.show', $submission));
        $show->assertOk();
        $show->assertSee('Submission Detail');

        $update = $this->actingAs($admin, 'admin')->put(route('admin.submissions.update', $submission), [
            'status' => 'reviewed',
            'admin_notes' => 'Checked',
        ]);

        $update->assertRedirect(route('admin.submissions.show', $submission));

        $this->assertDatabaseHas('news_submissions', [
            'id' => $submission->id,
            'status' => 'reviewed',
            'admin_notes' => 'Checked',
            'reviewed_by' => $admin->id,
        ]);
    }
}
