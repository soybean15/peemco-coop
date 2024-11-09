<?php

namespace App\Mail;

use App\Services\Mails\GeneralMailTemplateService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GeneralNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $template;

    public function __construct( GeneralMailTemplateService $template)
    {
        $this->template= $template;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'General Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */

    public function content(): Content
    {    return new Content(
        view: 'mail.general-template',
        with: [
            'receiverName'=>$this->template->getRecipientName(),
            'senderName' => $this->template->getSenderName(),
            'mailMessage'=>$this->template->getMessage(),
            'otherMessages'=>$this->template->getOtherMessages(),
            'url'=>$this->template->getUrl(),
            'redirect_action'=>$this->template->getRedirectAction()
        ],
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
