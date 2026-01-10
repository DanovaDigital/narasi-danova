<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $newsletterId) {}

    public function handle(): void
    {
        $newsletter = Newsletter::query()->find($this->newsletterId);
        if (!$newsletter || !$newsletter->sent_at) {
            return;
        }

        Subscriber::query()
            ->where('is_active', true)
            ->where('is_verified', true)
            ->whereNull('unsubscribed_at')
            ->orderBy('id')
            ->chunk(500, function ($subscribers) use ($newsletter) {
                foreach ($subscribers as $subscriber) {
                    if (!$subscriber->email) {
                        continue;
                    }

                    Mail::to($subscriber->email)->send(new NewsletterMail($newsletter));
                }
            });
    }
}
