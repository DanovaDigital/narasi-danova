<?php

namespace App\Mail;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Newsletter $newsletter) {}

    public function build()
    {
        return $this
            ->subject($this->newsletter->subject)
            ->view('emails.newsletter', [
                'newsletter' => $this->newsletter,
            ]);
    }
}
