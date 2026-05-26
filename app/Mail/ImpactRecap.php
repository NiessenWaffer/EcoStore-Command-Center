<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ImpactRecap extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $token;
    public $waterSvg;
    public $carbonSvg;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $token, string $waterSvg, string $carbonSvg)
    {
        $this->order = $order;
        $this->token = $token;
        $this->waterSvg = $waterSvg;
        $this->carbonSvg = $carbonSvg;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your 24h Sustainability Impact Recap',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.impact_recap',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
