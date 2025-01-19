<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $firstName;

    public function __construct($verificationCode, $firstName)
    {
        $this->firstName = $firstName;
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->subject('Verify Your Email')
            ->view('emails.verification')
            ->with([
                'firstName' => $this->firstName,
                'verificationCode' => $this->verificationCode, // Pass verification code to the view
            ]);
    }
}