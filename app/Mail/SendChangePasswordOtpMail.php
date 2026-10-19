<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class SendChangePasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('HostLok Change Password OTP')
            ->view('emails.change-password-otp');
    }
}
