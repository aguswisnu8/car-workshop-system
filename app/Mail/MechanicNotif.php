<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MechanicNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $title;
    public $license;
    public $service;
    public $desc;


    /**
     * 
     *
     * @return void
     */
    public function __construct($title, $name, $license,  $service, $desc)
    {
        //
        $this->name = $name;
        $this->license = $license;
        $this->title = $title;
        $this->service = $service;
        $this->desc = $desc;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Mechanic New Service Job',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.mechanic',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
