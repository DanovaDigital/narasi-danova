<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_submission_form_can_be_rendered(): void
    {
        $response = $this->get(route('news.submission.form'));

        $response->assertOk();
        $response->assertSee('Ajukan Berita');
    }

    public function test_user_can_submit_news_submission(): void
    {
        $response = $this->post(route('news.submission'), [
            'name' => 'Rangga',
            'phone' => '628123456789',
            'email' => 'rangga@example.com',
            'subject' => 'Test',
            'message' => 'Hello',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('news_submissions', [
            'name' => 'Rangga',
            'phone' => '628123456789',
            'subject' => 'Test',
        ]);
    }
}
