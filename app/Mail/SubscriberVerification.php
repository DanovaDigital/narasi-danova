<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriberVerification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Subscriber $subscriber) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Subscription Newsletter',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscriber-verification',
            with: [
                'subscriber' => $this->subscriber,
                'verifyUrl' => route('subscribe.verify', $this->subscriber->verification_token),
                'unsubscribeUrl' => route('unsubscribe', $this->subscriber->unsubscribe_token),
            ],
        );
    }
}
