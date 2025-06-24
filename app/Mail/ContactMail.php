<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $fileName;
    public function __construct($data,$fileName)
    {
        $this->data = $data;
        $this->fileName = $fileName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
         return new Content(
            view: 'email.contact',
            with: ['data' => $this->data] // Pass your data to the view
        );

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        $attachments = [];

        if($this->fileName){
             $attachments = [
                Attachment::fromPath(storage_path('app/public/uploads/'. $this->fileName))
             ];
        }

        return $attachments;
    }
}
