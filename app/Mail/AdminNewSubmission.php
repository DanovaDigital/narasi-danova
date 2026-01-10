<?php

namespace App\Mail;

use App\Models\NewsSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NewsSubmission $submission) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New News Submission',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-new-submission',
            with: [
                'submission' => $this->submission,
            ],
        );
    }
}
