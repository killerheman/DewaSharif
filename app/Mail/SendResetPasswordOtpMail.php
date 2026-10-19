<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class SendResetPasswordOtpMail extends Mailable
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
        return $this->subject('HostLok Password Reset OTP')
            ->view('emails.reset-password-otp');
    }
}
