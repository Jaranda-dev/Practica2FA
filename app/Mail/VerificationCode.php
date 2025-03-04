<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;


   
    public $user;
    public $verificationCode;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $verificationCode
     */
    public function __construct(User $user, $verificationCode)
    {
        $this->user = $user;
        $this->verificationCode = $verificationCode;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Verification Code',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Código de Verificación')
                    ->view('emails.verificationCode')
                    ->with([
                        'user' => $this->user,
                        'code' => $this->verificationCode, // Código sin hashear
                    ]);
    }
}
