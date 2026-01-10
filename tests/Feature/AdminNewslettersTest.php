<?php

namespace Tests\Feature;

use App\Jobs\SendNewsletterJob;
use App\Models\Admin;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AdminNewslettersTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_newsletters(): void
    {
        $response = $this->get(route('admin.newsletters.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_save_draft_and_send_newsletter(): void
    {
        Queue::fake();

        $admin = Admin::query()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        Subscriber::query()->create([
            'email' => 'a@example.com',
            'is_active' => true,
            'is_verified' => true,
        ]);
        Subscriber::query()->create([
            'email' => 'b@example.com',
            'is_active' => true,
            'is_verified' => false,
        ]);
        Subscriber::query()->create([
            'email' => 'c@example.com',
            'is_active' => false,
            'is_verified' => true,
        ]);

        $draft = $this->actingAs($admin, 'admin')->post(route('admin.newsletters.store'), [
            'subject' => 'Draft Subject',
            'content' => 'Draft content',
            'action' => 'draft',
        ]);
        $draft->assertRedirect(route('admin.newsletters.index'));
        $this->assertDatabaseHas('newsletters', [
            'subject' => 'Draft Subject',
            'sent_count' => 0,
        ]);

        $send = $this->actingAs($admin, 'admin')->post(route('admin.newsletters.store'), [
            'subject' => 'Hello',
            'content' => 'World',
            'action' => 'send',
        ]);

        $send->assertRedirect(route('admin.newsletters.index'));

        $newsletter = Newsletter::query()->where('subject', 'Hello')->firstOrFail();
        $this->assertNotNull($newsletter->sent_at);
        $this->assertSame(1, (int) $newsletter->sent_count);

        Queue::assertPushed(SendNewsletterJob::class, function (SendNewsletterJob $job) use ($newsletter) {
            return $job->newsletterId === $newsletter->id;
        });
    }
}
