<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class SendRenewalReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('HostLok Subscription Renewal Reminder')
            ->view('emails.renewal-reminder');
    }
}
