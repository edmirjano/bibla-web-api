<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassroomInvitationMail extends Mailable
{

    use Queueable, SerializesModels;

    public string $senderName;
    public string $senderEmail;
    public string $classroomName;
    public string $registerLink;

    /**
     * Create a new message instance.
     */
    public function __construct(string $senderName, string $senderEmail, string $classroomName, string $registerLink)
    {
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->classroomName = $classroomName;
        $this->registerLink = $registerLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Classroom Invitation')
            ->view('emails.classroom_invitation') // Blade template for email
            ->with([
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
                'classroomName' => $this->classroomName,
                'registerLink' => $this->registerLink,
            ]);
    }
}
